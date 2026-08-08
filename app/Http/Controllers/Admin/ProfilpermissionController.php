<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profilpermission;
use App\Models\Profil;
use App\Models\Sousmenu;
use Illuminate\Http\Request;

class ProfilpermissionController extends Controller
{
    public function index($profilId)
    {
        $profileid = $profilId;
        if(empty($profileid)){
            return redirect()->route('dashboard.admin.profils.index')->with('error', 'Veuillez selectionner un profil.');
        }
        $profile = Profil::where('actif','OUI')->where('id',$profileid)->firstOrFail();
        if(!$profile){
            return redirect()->route('dashboard.admin.profils.index')->with('error', "Ce profil n'existe pas");
        }
        $permissions = Profilpermission::where('actif','OUI')
            ->where('profil_id',$profileid)
            ->get();
        $modules = \App\Models\Module::with(['menus.submenus' => function($q) {
            $q->where('actif', 'OUI');
        }, 'menus' => function($q) {
            $q->where('actif', 'OUI');
        }])->where('actif', 'OUI')->get();
        return view('profiles.permissions.index', compact('permissions', 'profile', 'modules'));
    }

    public function create()
    {
        $profils = Profil::where('actif','OUI')->get();
        $sousmenus = Sousmenu::where('actif','OUI')->get();
        return view('profiles.permissions.create', compact('profils', 'sousmenus'));
    }

    public function store(Request $request)
    {
        try{
        $request->validate([
            'sousmenu' => 'required',
            'profil' => 'required',
        ], [
            'sousmenu.required' => "Le champs est requis",
            'profil.required' => "Le champs est requis",
        ]);

        Profilpermission::create([
            'sousmenu_id' => $request->sousmenu,
            'profil_id' => $request->profil,
        ]);

        return redirect()->route('dashboard.admin.profils.permissions', ['profil' => $request->profil])->with('success', 'Permission créée avec succès.');

    } catch (\Exception $e) {
        // Gestion des erreurs : redirection avec un message d'erreur
        return redirect()->route('dashboard.admin.profils.permissions', ['profil' => $request->profil ?? null])->with(['error' => "Une erreur inattendue s'est produite : " . $e->getMessage()]);
    }
    
    }


    public function edit(Profilpermission $permission)
    {
        $profils = Profil::where('actif','OUI')->get();
        $sousmenus = Sousmenu::where('actif','OUI')->get();
        return view('profiles.permissions.edit', compact('permission', 'profils', 'sousmenus'));
    }

    public function update(Request $request, $profilId)
    {
        $profil = Profil::findOrFail($profilId);
        $permissions = $request->input('permissions', []);

        // 1. Décocher toutes les permissions pour ce profil par défaut
        Profilpermission::where('profil_id', $profilId)
                      ->where('actif', 'OUI')
                      ->update(['is_granted' => 0]);

        // 2. Cocher uniquement les permissions soumises (cochées)
        if (!empty($permissions)) {
            Profilpermission::where('profil_id', $profilId)
                          ->whereIn('sousmenu_id', array_keys($permissions))
                          ->where('actif', 'OUI')
                          ->update(['is_granted' => 1]);
        }

        return redirect()->route('dashboard.admin.profils.index')->with('success', 'Droits accordés.');
    }
}
?>
