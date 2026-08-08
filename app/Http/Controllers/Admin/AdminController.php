<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Talent;
use App\Models\CategorieTalent;
use App\Models\CategorieCours;
use App\Models\CategorieEvenement;

class AdminController extends Controller
{
    /**
     * Display Admin Dashboard with dynamic metrics and resources.
     */
    public function index()
    {
        $categorieTalents = CategorieTalent::all();
        $categorieCours = CategorieCours::all();
        $categorieEvenements = CategorieEvenement::all();
        
        $professeurs = User::whereHas('profil', function ($query) {
            $query->where('nom', 'professeur');
        })->latest()->get();

        $recentUsers = User::with('profil')->latest()->take(10)->get();
        $talents = Talent::with('category')->latest()->get();

        $totalUsers = User::count();
        $totalProfesseurs = $professeurs->count();
        $totalTalents = $talents->count();

        return view('dashboards.admin', compact(
            'categorieTalents',
            'categorieCours',
            'categorieEvenements',
            'professeurs',
            'recentUsers',
            'talents',
            'totalUsers',
            'totalProfesseurs',
            'totalTalents'
        ));
    }
}
