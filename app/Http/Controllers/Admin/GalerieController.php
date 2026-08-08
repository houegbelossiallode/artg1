<?php

namespace App\Http\Controllers\Admin;

use App\Models\Galerie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategorieGalerie;
use App\Http\Controllers\Controller;

class GalerieController extends Controller
{
    /**
     * Display a listing of galeries.
     */
    public function index()
    {
        $galeries = Galerie::with('categorie')->latest()->get();
        $categories = CategorieGalerie::where('actif', 'OUI')->orWhere('actif', 'oui')->get();
        
        return view('admin.galeries.index', compact('galeries', 'categories'));
    }

    /**
     * Show the form for creating a new galerie.
     */
    public function create()
    {
        $categories = CategorieGalerie::all();
        return view('admin.galeries.create', compact('categories'));
    }

    /**
     * Store a newly created galerie in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'fichier' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,mp4,webm,mp3,wav', 'max:102400'],
            'categorie_galerie_id' => ['required', 'exists:categorie_galeries,id'],
        ]);

        $fichierPath = null;
        if ($request->hasFile('fichier')) {
            $fichierPath = $request->file('fichier')->store('galeries', 'public');
        }

        Galerie::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'fichier' => $fichierPath,
            'categorie_galerie_id' => $request->categorie_galerie_id,
            'actif' => 'OUI',
        ]);

        return redirect()->route('dashboard.admin.galeries.index')->with('success', 'L\'élément de la galerie a été créé avec succès !');
    }

    /**
     * Display the specified galerie.
     */
    public function show($id)
    {
        return redirect()->route('dashboard.admin.galeries.index');
    }

    /**
     * Show the form for editing the specified galerie.
     */
    public function edit($id)
    {
        $galerie = Galerie::with('categorie')->findOrFail($id);
        $categories = CategorieGalerie::all();
        return view('admin.galeries.edit', compact('galerie', 'categories'));
    }

    /**
     * Update the specified galerie in storage.
     */
    public function update(Request $request, $id)
    {
        $galerie = Galerie::findOrFail($id);

        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'fichier' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,mp4,webm,mp3,wav', 'max:10240'],
            'categorie_galerie_id' => ['required', 'exists:categorie_galeries,id'],
        ]);

        if ($request->hasFile('fichier')) {
            $galerie->fichier = $request->file('fichier')->store('galeries', 'public');
        }

        $galerie->update($request->only(['titre', 'description', 'categorie_galerie_id']));

        return redirect()->route('dashboard.admin.galeries.index')->with('success', 'L\'élément de la galerie a été mis à jour avec succès.');
    }

    /**
     * Remove the specified galerie from storage.
     */
    public function destroy($id)
    {
        $galerie = Galerie::findOrFail($id);
        $galerie->delete();

        return redirect()->route('dashboard.admin.galeries.index')->with('success', 'L\'élément de la galerie a été supprimé avec succès.');
    }
}
