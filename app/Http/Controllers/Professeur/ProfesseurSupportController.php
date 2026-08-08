<?php

namespace App\Http\Controllers\Professeur;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\SupportCours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfesseurSupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prof = Auth::user();
        $coursList = Cours::where('user_id', $prof->id)->get();
        $supports = SupportCours::whereHas('cours', fn($q) => $q->where('user_id', $prof->id))
            ->with('cours')
            ->latest()
            ->get();
        return view('professeur.supports.index', compact('supports', 'coursList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prof = Auth::user();
        $coursList = Cours::where('user_id', $prof->id)->get();
        return view('professeur.supports.create', compact('coursList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cours_id'    => 'required|exists:cours,id',
            'fichier'     => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,mp4,mp3,png,jpg,jpeg|max:20480',
        ]);

        $path = $request->file('fichier')->store('supports', 'public');

        // Determine file type
        $extension = $request->file('fichier')->getClientOriginalExtension();
        $type = match(strtolower($extension)) {
            'pdf' => 'PDF',
            'doc', 'docx' => 'Word',
            'ppt', 'pptx' => 'PowerPoint',
            'mp4', 'avi', 'mov' => 'Vidéo',
            'jpg', 'jpeg', 'png', 'gif' => 'Image',
            default => 'Autre'
        };

        SupportCours::create([
            'cours_id'    => $request->cours_id,
            'fichier'     => $path,
            'type'        => $type,
            'actif'       => 'OUI',
        ]);

        return redirect()->route('professeur.supports.index')->with('success', 'Support ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $support = SupportCours::findOrFail($id);
        return view('professeur.supports.show', compact('support'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prof = Auth::user();
        $support = SupportCours::findOrFail($id);
        $coursList = Cours::where('user_id', $prof->id)->get();
        return view('professeur.supports.edit', compact('support', 'coursList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $support = SupportCours::findOrFail($id);

        $request->validate([
            'cours_id'    => 'required|exists:cours,id',
            'fichier'     => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,mp4,mp3,png,jpg,jpeg|max:20480',
        ]);

        $data = [
            'cours_id'    => $request->cours_id,
        ];

        if ($request->hasFile('fichier')) {
            // Delete old file
            if ($support->fichier && Storage::disk('public')->exists($support->fichier)) {
                Storage::disk('public')->delete($support->fichier);
            }

            $path = $request->file('fichier')->store('supports', 'public');
            $data['fichier'] = $path;

            // Determine file type
            $extension = $request->file('fichier')->getClientOriginalExtension();
            $data['type'] = match(strtolower($extension)) {
                'pdf' => 'PDF',
                'doc', 'docx' => 'Word',
                'ppt', 'pptx' => 'PowerPoint',
                'mp4', 'avi', 'mov' => 'Vidéo',
                'jpg', 'jpeg', 'png', 'gif' => 'Image',
                default => 'Autre'
            };
        }

        $support->update($data);

        return redirect()->route('professeur.supports.index')->with('success', 'Support mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $support = SupportCours::findOrFail($id);

        // Delete the physical file
        if ($support->fichier && Storage::disk('public')->exists($support->fichier)) {
            Storage::disk('public')->delete($support->fichier);
        }

        $support->delete();
        return redirect()->route('professeur.supports.index')->with('success', 'Support supprimé avec succès.');
    }
}
