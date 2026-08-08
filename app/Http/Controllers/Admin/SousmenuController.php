<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sousmenu;
use App\Models\Menu;

class SousmenuController extends Controller
{
    public function index()
    {
        $sousmenus = Sousmenu::with('menu')->latest('id')->get();
        $menus = Menu::where('actif', 'OUI')->orWhere('actif', 'oui')->get();
        return view('admin.sousmenus.index', compact('sousmenus', 'menus'));
    }

    public function create()
    {
        return redirect()->route('dashboard.admin.sousmenus.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'menu_id' => ['required', 'exists:menus,id'],
            'url' => ['required', 'string', 'max:255'],
           
        ]);

        $sousmenu = Sousmenu::create([
            'libelle' => $request->libelle,
            'menu_id' => $request->menu_id,
            'url' => $request->url,
        ]);

        return redirect()->route('dashboard.admin.sousmenus.index')->with('success', 'Le sous-menu "' . $sousmenu->libelle . '" a été créé avec succès !');
    }

    public function show($id)
    {
        return redirect()->route('dashboard.admin.sousmenus.index');
    }

    public function edit($id)
    {
        return redirect()->route('dashboard.admin.sousmenus.index');
    }

    public function update(Request $request, $id)
    {
        $sousmenu = Sousmenu::findOrFail($id);

        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'menu_id' => ['required', 'exists:menus,id'],
            'url' => ['required', 'string', 'max:255'],
            
        ]);

        $sousmenu->update([
            'libelle' => $request->libelle,
            'menu_id' => $request->menu_id,
            'url' => $request->url,
        ]);

        return redirect()->route('dashboard.admin.sousmenus.index')->with('success', 'Sous-menu mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // $sousmenu = Sousmenu::findOrFail($id);
        // $sousmenu->delete();

        return redirect()->route('dashboard.admin.sousmenus.index')->with('success', 'Sous-menu supprimé avec succès.');
    }
}
