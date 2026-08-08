<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategorieCours;

class CategorieCoursController extends Controller
{
    /**
     * Display a listing of course categories.
     */
    public function index()
    {
        $categories = CategorieCours::all();
        return view('admin.categories-cours.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories-cours.create');
    }

    /**
     * Store a newly created course category and redirect to index list.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        CategorieCours::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'actif' => 'oui',
        ]);

        return redirect()->route('dashboard.admin.categories-cours.index')->with('success', 'La catégorie de cours "' . $request->nom . '" a été créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return redirect()->route('dashboard.admin.categories-cours.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = CategorieCours::findOrFail($id);
        return view('admin.categories-cours.edit', compact('category'));
    }

    /**
     * Update the specified course category and redirect to index list.
     */
    public function update(Request $request, $id)
    {
        $category = CategorieCours::findOrFail($id);

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.admin.categories-cours.index')->with('success', 'Catégorie de cours mise à jour avec succès.');
    }

    /**
     * Remove the specified course category and redirect to index list.
     */
    public function destroy($id)
    {
        $category = CategorieCours::findOrFail($id);
        $category->delete();

        return redirect()->route('dashboard.admin.categories-cours.index')->with('success', 'Catégorie de cours supprimée avec succès.');
    }
}
