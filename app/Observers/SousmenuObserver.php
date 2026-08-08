<?php

namespace App\Observers;

use App\Models\Profil;
use App\Models\Profilpermission;
use App\Models\Sousmenu;

class SousmenuObserver
{
     public function created(Sousmenu $sousmenu): void
    {
            // Récupérer tous les profils existants
            $profils = Profil::all();

            // Parcourir chaque profil pour créer une permission par défaut
            foreach ($profils as $profil) { 
                Profilpermission::create([
                    'sousmenu_id' => $sousmenu->id,
                    'profil_id' => $profil->id,
                    'is_granted' => false 
                ]);
            }
    }

    /**
     * Handle the Sousmenu "updated" event.
     */
    public function updated(Sousmenu $sousmenu): void
    {
        //
    }

    /**
     * Handle the Sousmenu "deleted" event.
     */
    public function deleted(Sousmenu $sousmenu): void
    {
        //
    }

    /**
     * Handle the Sousmenu "restored" event.
     */
    public function restored(Sousmenu $sousmenu): void
    {
        //
    }

    /**
     * Handle the Sousmenu "force deleted" event.
     */
    public function forceDeleted(Sousmenu $sousmenu): void
    {
        //
    }
}
