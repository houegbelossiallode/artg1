<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CategorieGalerie;
use App\Http\Controllers\Controller;

class CategorieGalerieController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = CategorieGalerie::latest()->get();
        return view('admin.categories-galeries.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories-galeries.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        CategorieGalerie::create([
            'libelle' => $request->libelle,
            'slug' => \Illuminate\Support\Str::slug($request->libelle),
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.admin.categories-galeries.index')->with('success', 'La catégorie a été créée avec succès !');
    }

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        return redirect()->route('dashboard.admin.categories-galeries.index');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        $category = CategorieGalerie::findOrFail($id);
        return view('admin.categories-galeries.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
    {
        $category = CategorieGalerie::findOrFail($id);

        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category->update([
            'libelle' => $request->libelle,
            'slug' => \Illuminate\Support\Str::slug($request->libelle),
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.admin.categories-galeries.index')->with('success', 'La catégorie a été mise à jour avec succès.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy($id)
    {
        $category = CategorieGalerie::findOrFail($id);
        $category->delete();

        return redirect()->route('dashboard.admin.categories-galeries.index')->with('success', 'La catégorie a été supprimée avec succès.');
    }
}
