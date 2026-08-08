<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mode;

class ModeController extends Controller
{
    public function index()
    {
        $modes = Mode::latest('id')->get();
        return view('admin.modes.index', compact('modes'));
    }

    public function create()
    {
        return redirect()->route('dashboard.admin.modes.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
        ]);

        $mode = Mode::create([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('dashboard.admin.modes.index')->with('success', 'Le mode d\'apprentissage "' . $mode->libelle . '" a été créé avec succès !');
    }

    public function show($id)
    {
        return redirect()->route('dashboard.admin.modes.index');
    }

    public function edit($id)
    {
        return redirect()->route('dashboard.admin.modes.index');
    }

    public function update(Request $request, $id)
    {
        $mode = Mode::findOrFail($id);

        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
        ]);

        $mode->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('dashboard.admin.modes.index')->with('success', 'Mode mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // $mode = Mode::findOrFail($id);
        // $mode->delete();

        return redirect()->route('dashboard.admin.modes.index')->with('success', 'Mode supprimé avec succès.');
    }
}
