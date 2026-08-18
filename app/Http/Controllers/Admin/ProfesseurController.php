<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProfesseurAccountCreated;

class ProfesseurController extends Controller
{
    /**
     * Display a listing of professors.
     */
    public function index()
    {
        $professeurs = User::whereHas('profil', function ($query) {
            $query->where('nom', 'professeur');
        })->latest()->get();

        return view('admin.professeurs.index', compact('professeurs'));
    }

    /**
     * Show the form for creating a new professor.
     */
    public function create()
    {
        return view('admin.professeurs.create');
    }

    /**
     * Store a newly created professor and redirect to index list.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'sexe' => ['required', 'string', 'in:M,F'],
            'date_naissance' => ['required', 'date'],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['required', 'string', 'max:255'],
            'biographie' => ['nullable', 'string'],
        ], [
            'email.unique' => 'Cet email est déjà attribué à un autre compte.',
        ]);

        $plainPassword = \Illuminate\Support\Str::random(10);
        $profil = \App\Models\Profil::where('nom', 'professeur')->first();
        
        if(!$profil) {
            return redirect()->route('dashboard.admin.professeurs.index')->with('error', 'Le profil professeur n\'existe pas.');
        }

        $professeur = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'sexe' => $request->sexe,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'biographie' => $request->biographie,
            'profil_id' => $profil->id,
        ]);

        // Send email with credentials
        try {
            Mail::to($professeur->email)->send(new \App\Mail\ProfesseurCreated($professeur, $plainPassword));
            $mailMsg = ' Un email contenant ses identifiants lui a été envoyé.';
        } catch (\Exception $e) {
            $mailMsg = ' (Note: L\'email n\'a pas pu être envoyé suite à un problème de serveur mail).';
        }

        // Return to professors index list
        return redirect()->route('dashboard.admin.professeurs.index')->with('success', 'Le professeur ' . $request->prenom . ' ' . $request->nom . ' a été enregistré avec succès !' . $mailMsg);
    }

    /**
     * Display the specified professor.
     */
    public function show($id)
    {
        return redirect()->route('dashboard.admin.professeurs.index');
    }

    /**
     * Show the form for editing the specified professor.
     */
    public function edit($id)
    {
        return view('admin.professeurs.edit', ['professeur' => User::findOrFail($id)]);
    }

    /**
     * Update the specified professor in storage and redirect to index list.
     */
    public function update(Request $request, $id)
    {
        $professeur = User::findOrFail($id);

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['required', 'string', 'max:255'],
            'biographie' => ['nullable', 'string'],
        ]);

        $professeur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'biographie' => $request->biographie,
        ]);

        return redirect()->route('dashboard.admin.professeurs.index')->with('success', 'Professeur mis à jour avec succès.');
    }

    /**
     * Remove the specified professor from storage and redirect to index list.
     */
    public function destroy($id)
    {
        $professeur = User::findOrFail($id);
        $professeur->delete();

        return redirect()->route('dashboard.admin.professeurs.index')->with('success', 'Professeur supprimé avec succès.');
    }
}
