<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cours;
use App\Models\CategorieCours;
use App\Models\User;
use App\Models\Mode;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::with(['category', 'teacher', 'mode'])->latest('id')->get();
        $categories = CategorieCours::all();
        $professeurs = User::whereHas('profil', function ($query) {
            $query->where('nom', 'professeur');
        })->get();
        // If no explicit user has role 'professeur', fallback to all active users
        if ($professeurs->isEmpty()) {
            $professeurs = User::all();
        }
        $modes = Mode::all();

        return view('admin.cours.index', compact('cours', 'categories', 'professeurs', 'modes'));
    }

    public function create()
    {
        return redirect()->route('dashboard.admin.cours.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'categorie_cours_id' => ['required', 'exists:categorie_cours,id'],
            'user_id' => ['required', 'exists:users,id'],
            'mode_id' => ['required', 'exists:modes,id'],
            'date_cours' => ['required', 'date'],
            'heure_debut' => ['required'],
            'heure_fin' => ['required'],
            'tarif' => ['required', 'numeric', 'min:0'],
            'lieu' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Calculate duration in minutes if not specified
        $duree = 60;
        if ($request->heure_debut && $request->heure_fin) {
            $start = strtotime($request->heure_debut);
            $end = strtotime($request->heure_fin);
            if ($end > $start) {
                $duree = round(($end - $start) / 60);
            }
        }

        $coursItem = Cours::create([
            'titre' => $request->titre,
            'categorie_cours_id' => $request->categorie_cours_id,
            'user_id' => $request->user_id,
            'mode_id' => $request->mode_id,
            'lieu' => $request->lieu,
            'date_cours' => $request->date_cours,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'duree' => $duree,
            'tarif' => $request->tarif,
            'description' => $request->description,
            'actif' => $request->actif ?? 'OUI',
        ]);

        return redirect()->route('dashboard.admin.cours.index')->with('success', 'Le cours "' . $coursItem->titre . '" a été créé avec succès !');
    }

    public function show($id)
    {
        return redirect()->route('dashboard.admin.cours.index');
    }

    public function edit($id)
    {
        return redirect()->route('dashboard.admin.cours.index');
    }

    public function update(Request $request, $id)
    {
        $coursItem = Cours::findOrFail($id);

        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'categorie_cours_id' => ['required', 'exists:categorie_cours,id'],
            'user_id' => ['required', 'exists:users,id'],
            'mode_id' => ['required', 'exists:modes,id'],
            'date_cours' => ['required', 'date'],
            'heure_debut' => ['required'],
            'heure_fin' => ['required'],
            'tarif' => ['required', 'numeric', 'min:0'],
            'lieu' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $duree = 60;
        if ($request->heure_debut && $request->heure_fin) {
            $start = strtotime($request->heure_debut);
            $end = strtotime($request->heure_fin);
            if ($end > $start) {
                $duree = round(($end - $start) / 60);
            }
        }

        $coursItem->update([
            'titre' => $request->titre,
            'categorie_cours_id' => $request->categorie_cours_id,
            'user_id' => $request->user_id,
            'mode_id' => $request->mode_id,
            'lieu' => $request->lieu,
            'date_cours' => $request->date_cours,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'duree' => $duree,
            'tarif' => $request->tarif,
            'description' => $request->description,
            'actif' => $request->actif ?? 'OUI',
        ]);

        return redirect()->route('dashboard.admin.cours.index')->with('success', 'Cours mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $coursItem = Cours::findOrFail($id);
        $coursItem->delete();

        return redirect()->route('dashboard.admin.cours.index')->with('success', 'Cours supprimé avec succès.');
    }
}
