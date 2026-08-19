<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationAccepted;
use App\Mail\ReservationRefused;
use App\Mail\ReservationReportProposed;

class ReservationActionController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function accept($id, \App\Services\JitsiService $jitsiService)
    {
        $reservation = Reservation::findOrFail($id);

        $cours = $reservation->course;
        $isOnline = $cours->mode && (
            \Illuminate\Support\Str::contains(strtolower($cours->mode->libelle), ['distanciel', 'hybride', 'ligne', 'online', 'visio', 'remote'])
        );

        if ($isOnline && !$reservation->jitsi_room_id) {
            $reservation->jitsi_room_id = $jitsiService->generateSecureRoomName($cours->id, $reservation->date_reservation, $reservation->user_id, $reservation->heure_debut);
        }

        $reservation->status = 'accepted';
        $reservation->save();

        // Send email notification
        Mail::to($reservation->user->email)->queue(new ReservationAccepted($reservation));

        // Create in-app notification
        $this->notificationService->notifyReservationAccepted(
            $reservation->user,
            $cours->titre,
            \Carbon\Carbon::parse($reservation->date_reservation)->translatedFormat('d/m/Y'),
            \Carbon\Carbon::parse($reservation->heure_debut)->format('H:i'),
            $reservation->id
        );

        return back()->with('success', 'Réservation acceptée');
    }

    public function refuse($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'refused';
        $reservation->save();

        // Send email notification
        Mail::to($reservation->user->email)->queue(new ReservationRefused($reservation));

        // Create in-app notification
        $this->notificationService->notifyReservationRefused(
            $reservation->user,
            $reservation->course->titre,
            '',
            $reservation->id
        );

        return back()->with('success', 'Réservation refusée');
    }

    public function proposeReport($id, Request $request)
    {
        $reservation = Reservation::findOrFail($id);

        $data = $request->validate([
            'new_date' => 'required|date',
            'new_time' => 'required|date_format:H:i',
            'new_time_end' => 'nullable|date_format:H:i',
            'message' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $isProf = ($reservation->course->user_id === $user->id);

        if ($isProf) {
            $reservation->status = 'pending_student';
            $recipient = $reservation->user;
            $recipientEmail = $reservation->user->email;
        } else {
            $reservation->status = 'pending_teacher';
            $recipient = $reservation->course->professeur;
            $recipientEmail = $reservation->course->professeur->email ?? null;
        }

        $newStart = \Carbon\Carbon::parse($data['new_date'] . ' ' . $data['new_time']);

        if (!empty($data['new_time_end'])) {
            $newEnd = \Carbon\Carbon::parse($data['new_date'] . ' ' . $data['new_time_end']);
        } else {
            // Calculate duration to update heure_fin
            $oldStart = \Carbon\Carbon::parse($reservation->date_reservation . ' ' . $reservation->heure_debut);
            $oldEnd = \Carbon\Carbon::parse($reservation->date_reservation . ' ' . $reservation->heure_fin);
            $durationMinutes = $oldStart->diffInMinutes($oldEnd);
            $newEnd = $newStart->copy()->addMinutes($durationMinutes);
        }

        $reservation->date_reservation = $newStart->format('Y-m-d');
        $reservation->heure_debut = $newStart->format('H:i:s');
        $reservation->heure_fin = $newEnd->format('H:i:s');
        $reservation->report_proposed_at = now();
        $reservation->save();

        // Create Discussion Entry
        \App\Models\ReservationDiscussion::create([
            'reservation_id' => $reservation->id,
            'sender_id' => $user->id,
            'message' => $data['message'] ?? null,
            'proposed_date' => $newStart->format('Y-m-d'),
            'proposed_start_time' => $newStart->format('H:i:s'),
            'proposed_end_time' => $newEnd->format('H:i:s'),
        ]);

        // Send email notification
        if ($recipientEmail) {
            try {
                Mail::to($recipientEmail)->queue(new ReservationReportProposed($reservation, $data));
            } catch (\Exception $e) {}
        }

        // Create in-app notification
        if ($recipient) {
            $this->notificationService->notifyReservationReport(
                $recipient,
                $reservation->course->titre,
                $newStart->translatedFormat('d/m/Y'),
                $newStart->format('H:i'),
                $user->name,
                $reservation->id
            );
        }

        if ($isProf) {
            return redirect()->route('dashboard.professeur.reservations')->with('success', 'Nouvel horaire proposé avec succès.');
        } else {
            return redirect()->route('dashboard.apprenant.reservations')->with('success', 'Nouvel horaire proposé avec succès.');
        }
    }

    public function showDiscussions($id)
    {
        $reservation = Reservation::with(['course.professeur', 'user', 'discussions.sender'])->findOrFail($id);
        // On vérifie que l'utilisateur connecté est bien lié à la réservation (soit le prof, soit l'élève)
        $user = Auth::user();
        $isProf = ($reservation->course->user_id === $user->id);
        $isApprenant = ($reservation->user_id === $user->id);

        if (!$isProf && !$isApprenant) {
            abort(403);
        }

        return view('shared.reservations.discussions', compact('reservation', 'user'));
    }
}
?>
