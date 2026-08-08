<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipeController extends Controller
{
    /**
     * Display a listing of team members.
     */
    public function index()
    {
        $equipes = Equipe::latest()->get();
        return view('admin.equipes.index', compact('equipes'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create()
    {
        $equipes = Equipe::latest()->get();
        return view('admin.equipes.index', compact('equipes'));
    }

    /**
     * Store a newly created team member and redirect to index list.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'fonction' => ['nullable', 'string', 'max:255'],
            'biographie' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('equipe', 'public');
        }

        Equipe::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'fonction' => $request->fonction,
            'biographie' => $request->biographie,
            'photo' => $photoPath ?? ''
        ]);

        return redirect()->route('dashboard.admin.equipes.index')->with('success', 'Le membre de l\'équipe ' . $request->prenom . ' ' . $request->nom . ' a été ajouté avec succès !');
    }

    /**
     * Display the specified team member.
     */
    public function show($id)
    {
        return redirect()->route('dashboard.admin.equipes.index');
    }

    /**
     * Show the form for editing the specified team member.
     */
    public function edit($id)
    {
        return redirect()->route('dashboard.admin.equipes.index');
    }

    /**
     * Update the specified team member and redirect to index list.
     */
    public function update(Request $request, $id)
    {
        $membre = Equipe::findOrFail($id);

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'fonction' => ['nullable', 'string', 'max:255'],
            'biographie' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $membre->photo = $request->file('photo')->store('equipe', 'public');
        }

        $membre->update($request->only([
            'nom', 'prenom', 'fonction', 'biographie'
        ]));

        return redirect()->route('dashboard.admin.equipes.index')->with('success', 'Membre de l\'équipe mis à jour avec succès.');
    }

    /**
     * Remove the specified team member and redirect to index list.
     */
    public function destroy($id)
    {
        $membre = Equipe::findOrFail($id);
        $membre->delete();

        return redirect()->route('dashboard.admin.equipes.index')->with('success', 'Membre de l\'équipe supprimé avec succès.');
    }
}
