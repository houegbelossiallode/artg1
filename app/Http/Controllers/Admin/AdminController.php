<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Talent;
use App\Models\CategorieTalent;
use App\Models\CategorieCours;
use App\Models\CategorieEvenement;

class AdminController extends Controller
{
    /**
     * Display Admin Dashboard with dynamic metrics and resources.
     */
    public function index()
    {
        $categorieTalents = CategorieTalent::all();
        $categorieCours = CategorieCours::all();
        $categorieEvenements = CategorieEvenement::all();
        
        $professeurs = User::whereHas('profil', function ($query) {
            $query->where('nom', 'professeur');
        })->latest()->get();

        $recentUsers = User::with('profil')->latest()->take(10)->get();
        $talents = Talent::with('category')->latest()->get();

        $totalUsers = User::count();
        $totalProfesseurs = $professeurs->count();
        $totalTalents = $talents->count();

        return view('dashboards.admin', compact(
            'categorieTalents',
            'categorieCours',
            'categorieEvenements',
            'professeurs',
            'recentUsers',
            'talents',
            'totalUsers',
            'totalProfesseurs',
            'totalTalents'
        ));
    }

    /**
     * Display the admin profile page.
     */
    public function profile()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the admin profile.
     */
    public function updateProfile(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

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
}
