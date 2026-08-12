<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Cours;
use App\Models\CategorieCours;
use App\Models\Mode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the learner dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $reservations = Reservation::with(['course.professeur', 'course.mode', 'course.supports'])
            ->where('user_id', $user->id)
            ->orderBy('date_reservation', 'desc')
            ->take(5)
            ->get();

        $prochainCours = Reservation::with(['course.professeur', 'course.mode'])
            ->where('user_id', $user->id)
            ->where('date_reservation', '>=', now()->toDateString())
            ->orderBy('date_reservation', 'asc')
            ->first();

        // Get IDs of courses the user has already reserved to allow support downloads from catalog
        $reservedCoursIds = Reservation::where('user_id', $user->id)->pluck('cours_id')->toArray();

        $cours = Cours::with(['categorie', 'mode', 'professeur', 'supports'])->latest()->paginate(6, ['*'], 'cours_page');
        $categoriesCours = CategorieCours::all();
        $modes = Mode::all();

        return view('dashboards.apprenant', compact('reservations', 'prochainCours', 'cours', 'categoriesCours', 'modes', 'reservedCoursIds'));
    }

    /**
     * Display course catalog inside learner dashboard.
     */
    public function cours()
    {
        $user = Auth::user();
        $cours = Cours::with(['categorie', 'mode', 'professeur', 'supports'])->latest()->paginate(7);
        $categoriesCours = CategorieCours::all();
        $modes = Mode::all();
        
        $reservedCoursIds = Reservation::where('user_id', $user->id)->pluck('cours_id')->toArray();

        return view('learner.cours', compact('cours', 'categoriesCours', 'modes', 'reservedCoursIds'));
    }

    /**
     * Show learner profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('learner.profile', compact('user'));
    }

    /**
     * Update the learner profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'sexe' => 'nullable|in:H,F',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'sexe' => $validated['sexe'] ?? null,
            'adresse' => $validated['adresse'] ?? null,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('profils', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Vos coordonnées ont été mises à jour avec succès.');
    }

    /**
     * List learner reservations.
     */
    public function reservations()
    {
        $user = Auth::user();
        $reservations = Reservation::with(['course.professeur', 'course.mode', 'course.supports'])
            ->where('user_id', $user->id)
            ->orderBy('date_reservation', 'desc')
            ->paginate(10);

        return view('learner.reservations', compact('reservations'));
    }

    /**
     * Show upcoming events for learner.
     */
    public function upcoming()
    {
        return view('learner.upcoming');
    }

    /**
     * List learner supports.
     */
    public function supports()
    {
        return view('learner.supports');
    }

    /**
     * Download a support file.
     */
    public function downloadSupport($id)
    {
        $user = Auth::user();
        $support = \App\Models\SupportCours::findOrFail($id);
        
        // Ensure user has reserved the course for this support
        $hasReservation = Reservation::where('user_id', $user->id)
            ->where('cours_id', $support->cours_id)
            ->exists();
            
        if (!$hasReservation) {
            abort(403, "Vous n'avez pas accès à ce support.");
        }

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($support->fichier)) {
            return back()->with('error', "Le fichier du support est introuvable.");
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($support->fichier);
    }
}
