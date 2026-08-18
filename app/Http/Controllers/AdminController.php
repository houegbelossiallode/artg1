<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Talent;
use App\Models\CategorieTalent;
use App\Models\CategorieCours;
use App\Models\CategorieEvenement;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display Admin Dashboard with dynamic data.
     */
    public function index()
    {
        $categorieTalents = CategorieTalent::all();
        $categorieCours = CategorieCours::all();
        $categorieEvenements = CategorieEvenement::all();
        
        $professeurs = User::whereHas('profil', function ($query) {
            $query->where('nom', 'professeur');
        })->latest()->get();

        $recentUsers = User::with('profil')->latest()->take(5)->get();
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
     * Store a new Professor.
     */
    public function storeProfesseur(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'sexe' => ['required', 'string', 'in:M,F'],
            'date_naissance' => ['required', 'date'],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['required', 'string', 'max:255'],
            'biographie' => ['nullable', 'string'],
        ], [
            'email.unique' => 'Cet email est déjà attribué à un autre compte.',
        ]);

        $generatedPassword = \Illuminate\Support\Str::random(10);
        $profil = Profil::where('nom', 'professeur')->first();
        if(!$profil){
            return redirect()->back()->with('error', 'Le profil professeur n\'existe pas');
        }

        $professeur = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($generatedPassword),
            'sexe' => $request->sexe,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'biographie' => $request->biographie,
            'profil_id' => $profil->id,
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($professeur->email)
                ->send(new \App\Mail\ProfesseurCreated($professeur, $generatedPassword));
        } catch (\Exception $e) {
            // Log error if needed
        }

        return redirect()->route('dashboard.admin')->with('success', 'Le professeur ' . $request->prenom . ' ' . $request->nom . ' a été enregistré avec succès et ses identifiants lui ont été envoyés par email !');
    }

    /**
     * Store a new Talent.
     */
    public function storeTalent(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'categorie_talent_id' => ['required', 'exists:categorie_talents,id'],
            'biographie' => ['nullable', 'string'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('talents', 'public');
        }

        Talent::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'categorie_talent_id' => $request->categorie_talent_id,
            'biographie' => $request->biographie,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'photo' => $photoPath,
            'actif' => 'oui',
        ]);

        return redirect()->route('dashboard.admin')->with('success', 'Le talent ' . $request->prenom . ' ' . $request->nom . ' a été créé avec succès !');
    }

    /**
     * Store a new Category.
     */
    public function storeCategorie(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', 'in:cours,evenement,talent'],
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        if ($request->type === 'cours') {
            CategorieCours::create([
                'nom' => $request->nom,
                'description' => $request->description,
                'actif' => 'oui',
            ]);
            $label = 'cours';
        } elseif ($request->type === 'evenement') {
            CategorieEvenement::create([
                'libelle' => $request->nom,
                'actif' => 'oui',
            ]);
            $label = 'événements';
        } else {
            CategorieTalent::create([
                'libelle' => $request->nom,
                'actif' => 'oui',
            ]);
            $label = 'talents';
        }

        return redirect()->route('dashboard.admin')->with('success', 'La catégorie de ' . $label . ' "' . $request->nom . '" a été enregistrée avec succès !');
    }
}
