<?php

namespace App\Http\Controllers;

use App\Mail\ReservationConfirmedMail;
use App\Models\Cours;
use App\Models\Disponibilite;
use App\Models\Reservation;
use App\Services\JitsiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    protected JitsiService $jitsiService;

    public function __construct(JitsiService $jitsiService)
    {
        $this->jitsiService = $jitsiService;
    }

    /**
     * Map day names between English Carbon / PHP day names and French strings stored in DB.
     */
    protected array $frenchDays = [
        'Monday'    => 'Lundi',
        'Tuesday'   => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday'  => 'Jeudi',
        'Friday'    => 'Vendredi',
        'Saturday'  => 'Samedi',
        'Sunday'    => 'Dimanche',
    ];

    /**
     * Display a listing of reservations for the logged-in user.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $reservations = Reservation::with(['course.professeur', 'course.mode'])
            ->where('user_id', $user->id)
            ->orderBy('date_reservation', 'desc')
            ->orderBy('heure_debut', 'desc')
            ->paginate(15);

        return view('learner.reservations', compact('reservations'));
    }

    /**
     * API endpoint to get professor availabilities for a specific course.
     */
    public function getSlotsForCourse($coursId)
    {
        $cours = Cours::with(['professeur', 'mode'])->findOrFail($coursId);
        $professeurId = $cours->user_id;

        $now = now();
        $disponibilites = Disponibilite::where('professeur_id', $professeurId)
            ->where(function ($q) {
                $q->whereNull('statut')
                  ->orWhere('statut', 'actif')
                  ->orWhere('statut', 'Actif');
            })
            ->whereDate('date_dispo', '>=', $now->toDateString())
            ->orderBy('date_dispo')
            ->orderBy('debut')
            ->get(['id', 'date_dispo', 'jour', 'debut', 'fin', 'statut']);

        $disponibilites = $disponibilites->filter(function ($dispo) use ($now) {
            if ($dispo->date_dispo == $now->toDateString()) {
                return $dispo->debut > $now->format('H:i');
            }
            return true;
        })->values();

        return response()->json([
            'cours' => [
                'id' => $cours->id,
                'titre' => $cours->titre,
                'professeur' => $cours->professeur ? $cours->professeur->name : 'Professeur',
                'tarif' => $cours->tarif,
                'duree' => $cours->duree,
                'mode' => $cours->mode ? $cours->mode->libelle : 'Présentiel',
            ],
            'disponibilites' => $disponibilites,
        ]);
    }

    /**
     * Store a new student reservation after validating professor availability.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'date_reservation' => 'required|date|after_or_equal:today',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
        ], [
            'heure_fin.after' => 'L\'heure de fin doit être supérieure à l\'heure de début.',
            'heure_debut.date_format' => 'Format d\'heure de début invalide.',
            'heure_fin.date_format' => 'Format d\'heure de fin invalide.',
            'date_reservation.after_or_equal' => 'La date de réservation ne peut pas être dans le passé.',
        ]);

        $now = now();
        if (Carbon::parse($request->date_reservation)->isToday() && $request->heure_debut <= $now->format('H:i')) {
            return back()->withErrors([
                'heure_debut' => "L'heure de réservation ne peut pas être dans le passé."
            ])->withInput();
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour réserver un cours.');
        }

        $cours = Cours::with('mode')->findOrFail($request->cours_id);
        $professeurId = $cours->user_id;

        // Check if professor is available on this specific date and time range
        $matchingDispo = Disponibilite::where('professeur_id', $professeurId)
            ->where('date_dispo', $request->date_reservation)
            ->where(function ($q) {
                $q->whereNull('statut')
                  ->orWhere('statut', 'actif')
                  ->orWhere('statut', 'Actif');
            })
            ->where('debut', '<=', $request->heure_debut)
            ->where('fin', '>=', $request->heure_fin)
            ->first();

        if (!$matchingDispo) {
            return back()->withErrors([
                'availability' => "Le professeur n'est pas disponible le " . Carbon::parse($request->date_reservation)->format('d/m/Y') . " entre {$request->heure_debut} et {$request->heure_fin}. Veuillez choisir un créneau figurant dans ses disponibilités."
            ])->withInput();
        }

        // Check for duplicate reservation by the SAME user at the SAME slot (Unicité par apprenant)
        $existing = Reservation::where('cours_id', $cours->id)
            ->where('user_id', $user->id)
            ->where('date_reservation', $request->date_reservation)
            ->where('heure_debut', $request->heure_debut)
            ->first();

        if ($existing) {
            return back()->with('error', 'Vous avez déjà effectué une réservation pour ce créneau de cours.');
        }

        // Generate secure Jitsi Room ID if course is online/distanciel
        $isDistanciel = $cours->mode && (
            Str::contains(strtolower($cours->mode->libelle), ['distanciel', 'ligne', 'online', 'visio', 'remote'])
        );
        $jitsiRoomId = null;
        if ($isDistanciel) {
            $jitsiRoomId = $this->jitsiService->generateSecureRoomName($cours->id, $request->date_reservation, $user->id, $request->heure_debut);
        }

        $reservation = Reservation::create([
            'cours_id' => $cours->id,
            'user_id' => $user->id,
            'date_reservation' => $request->date_reservation,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'disponibilite_id' => $matchingDispo->id,
            'status' => 'accepted',
            'jitsi_room_id' => $jitsiRoomId,
        ]);

        // Try sending confirmation email
        try {
            Mail::to($user->email)->send(new ReservationConfirmedMail($reservation));
        } catch (\Exception $e) {
            // Log mail exception if needed, continue gracefullly
        }

        return back()->with('success', "Votre réservation pour le cours '{$cours->titre}' le {$dateCarbon->format('d/m/Y')} de {$request->heure_debut} à {$request->heure_fin} a été validée avec succès ! Un e-mail de confirmation vous a été envoyé.");
    }

    /**
     * Remove the specified reservation.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $reservation = Reservation::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $reservation->delete();

        return back()->with('success', 'Votre réservation a été annulée avec succès.');
    }
}
