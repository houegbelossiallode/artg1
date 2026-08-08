<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategorieEvenement;

class CategorieEvenementController extends Controller
{
    /**
     * Display a listing of event categories.
     */
    public function index()
    {
        $categories = CategorieEvenement::all();
        return view('admin.categories-evenements.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories-evenements.create');
    }

    /**
     * Store a newly created event category and redirect to index list.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        CategorieEvenement::create([
            'libelle' => $request->nom,
            'actif' => 'oui',
        ]);

        return redirect()->route('dashboard.admin.categories-evenements.index')->with('success', 'La catégorie d\'événements "' . $request->nom . '" a été créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return redirect()->route('dashboard.admin.categories-evenements.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = CategorieEvenement::findOrFail($id);
        return view('admin.categories-evenements.edit', compact('category'));
    }

    /**
     * Update the specified event category and redirect to index list.
     */
    public function update(Request $request, $id)
    {
        $category = CategorieEvenement::findOrFail($id);

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        $category->update([
            'libelle' => $request->nom,
        ]);

        return redirect()->route('dashboard.admin.categories-evenements.index')->with('success', 'Catégorie d\'événements mise à jour avec succès.');
    }

    /**
     * Remove the specified event category and redirect to index list.
     */
    public function destroy($id)
    {
        $category = CategorieEvenement::findOrFail($id);
        $category->delete();

        return redirect()->route('dashboard.admin.categories-evenements.index')->with('success', 'Catégorie d\'événements supprimée avec succès.');
    }
}
