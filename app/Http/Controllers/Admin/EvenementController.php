<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evenement;
use App\Models\CategorieEvenement;
use Illuminate\Support\Facades\Storage;

class EvenementController extends Controller
{
    /**
     * Display a listing of evenements.
     */
    public function index()
    {
        $evenements = Evenement::with('categorie')->latest()->get();
        return view('admin.evenements.index', compact('evenements'));
    }

    /**
     * Show the form for creating a new evenement.
     */
    public function create()
    {
        $categories = CategorieEvenement::all();
        return view('admin.evenements.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'categorie_evenement_id' => ['required', 'exists:categorie_evenements,id'],
            'description' => ['nullable', 'string'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
            'heure' => ['required'],
            'lieu' => ['required', 'string', 'max:255'],
            'photo_principale' => ['nullable', 'image', 'max:4096'],
            'images_secondaires.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $evenement = Evenement::create([
            'titre' => $request->titre,
            'categorie_evenement_id' => $request->categorie_evenement_id,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'heure' => $request->heure,
            'lieu' => $request->lieu,
            'actif' => 'OUI',
        ]);

        // Image principale
        if ($request->hasFile('photo_principale')) {
            $path = $request->file('photo_principale')->store('evenements', 'public');
            $evenement->images()->create([
                'image_path' => $path,
                'is_principal' => true,
            ]);
        }

        // Images secondaires
        if ($request->hasFile('images_secondaires')) {
            foreach ($request->file('images_secondaires') as $file) {
                $path = $file->store('evenements', 'public');
                $evenement->images()->create([
                    'image_path' => $path,
                    'is_principal' => false,
                ]);
            }
        }

        return redirect()->route('dashboard.admin.evenements.index')->with('success', 'L\'événement a été créé avec succès !');
    }

    public function show($id)
    {
        return redirect()->route('dashboard.admin.evenements.index');
    }

    public function edit($id)
    {
        $evenement = Evenement::with('images')->findOrFail($id);
        $categories = CategorieEvenement::all();
        return view('admin.evenements.edit', compact('evenement', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $evenement = Evenement::findOrFail($id);

        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'categorie_evenement_id' => ['required', 'exists:categorie_evenements,id'],
            'description' => ['nullable', 'string'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
            'heure' => ['required'],
            'lieu' => ['required', 'string', 'max:255'],
            'photo_principale' => ['nullable', 'image', 'max:4096'],
            'images_secondaires.*' => ['nullable', 'image', 'max:4096'],
            'deleted_images' => ['nullable', 'string'], // IDs des images supprimées séparés par des virgules
        ]);

        $evenement->update([
            'titre' => $request->titre,
            'categorie_evenement_id' => $request->categorie_evenement_id,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'heure' => $request->heure,
            'lieu' => $request->lieu,
        ]);

        // Suppression des images retirées
        if ($request->filled('deleted_images')) {
            $deletedIds = explode(',', $request->deleted_images);
            $imagesToDelete = $evenement->images()->whereIn('id', $deletedIds)->get();
            foreach ($imagesToDelete as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }
        }

        // Nouvelle image principale (remplace l'ancienne)
        if ($request->hasFile('photo_principale')) {
            // Supprimer l'ancienne image principale
            $oldPrincipal = $evenement->images()->where('is_principal', true)->first();
            if ($oldPrincipal) {
                if (Storage::disk('public')->exists($oldPrincipal->image_path)) {
                    Storage::disk('public')->delete($oldPrincipal->image_path);
                }
                $oldPrincipal->delete();
            }

            $path = $request->file('photo_principale')->store('evenements', 'public');
            $evenement->images()->create([
                'image_path' => $path,
                'is_principal' => true,
            ]);
        }

        // Nouvelles images secondaires
        if ($request->hasFile('images_secondaires')) {
            foreach ($request->file('images_secondaires') as $file) {
                $path = $file->store('evenements', 'public');
                $evenement->images()->create([
                    'image_path' => $path,
                    'is_principal' => false,
                ]);
            }
        }

        return redirect()->route('dashboard.admin.evenements.index')->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $evenement = Evenement::findOrFail($id);
        
        // Supprimer toutes les images
        foreach ($evenement->images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }
        
        $evenement->delete();

        return redirect()->route('dashboard.admin.evenements.index')->with('success', 'Événement supprimé avec succès.');
    }
}
