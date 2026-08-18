<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\JitsiService;
use Illuminate\Support\Facades\Auth;

class VisioController extends Controller
{
    protected JitsiService $jitsiService;

    public function __construct(JitsiService $jitsiService)
    {
        $this->jitsiService = $jitsiService;
    }

    /**
     * Join secure Jitsi Meet videoconference session.
     */
    public function joinSession(Reservation $reservation)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à votre cours.');
        }

        // Check security: Only the enrolled student, professor, or admin can access
        $isStudent = ($reservation->user_id === $user->id);
        $isTeacher = ($reservation->course && $reservation->course->user_id === $user->id);
        $isAdmin = ($user->profil && in_array(strtolower($user->profil->libelle), ['admin', 'administrateur']));

        if (!$isStudent && !$isTeacher && !$isAdmin) {
            abort(403, 'Accès refusé. Ce salon de visioconférence est strictement réservé à l\'apprenant inscrit et au professeur.');
        }

        // Ensure room ID exists
        if (!$reservation->jitsi_room_id) {
            $roomName = 'EchoCulture_Course_' . $reservation->cours_id . '_' . $reservation->id . '_' . Str::random(10);
            $reservation->update(['jitsi_room_id' => $roomName]);
        }

        // Generate secure meeting URL with JWT
        $isModerator = $isTeacher || $isAdmin;
        $meetingUrl = $this->jitsiService->generateMeetingUrl(
            $reservation->jitsi_room_id,
            $user,
            $isModerator
        );

        return view('meeting.show', [
            'reservation' => $reservation,
            'meetingUrl' => $meetingUrl,
            'isModerator' => $isModerator,
        ]);
    }

    /**
     * View secure course replay.
     */
    public function viewReplay(Reservation $reservation)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $isStudent = ($reservation->user_id === $user->id);
        $isTeacher = ($reservation->course && $reservation->course->user_id === $user->id);
        $isAdmin = ($user->profil && in_array(strtolower($user->profil->libelle), ['admin', 'administrateur']));

        if (!$isStudent && !$isTeacher && !$isAdmin) {
            abort(403, 'Accès refusé à cet enregistrement.');
        }

        if (!$reservation->lien_replay) {
            return back()->with('error', 'Aucun enregistrement n\'est disponible pour ce cours pour le moment.');
        }

        return view('visio.replay', [
            'reservation' => $reservation,
            'cours' => $reservation->course,
        ]);
    }

    /**
     * Store course replay link (Professor action).
     */
    public function storeReplay(Request $request, Reservation $reservation)
    {
        $user = Auth::user();

        $isTeacher = ($reservation->course && $reservation->course->user_id === $user->id);
        $isAdmin = ($user->profil && in_array(strtolower($user->profil->libelle), ['admin', 'administrateur']));

        if (!$isTeacher && !$isAdmin) {
            abort(403, 'Seul le professeur du cours peut enregistrer ou publier un replay.');
        }

        $request->validate([
            'lien_replay' => 'required|url',
            'description_replay' => 'nullable|string|max:1000',
        ], [
            'lien_replay.required' => 'Le lien de l\'enregistrement vidéo est obligatoire.',
            'lien_replay.url' => 'Le lien doit être une URL valide (ex: YouTube, Vimeo, Drive, etc.).',
        ]);

        $reservation->update([
            'lien_replay' => $request->lien_replay,
            'description_replay' => $request->description_replay,
        ]);

        return back()->with('success', 'L\'enregistrement du cours a été sauvegardé avec succès et est désormais accessible aux apprenants inscrits.');
    }
}
