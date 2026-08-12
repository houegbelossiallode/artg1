<?php

namespace App\Http\Controllers\Professeur;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Reservation;
use App\Models\User;
use App\Models\SupportCours;
use App\Models\Disponibilite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfesseurController extends Controller
{
    /** Dashboard */
    public function index()
    {
        $prof = Auth::user();
        $coursCount = Cours::where('user_id', $prof->id)->count();
        $reservationCount = Reservation::whereHas('course', fn($q) => $q->where('user_id', $prof->id))->count();
        $eleveCount = User::whereHas('reservations.course', fn($q) => $q->where('user_id', $prof->id))->distinct()->count();
        $eleves = User::whereHas('reservations.course', fn($q) => $q->where('user_id', $prof->id))->distinct()->get();
        return view('dashboards.professeur', compact('prof', 'coursCount', 'reservationCount', 'eleveCount', 'eleves'));
    }

    /** List students */
    public function eleves()
    {
        $prof = Auth::user();
        $eleves = User::whereHas('reservations.course', fn($q) => $q->where('user_id', $prof->id))
            ->distinct()
            ->get();
        return view('professeur.eleves.index', compact('eleves'));
    }

    /** Student tracking detail page */
    public function suiviEleve($id)
    {
        $prof = Auth::user();
        $eleve = User::findOrFail($id);

        // Get only reservations for this professor's courses
        $reservations = Reservation::where('user_id', $eleve->id)
            ->whereHas('course', fn($q) => $q->where('user_id', $prof->id))
            ->with('course')
            ->latest()
            ->get();

        // Statistics
        $stats = [
            'total'    => $reservations->count(),
            'accepted' => $reservations->where('status', 'accepted')->count(),
            'pending'  => $reservations->where('status', 'pending')->count(),
            'refused'  => $reservations->where('status', 'refused')->count(),
            'proposed' => $reservations->where('status', 'proposed')->count(),
        ];

        return view('professeur.eleves.suivi', compact('eleve', 'reservations', 'stats'));
    }

    /** List professor's own courses */
    public function cours()
    {
        $prof = Auth::user();
        $cours = Cours::where('user_id', $prof->id)
            ->with(['categorie', 'mode'])
            ->withCount('supports')
            ->latest()
            ->get();
        return view('professeur.cours.index', compact('cours'));
    }

    /** List supports */
    public function supports()
    {
        $prof = Auth::user();
        $coursList = Cours::where('user_id', $prof->id)->get();
        $supports = SupportCours::whereHas('cours', fn($q) => $q->where('user_id', $prof->id))
            ->with('cours')
            ->latest()
            ->get();
        return view('professeur.supports.index', compact('supports', 'coursList'));
    }

    /** Store new support */
    public function storeSupport(Request $request)
    {
        $request->validate([
            'cours_id'    => 'required|exists:cours,id',
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'fichier'     => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,mp4,mp3,png,jpg,jpeg|max:20480',
            'type'        => 'required|in:document,video,audio,image,autre',
        ]);

        $path = $request->file('fichier')->store('supports', 'public');

        SupportCours::create([
            'cours_id'    => $request->cours_id,
            'titre'       => $request->titre,
            'description' => $request->description,
            'fichier'     => $path,
            'type'        => $request->type,
            'actif'       => 'OUI',
        ]);

        return redirect()->route('professeur.supports')->with('success', 'Support ajouté avec succès.');
    }

    /** Update existing support */
    public function updateSupport(Request $request, SupportCours $support)
    {
        $request->validate([
            'cours_id'    => 'required|exists:cours,id',
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'fichier'     => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,mp4,mp3,png,jpg,jpeg|max:20480',
            'type'        => 'required|in:document,video,audio,image,autre',
        ]);

        $data = [
            'cours_id'    => $request->cours_id,
            'titre'       => $request->titre,
            'description' => $request->description,
            'type'        => $request->type,
        ];

        if ($request->hasFile('fichier')) {
            // Delete old file
            if ($support->fichier && Storage::disk('public')->exists($support->fichier)) {
                Storage::disk('public')->delete($support->fichier);
            }
            $data['fichier'] = $request->file('fichier')->store('supports', 'public');
        }

        $support->update($data);

        return redirect()->route('professeur.supports')->with('success', 'Support mis à jour avec succès.');
    }

    /** Delete a support */
    public function destroySupport(SupportCours $support)
    {
        // Delete the physical file
        if ($support->fichier && Storage::disk('public')->exists($support->fichier)) {
            Storage::disk('public')->delete($support->fichier);
        }
        $support->delete();
        return redirect()->route('professeur.supports')->with('success', 'Support supprimé avec succès.');
    }

    /** List reservations */
    public function reservations()
    {
        $prof = Auth::user();
        $reservations = Reservation::whereHas('course', fn($q) => $q->where('user_id', $prof->id))
            ->with(['course', 'user'])
            ->get();
        return view('professeur.reservations.index', compact('reservations'));
    }

    /** Profile Page */
    public function profile()
    {
        $user = Auth::user();
        return view('professeur.profile', compact('user'));
    }

    /** Update Profile */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'sexe' => 'nullable|in:H,F',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->prenom = $request->prenom;
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->sexe = $request->sexe;
        $user->telephone = $request->telephone;
        $user->adresse = $request->adresse;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('profiles', 'public');
            $user->photo = $path;
        }

        $user->save();

        return back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }
}
