<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Services\JitsiService;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    protected JitsiService $jitsiService;

    public function __construct(JitsiService $jitsiService)
    {
        $this->jitsiService = $jitsiService;
    }

    /**
     * Génère l'URL sécurisée
     */
    public function show($reservationId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à la réunion.');
        }

        $reservation = Reservation::with(['course', 'course.professeur'])->findOrFail($reservationId);

        // Vérifier que l'utilisateur a le droit d'accéder
        if (!$this->jitsiService->canAccessRoom($user, $reservation)) {
            abort(403, 'Vous n\'avez pas accès à cette réunion.');
        }

        // Vérifier si le cours peut commencer
        // if (!$this->jitsiService->canStartMeeting($reservation)) {
        //     $meetingStart = $reservation->date_reservation . ' ' . $reservation->heure_debut;
        //     return back()->with('error', "La réunion n'est pas encore accessible. Elle sera disponible 5 minutes avant l'heure prévue : " . \Carbon\Carbon::parse($meetingStart)->format('d/m/Y à H:i'));
        // }

        // Vérifier si le cours est terminé
        if ($this->jitsiService->isMeetingEnded($reservation)) {
            return back()->with('error', 'Cette réunion est terminée.');
        }

        // Déterminer si l'utilisateur est modérateur (professeur)
        $isModerator = $reservation->course->user_id === $user->id;

        // Générer l'URL sécurisée avec JWT
        $meetingUrl = $this->jitsiService->generateMeetingUrl(
            $reservation->jitsi_room_id,
            $user,
            $isModerator
        );

        return view('meeting.show', compact('reservation', 'meetingUrl', 'isModerator'));
    }

    /**
     * Régénérer le token JWT (en cas de problème)
     */
    public function regenerateToken(Request $request, $reservationId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Non authentifié'], 401);
        }

        $reservation = Reservation::findOrFail($reservationId);

        // Seul le professeur peut régénérer le token
        if ($reservation->course->user_id !== $user->id) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Régénérer l'URL avec un nouveau token
        $isModerator = $reservation->course->user_id === $user->id;
        $newMeetingUrl = $this->jitsiService->generateMeetingUrl(
            $reservation->jitsi_room_id,
            $user,
            $isModerator
        );

        return response()->json(['success' => true, 'meetingUrl' => $newMeetingUrl]);
    }
}
