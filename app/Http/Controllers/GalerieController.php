<?php

namespace App\Http\Controllers;

use App\Models\Galerie;
use Illuminate\Http\Request;
use App\Models\CategorieGalerie;

class GalerieController extends Controller
{
    /**
     * Display the gallery page.
     */
    public function index()
    {
        $categories = CategorieGalerie::where('actif','OUI')->get();
        $galeries = Galerie::with('categorie')
            ->where('actif','OUI')
            ->latest()
            ->get();
        
        return view('pages.galerie', compact('categories', 'galeries'));
    }
}
