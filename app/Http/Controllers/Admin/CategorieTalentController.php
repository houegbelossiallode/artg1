<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategorieTalent;

class CategorieTalentController extends Controller
{
    /**
     * Display a listing of talent categories.
     */
    public function index()
    {
        $categories = CategorieTalent::all();
        return view('admin.categories-talents.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories-talents.create');
    }

    /**
     * Store a newly created talent category and redirect to index list.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        CategorieTalent::create([
            'libelle' => $request->nom,
            'actif' => 'oui',
        ]);

        return redirect()->route('dashboard.admin.categories-talents.index')->with('success', 'La catégorie de talents "' . $request->nom . '" a été créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return redirect()->route('dashboard.admin.categories-talents.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = CategorieTalent::findOrFail($id);
        return view('admin.categories-talents.edit', compact('category'));
    }

    /**
     * Update the specified talent category and redirect to index list.
     */
    public function update(Request $request, $id)
    {
        $category = CategorieTalent::findOrFail($id);

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        $category->update([
            'libelle' => $request->nom,
        ]);

        return redirect()->route('dashboard.admin.categories-talents.index')->with('success', 'Catégorie de talents mise à jour avec succès.');
    }

    /**
     * Remove the specified talent category and redirect to index list.
     */
    public function destroy($id)
    {
        $category = CategorieTalent::findOrFail($id);
        $category->delete();

        return redirect()->route('dashboard.admin.categories-talents.index')->with('success', 'Catégorie de talents supprimée avec succès.');
    }
}
