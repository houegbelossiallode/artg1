<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VisioController extends Controller
{
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

        return view('visio.room', [
            'reservation' => $reservation,
            'cours' => $reservation->course,
            'jitsiRoomName' => $reservation->jitsi_room_id,
            'userName' => $user->name,
            'isTeacher' => $isTeacher,
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
