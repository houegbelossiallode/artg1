<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Association;
use App\Models\Menu;
use App\Models\Profil;
use App\Models\Profilpermission;
use App\Models\Sousmenu;
use App\Observers\ProfilObserver;
use App\Observers\SousmenuObserver;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


       View::composer('*', function ($view) {
            $user = Auth::user();

            $menus = [];
            if ($user) {
                $profilId = $user->profil_id;
                $accessibleSousMenus = Profilpermission::where('profil_id', $profilId)
                                            ->where('is_granted', 1)
                                            ->where('actif', 'OUI')
                                            ->pluck('sousmenu_id')->toArray();

                $menus = Menu::with(['submenus' => function ($query) use ($accessibleSousMenus) {
                    $query->whereIn('id', $accessibleSousMenus)
                          ->orderBy('libelle', 'asc');
                }])->whereHas('submenus', function ($query) use ($accessibleSousMenus) {
                    $query->whereIn('id', $accessibleSousMenus);
                })->orderBy('libelle', 'asc')->get();
            }

            $view->with('mainmenus', $menus);
        });


        if (Schema::hasTable('associations')) {
            View::composer('*', function ($view) {
                $association = Association::where('actif', 'OUI')->latest()->first() ?? Association::first();
                $view->with('association', $association);
            });
        }



        Sousmenu::observe(SousmenuObserver::class);
        Profil::observe(ProfilObserver::class);


    }
}
