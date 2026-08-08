<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Don;
use Illuminate\Http\Request;

class DonController extends Controller
{
    /**
     * Store a newly created donation in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'montant' => 'required|numeric|min:1',
            'mode_paiement' => 'required|in:especes,cheque,virement,mobile_money',
            'message' => 'nullable|string|max:1000',
            'anonyme' => 'nullable|boolean',
        ]);

        // Si anonyme est coché, on ne stocke pas les infos personnelles
        if ($request->has('anonyme') && $request->anonyme) {
            $validated['nom'] = 'Donateur anonyme';
            $validated['email'] = null;
            $validated['telephone'] = null;
            $validated['anonyme'] = true;
        } else {
            $validated['anonyme'] = false;
        }

        $validated['statut'] = 'en_attente';

        $don = Don::create($validated);

        return back()->with('success', 'Merci pour votre don ! Votre contribution a été enregistrée avec succès. Nous vous contacterons bientôt pour finaliser le paiement.');
    }
}
