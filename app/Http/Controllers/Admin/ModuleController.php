<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::latest()->get();
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        return redirect()->route('dashboard.admin.modules.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'actif' => ['nullable', 'string'],
        ]);

        $module = Module::create([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('dashboard.admin.modules.index')->with('success', 'Le module "' . $module->libelle . '" a été créé avec succès !');
    }

    public function show($id)
    {
        return redirect()->route('dashboard.admin.modules.index');
    }

    public function edit($id)
    {
        return redirect()->route('dashboard.admin.modules.index');
    }

    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
        ]);

        $module->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('dashboard.admin.modules.index')->with('success', 'Module mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // $module = Module::findOrFail($id);
        // $module->delete();

        return redirect()->route('dashboard.admin.modules.index')->with('success', 'Module supprimé avec succès.');
    }
}
