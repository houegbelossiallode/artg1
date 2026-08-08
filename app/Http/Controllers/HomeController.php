<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Cours;
use App\Models\Equipe;
use App\Models\Talent;
use App\Models\Galerie;
use App\Models\Actualite;
use App\Models\Evenement;
use App\Models\Association;
use App\Models\CategorieCours;
use App\Models\CategorieGalerie;
use App\Models\CategorieEvenement;

class HomeController extends Controller
{
    /**
     * Display the dynamic homepage with association, courses, events, and talents.
     */
    public function index()
    {
        $association = Association::where('actif', 'OUI')->latest()->first() ?? Association::first();
        $cours = Cours::with(['categorie', 'mode', 'professeur'])->latest()->get();
        $evenements = Evenement::with(['categorie', 'images'])->latest()->take(6)->get();
        $evenementPhare = Evenement::with(['categorie', 'images'])->latest()->first();
        $talents = Talent::with('categorie')->where('actif', 'OUI')->latest()->take(3)->get();
        $actualites = Actualite::with('images')->latest()->take(6)->get();
        $equipes = Equipe::where('actif', 'OUI')->latest()->take(4)->get();
        $categoriesCours = CategorieCours::all();
        $categoriesEvenements = CategorieEvenement::where('actif', 'OUI')->get();
        $modes = Mode::all();
        $categoriesGaleries = CategorieGalerie::where('actif', 'OUI')->get();
        $galeries = Galerie::with('categorie')->where('actif', 'OUI')->latest()->take(6)->get();

        return view('welcome', compact('association', 'cours', 'evenements', 'evenementPhare', 'talents', 'actualites', 'equipes', 'categoriesCours', 'categoriesEvenements', 'modes', 'categoriesGaleries', 'galeries'));
    }

    public function aPropos()
    {
        $association = Association::first();
        $equipes = Equipe::all();
        return view('pages.a-propos', compact('association', 'equipes'));
    }

    public function actions()
    {
        return view('pages.actions');
    }

    public function talents()
    {
        $talents = Talent::with('categorie')->latest()->get();
        return view('pages.talents', compact('talents'));
    }

    public function evenements()
    {
        $evenements = Evenement::with(['categorie', 'images'])->latest()->get();
        return view('pages.evenements', compact('evenements'));
    }

    public function showEvenement($id)
    {
        $item = Evenement::with(['categorie', 'images'])->findOrFail($id);
        $type = 'evenement';
        return view('pages.details', compact('item', 'type'));
    }

    public function cours()
    {
        $cours = Cours::with(['categorie', 'mode', 'professeur'])->latest()->get();
        $categoriesCours = CategorieCours::all();
        $modes = Mode::all();
        return view('pages.cours', compact('cours', 'categoriesCours', 'modes'));
    }

    public function galerie()
    {
        return view('pages.galerie');
    }

    public function actualites()
    {
        $actualites = Actualite::with('images')->latest()->get();
        return view('pages.actualites', compact('actualites'));
    }

    public function showActualite($id)
    {
        $item = Actualite::with('images')->findOrFail($id);
        $type = 'actualite';
        return view('pages.details', compact('item', 'type'));
    }

    public function don()
    {
        return view('pages.don');
    }

    public function contact()
    {
        $association = Association::first();
        return view('pages.contact', compact('association'));
    }
}
