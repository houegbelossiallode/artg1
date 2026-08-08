<?php

namespace App\Observers;

use App\Models\Profil;
use App\Models\Profilpermission;
use App\Models\Sousmenu;

class ProfilObserver
{
     public function created(Profil $profil): void
    {
         // Récupérer tous les profils existants
         $sousmenus = Sousmenu::all();
         foreach ($sousmenus as $sousmenu) { 
             Profilpermission::create([
                 'sousmenu_id' => $sousmenu->id,
                 'profil_id' => $profil->id,
                 'is_granted' => false 
             ]);
         }
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Profil $profil): void
    {
        //
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Profil $profil): void
    {
        //
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Profil $profil): void
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Profil $profil): void
    {
        //
    }
}
