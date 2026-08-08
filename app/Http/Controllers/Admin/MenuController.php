<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Module;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('module')->latest('id')->get();
        $modules = Module::where('actif', 'OUI')->orWhere('actif', 'oui')->get();
        return view('admin.menus.index', compact('menus', 'modules'));
    }

    public function create()
    {
        return redirect()->route('dashboard.admin.menus.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'module_id' => ['required', 'exists:modules,id'],
            'icon' => ['nullable', 'string', 'max:255'],
        ]);

        $menu = Menu::create([
            'libelle' => $request->libelle,
            'module_id' => $request->module_id,
            'icon' => $request->icon,
            
        ]);

        return redirect()->route('dashboard.admin.menus.index')->with('success', 'Le menu "' . $menu->libelle . '" a été créé avec succès !');
    }

    public function show($id)
    {
        return redirect()->route('dashboard.admin.menus.index');
    }

    public function edit($id)
    {
        return redirect()->route('dashboard.admin.menus.index');
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'module_id' => ['required', 'exists:modules,id'],
            'icon' => ['nullable', 'string', 'max:255'],
        ]);

        $menu->update([
            'libelle' => $request->libelle,
            'nom' => $request->libelle,
            'module_id' => $request->module_id,
            'icon' => $request->icon,
        ]);

        return redirect()->route('dashboard.admin.menus.index')->with('success', 'Menu mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // $menu = Menu::findOrFail($id);
        // $menu->delete();

        return redirect()->route('dashboard.admin.menus.index')->with('success', 'Menu supprimé avec succès.');
    }
}
