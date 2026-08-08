<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actualite;

class ActualiteController extends Controller
{
    /**
     * Display a listing of actualités.
     */
    public function index()
    {
        $actualites = Actualite::latest()->get();
        return view('admin.actualites.index', compact('actualites'));
    }

    /**
     * Show the form for creating a new actualite.
     */
    public function create()
    {
        return view('admin.actualites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'date_publication' => ['required', 'date'],
            'photo_principale' => ['nullable', 'image', 'max:4096'],
            'images_secondaires.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $actualite = Actualite::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'date_publication' => $request->date_publication,
            'actif' => 'OUI',
        ]);

        // Image principale
        if ($request->hasFile('photo_principale')) {
            $path = $request->file('photo_principale')->store('actualites', 'public');
            $actualite->images()->create([
                'image_path' => $path,
                'is_principal' => true,
            ]);
            
        }

        // Images secondaires
        if ($request->hasFile('images_secondaires')) {
            foreach ($request->file('images_secondaires') as $file) {
                $path = $file->store('actualites', 'public');
                $actualite->images()->create([
                    'image_path' => $path,
                    'is_principal' => false,
                ]);
            }
        }

        return redirect()->route('dashboard.admin.actualites.index')->with('success', 'L\'actualité a été publiée avec succès !');
    }

    public function show($id)
    {
        return redirect()->route('dashboard.admin.actualites.index');
    }

    public function edit($id)
    {
        $actualite = Actualite::with('images')->findOrFail($id);
        return view('admin.actualites.edit', compact('actualite'));
    }

    public function update(Request $request, $id)
    {
        $actualite = Actualite::findOrFail($id);

        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'date_publication' => ['required', 'date'],
            'photo_principale' => ['nullable', 'image', 'max:4096'],
            'images_secondaires.*' => ['nullable', 'image', 'max:4096'],
            'deleted_images' => ['nullable', 'string'], // IDs des images supprimées séparés par des virgules
        ]);

        $actualite->update([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'date_publication' => $request->date_publication,
        ]);

        // Suppression des images retirées
        if ($request->filled('deleted_images')) {
            $deletedIds = explode(',', $request->deleted_images);
            $imagesToDelete = $actualite->images()->whereIn('id', $deletedIds)->get();
            foreach ($imagesToDelete as $img) {
                if (\Storage::disk('public')->exists($img->image_path)) {
                    \Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }
        }

        // Nouvelle image principale (remplace l'ancienne)
        if ($request->hasFile('photo_principale')) {
            // Supprimer l'ancienne image principale
            $oldPrincipal = $actualite->images()->where('is_principal', true)->first();
            if ($oldPrincipal) {
                if (\Storage::disk('public')->exists($oldPrincipal->image_path)) {
                    \Storage::disk('public')->delete($oldPrincipal->image_path);
                }
                $oldPrincipal->delete();
            }

            $path = $request->file('photo_principale')->store('actualites', 'public');
            $actualite->images()->create([
                'image_path' => $path,
                'is_principal' => true,
            ]);
            
        }

        // Nouvelles images secondaires
        if ($request->hasFile('images_secondaires')) {
            foreach ($request->file('images_secondaires') as $file) {
                $path = $file->store('actualites', 'public');
                $actualite->images()->create([
                    'image_path' => $path,
                    'is_principal' => false,
                ]);
            }
        }

        return redirect()->route('dashboard.admin.actualites.index')->with('success', 'Actualité mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $actualite = Actualite::findOrFail($id);
        
        // Supprimer toutes les images
        foreach ($actualite->images as $img) {
            if (\Storage::disk('public')->exists($img->image_path)) {
                \Storage::disk('public')->delete($img->image_path);
            }
        }
        
        $actualite->delete();

        return redirect()->route('dashboard.admin.actualites.index')->with('success', 'Actualité supprimée avec succès.');
    }
}
