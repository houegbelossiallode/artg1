<?php

namespace App\Http\Controllers\Admin;

use App\Models\Talent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategorieTalent;
use App\Models\TalentCandidature;
use App\Http\Controllers\Controller;

class TalentCandidatureController extends Controller
{
    public function index()
    {
        $candidatures = TalentCandidature::with('discipline')->latest()->get();

        return view('admin.talent-candidatures.index', compact('candidatures'));
    }

    public function approve(Request $request, TalentCandidature $talentCandidature)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        $category = CategorieTalent::where('actif', 'OUI')->first() ?? CategorieTalent::first();

        if (! $category) {
            $category = CategorieTalent::create(['libelle' => 'Autres', 'actif' => 'OUI']);
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('talents', 'public');
        }

        Talent::create([
            'nom' => $talentCandidature->nom,
            'prenom' => $talentCandidature->prenom,
            'categorie_talent_id' => $category->id,
            'biographie' => Str::limit($talentCandidature->presentation ?? '', 255),
            'telephone' => $talentCandidature->telephone,
            'email' => $talentCandidature->email,
            'whatsapp' => $talentCandidature->whatsapp,
            'facebook' => null,
            'instagram' => null,
            'youtube' => $talentCandidature->demo_link,
            'photo' => $photoPath,
        ]);

        $talentCandidature->update(['statut' => 'acceptee']);

        return redirect()->back()->with('success', 'La candidature a été acceptée et le talent a été créé.');
    }

    public function reject(TalentCandidature $talentCandidature)
    {
        $talentCandidature->update(['statut' => 'rejetee']);

        return redirect()->back()->with('success', 'La candidature a été rejetée.');
    }
}
