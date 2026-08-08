<?php

namespace App\Http\Controllers\Admin;

use App\Models\Talent;
use Illuminate\Http\Request;
use App\Models\CategorieTalent;
use App\Http\Controllers\Controller;

class TalentController extends Controller
{
    /**
     * Display a listing of talents.
     */
    public function index()
    {
        $talents = Talent::with('category')->latest()->get();
        $categories = CategorieTalent::where('actif', 'oui')->orWhere('actif', 'OUI')->get();
        
        return view('admin.talents.index', compact('talents', 'categories'));
    }

    /**
     * Show the form for creating a new talent.
     */
    public function create()
    {
        $categories = CategorieTalent::all();
        return view('admin.talents.create', compact('categories'));
    }

    /**
     * Store a newly created talent and redirect to index list.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'categorie_talent_id' => ['required', 'exists:categorie_talents,id'],
            'biographie' => ['nullable', 'string'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('talents', 'public');
        }

        Talent::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'categorie_talent_id' => $request->categorie_talent_id,
            'biographie' => $request->biographie,
            'telephone' => $request->telephone,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'photo' => $photoPath,
        ]);

        // Return directly to the talents list page
        return redirect()->route('dashboard.admin.talents.index')->with('success', 'Le talent ' . $request->prenom . ' ' . $request->nom . ' a été créé avec succès !');
    }

    /**
     * Display the specified talent.
     */
    public function show($id)
    {
        return redirect()->route('dashboard.admin.talents.index');
    }

    /**
     * Show the form for editing the specified talent.
     */
    public function edit($id)
    {
        $talent = Talent::with('category')->findOrFail($id);
        $categories = CategorieTalent::all();
        return view('admin.talents.edit', compact('talent', 'categories'));
    }

    /**
     * Update the specified talent in storage and redirect to index list.
     */
    public function update(Request $request, $id)
    {
        $talent = Talent::findOrFail($id);

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'categorie_talent_id' => ['required', 'exists:categorie_talents,id'],
            'biographie' => ['nullable', 'string'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $talent->photo = $request->file('photo')->store('talents', 'public');
        }

        $talent->update($request->only([
            'nom', 'prenom', 'categorie_talent_id', 'biographie', 'telephone', 'whatsapp', 'email', 'facebook', 'instagram', 'youtube'
        ]));

        return redirect()->route('dashboard.admin.talents.index')->with('success', 'Talent mis à jour avec succès.');
    }

    /**
     * Remove the specified talent from storage and redirect to index list.
     */
    public function destroy($id)
    {
        $talent = Talent::findOrFail($id);
        $talent->delete();

        return redirect()->route('dashboard.admin.talents.index')->with('success', 'Talent supprimé avec succès.');
    }
}
