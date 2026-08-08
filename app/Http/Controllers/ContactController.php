<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'objet' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        Contact::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'objet' => $request->objet,
            'message' => $request->message,
            'lu' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.']);
    }
}
