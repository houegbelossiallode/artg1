<?php

namespace App\Http\Controllers;

use App\Models\CategorieGalerie;
use App\Models\Galerie;
use Illuminate\Http\Request;

class GalerieController extends Controller
{
    /**
     * Display the gallery page.
     */
    public function index()
    {
        $categories = CategorieGalerie::where('actif', 'OUI')->orWhere('actif', 'oui')->get();
        $galeries = Galerie::with('categorie')
            ->where('actif', 'OUI')
            ->orWhere('actif', 'oui')
            ->orderBy('ordre')
            ->latest()
            ->get();
        
        return view('pages.galerie', compact('categories', 'galeries'));
    }
}
