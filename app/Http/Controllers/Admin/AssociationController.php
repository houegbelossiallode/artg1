<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Association;

class AssociationController extends Controller
{
    /**
     * Display a listing of association details.
     */
    public function index()
    {
        $associations = Association::all();
        return view('admin.associations.index', compact('associations'));
    }

    /**
     * Show the form for creating a new association profile.
     */
    public function create()
    {
        return view('admin.associations.create');
    }

    /**
     * Store a newly created association and redirect to index list.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'historique' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'adresse' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'site_web' => ['nullable', 'string', 'max:255'],
        ]);

        $logoPath = '';
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('associations', 'public');
        }

        Association::create([
            'nom' => $request->nom,
            'logo' => $logoPath,
            'historique' => $request->historique ?? '',
            'mission' => $request->mission ?? '',
            'vision' => $request->vision ?? '',
            'description' => $request->description ?? '',
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'youtube' => $request->youtube,
            'instagram' => $request->instagram,
            'site_web' => $request->site_web,
            'actif' => 'OUI',
        ]);

        return redirect()->route('dashboard.admin.associations.index')->with('success', 'Les informations de l\'association ont été enregistrées avec succès !');
    }

    /**
     * Display the specified association.
     */
    public function show($id)
    {
        return redirect()->route('dashboard.admin.associations.index');
    }

    /**
     * Show the form for editing the specified association.
     */
    public function edit($id)
    {
        $association = Association::findOrFail($id);
        return view('admin.associations.edit', compact('association'));
    }

    /**
     * Update the specified association and redirect to index list.
     */
    public function update(Request $request, $id)
    {
        $association = Association::findOrFail($id);

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'historique' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'adresse' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only([
            'nom', 'historique', 'mission', 'vision', 'description', 'adresse', 'telephone', 'email', 'facebook', 'youtube', 'instagram', 'site_web'
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('associations', 'public');
        }

        $association->update($data);

        return redirect()->route('dashboard.admin.associations.index')->with('success', 'Informations de l\'association mises à jour avec succès.');
    }

    /**
     * Remove the specified association and redirect to index list.
     */
    public function destroy($id)
    {
        $association = Association::findOrFail($id);
        $association->delete();

        return redirect()->route('dashboard.admin.associations.index')->with('success', 'Association supprimée avec succès.');
    }
}
