<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:newsletters,email'],
        ], [
            'email.unique' => 'Cette adresse email est déjà inscrite à notre newsletter.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'Veuillez fournir une adresse email valide.'
        ]);

        Newsletter::create([
            'email' => $request->email,
            'statut'=> 'ok',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vous êtes maintenant inscrit à notre newsletter !',
        ]);
    }
}
