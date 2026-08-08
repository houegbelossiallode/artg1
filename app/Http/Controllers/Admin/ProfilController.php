<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;

class ProfilController extends Controller
{
    public function index()
    {
        $profils = Profil::latest('id')->get();
        return view('admin.profils.index', compact('profils'));
    }

    public function create()
    {
        return redirect()->route('dashboard.admin.profils.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'actif' => ['nullable', 'string'],
        ]);

        $profil = Profil::create([
            'nom' => strtolower($request->nom),
            'actif' => $request->actif ?? 'OUI',
        ]);

        return redirect()->route('dashboard.admin.profils.index')->with('success', 'Le profil "' . $profil->nom . '" a été créé avec succès !');
    }

    public function show($id)
    {
        return redirect()->route('dashboard.admin.profils.index');
    }

    public function edit($id)
    {
        return redirect()->route('dashboard.admin.profils.index');
    }

    public function update(Request $request, $id)
    {
        $profil = Profil::findOrFail($id);

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'actif' => ['nullable', 'string'],
        ]);

        $profil->update([
            'nom' => strtolower($request->nom),
            'actif' => $request->actif ?? 'OUI',
        ]);

        return redirect()->route('dashboard.admin.profils.index')->with('success', 'Profil mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $profil = Profil::findOrFail($id);
        $profil->delete();

        return redirect()->route('dashboard.admin.profils.index')->with('success', 'Profil supprimé avec succès.');
    }
}
