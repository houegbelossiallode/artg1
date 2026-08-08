<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TalentCandidature;

class TalentCandidatureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'pseudo' => ['nullable', 'string', 'max:255'],
            'age' => ['required', 'integer'],
            'discipline_id' => ['required', 'exists:disciplines,id'],
            'demo_link' => ['required', 'url', 'max:255'],
            'presentation' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'telephone' => ['required', 'string', 'max:20'],
            'whatsapp' => ['required', 'string', 'max:20'],
        ]);

        TalentCandidature::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'pseudo' => $request->pseudo,
            'age' => $request->age,
            'discipline_id' => $request->discipline_id,
            'demo_link' => $request->demo_link,
            'presentation' => $request->presentation,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'whatsapp' => $request->whatsapp,
            'statut' => 'en_attente',
        ]);

        return response()->json(['success' => true, 'message' => 'Votre candidature a été enregistrée avec succès. Elle sera examinée par l\'administration.']);
    }
}
