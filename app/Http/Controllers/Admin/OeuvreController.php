<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Oeuvre;
use App\Models\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OeuvreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $talent = Talent::findOrFail($request->talent_id);
        $oeuvres = $talent->oeuvres()->orderBy('created_at', 'desc')->get();
        return view('admin.oeuvres.index', compact('talent', 'oeuvres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $talent = Talent::findOrFail($request->talent_id);
        return view('admin.oeuvres.create', compact('talent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $talent = Talent::findOrFail($request->talent_id);
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:video,audio,image,lien',
            'fichier_text' => 'nullable|string',
            'fichier_file' => 'nullable|file',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'date_publication' => 'required|date',
        ]);

        if (in_array($validated['type'], ['video', 'lien'])) {
            if (empty($validated['fichier_text'])) {
                return back()->withErrors(['fichier_text' => 'Le lien est obligatoire.'])->withInput();
            }
            $validated['fichier'] = $validated['fichier_text'];
        } else {
            if (!$request->hasFile('fichier_file')) {
                return back()->withErrors(['fichier_file' => 'Le fichier est obligatoire.'])->withInput();
            }
            $validated['fichier'] = $request->file('fichier_file')->store('oeuvres_fichiers', 'public');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('oeuvres_images', 'public');
        }

       
        
        $talent->oeuvres()->create([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'fichier' => $validated['fichier'],
            'image' => $validated['image'] ?? null,
            'date_publication' => $validated['date_publication'],
        ]);

        return redirect()->route('dashboard.admin.talents.oeuvres.index', ['talent_id' => $talent->id])
            ->with('success', 'L\'œuvre a été ajoutée avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $oeuvre = Oeuvre::findOrFail($id);
        $talent = $oeuvre->talent;
        return view('admin.oeuvres.edit', compact('talent', 'oeuvre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $oeuvre = Oeuvre::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:video,audio,image,lien',
            'fichier_text' => 'nullable|string',
            'fichier_file' => 'nullable|file',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'date_publication' => 'required|date',
        ]);

        // Fichier
        if (in_array($validated['type'], ['video', 'lien'])) {
            if (empty($validated['fichier_text'])) {
                return back()->withErrors(['fichier_text' => 'Le lien est obligatoire.'])->withInput();
            }
            // Si c'était un fichier avant, on le supprime
            if (in_array($oeuvre->type, ['audio', 'image']) && $oeuvre->fichier && Storage::disk('public')->exists($oeuvre->fichier)) {
                Storage::disk('public')->delete($oeuvre->fichier);
            }
            $validated['fichier'] = $validated['fichier_text'];
        } else {
            if ($request->hasFile('fichier_file')) {
                if ($oeuvre->fichier && Storage::disk('public')->exists($oeuvre->fichier)) {
                    Storage::disk('public')->delete($oeuvre->fichier);
                }
                $validated['fichier'] = $request->file('fichier_file')->store('oeuvres_fichiers', 'public');
            } else {
                // S'il n'y a pas de nouveau fichier, on vérifie si on est resté sur un type de fichier
                if (!in_array($oeuvre->type, ['audio', 'image'])) {
                    return back()->withErrors(['fichier_file' => 'Le fichier est obligatoire.'])->withInput();
                }
                $validated['fichier'] = $oeuvre->fichier; // on garde l'ancien
            }
        }

        // Image
        if ($request->hasFile('image')) {
            if ($oeuvre->image) {
                Storage::disk('public')->delete($oeuvre->image);
            }
            $validated['image'] = $request->file('image')->store('oeuvres_images', 'public');
        } else {
            $validated['image'] = $oeuvre->image;
        }

       

        $oeuvre->update([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'fichier' => $validated['fichier'],
            'image' => $validated['image'],
            'date_publication' => $validated['date_publication']
        ]);

        return redirect()->route('dashboard.admin.talents.oeuvres.index', ['talent_id' => $oeuvre->talent_id])
            ->with('success', 'L\'œuvre a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $oeuvre = Oeuvre::findOrFail($id);
        $talent_id = $oeuvre->talent_id;
        
        if ($oeuvre->image) {
            Storage::disk('public')->delete($oeuvre->image);
        }
        
        if ($oeuvre->fichier && Storage::disk('public')->exists($oeuvre->fichier)) {
            Storage::disk('public')->delete($oeuvre->fichier);
        }

        $oeuvre->delete();

        return redirect()->route('dashboard.admin.talents.oeuvres.index', ['talent_id' => $talent_id])
            ->with('success', 'L\'œuvre a été supprimée avec succès.');
    }
}
