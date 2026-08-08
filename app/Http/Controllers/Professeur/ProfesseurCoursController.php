<?php
namespace App\Http\Controllers\Professeur;

use App\Models\Mode;
use App\Models\Cours;
use App\Models\SupportCours;
use Illuminate\Http\Request;
use App\Models\CategorieCours;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfesseurCoursController extends Controller
{

    /** Display a listing of the professor's courses */
    public function index()
    {
        $prof = Auth::user();
        $cours = Cours::where('user_id', $prof->id)
            ->where('actif','OUI')
            ->with(['categorie', 'mode'])
            ->withCount('supports')
            ->latest()
            ->get();
        $categories = CategorieCours::all();
        $modes = Mode::all();
        return view('professeur.cours.index', compact('cours', 'categories', 'modes'));
    }

    /** Store a newly created course */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'categorie_cours_id' => 'required|exists:categorie_cours,id',
            'mode_id' => 'required|exists:modes,id',
            'tarif' => 'required|numeric',
            'support_fichier' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,avi,mov,jpg,jpeg,png,gif|max:102400',
            // add other validation rules as needed
        ]);
        $prof = Auth::user();
        $cours = new Cours($request->all());
        $cours->user_id = $prof->id;
        $cours->actif = 'OUI';
        $cours->save();

        // Handle support file upload
        if ($request->hasFile('support_fichier')) {
            $file = $request->file('support_fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supports/cours', $fileName, 'public');

            // Determine file type
            $extension = $file->getClientOriginalExtension();
            $type = match(strtolower($extension)) {
                'pdf' => 'PDF',
                'doc', 'docx' => 'Word',
                'ppt', 'pptx' => 'PowerPoint',
                'mp4', 'avi', 'mov' => 'Vidéo',
                'jpg', 'jpeg', 'png', 'gif' => 'Image',
                default => 'Autre'
            };

            SupportCours::create([
                'cours_id' => $cours->id,
                'fichier' => $filePath,
                'type' => $type,
                'actif' => 'OUI',
            ]);
        }

        return redirect()->route('dashboard.professeur.cours.index')
            ->with('success', 'Cours ajouté avec succès.');
    }

    /** Display the specified course */
    public function show(Cours $cours)
    {
        return view('professeur.cours.show', compact('cours'));
    }

    /** Update the specified course */
    public function update(Request $request, $id)
    {
        $cours = Cours::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'categorie_cours_id' => 'required|exists:categorie_cours,id',
            'mode_id' => 'required|exists:modes,id',
            'tarif' => 'required|numeric',
            'support_fichier' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,avi,mov,jpg,jpeg,png,gif|max:102400',
        ]);

        $cours->update($request->except(['id', '_token', '_method']));

        // Handle support file upload
        if ($request->hasFile('support_fichier')) {
            $file = $request->file('support_fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supports/cours', $fileName, 'public');

            // Determine file type
            $extension = $file->getClientOriginalExtension();
            $type = match(strtolower($extension)) {
                'pdf' => 'PDF',
                'doc', 'docx' => 'Word',
                'ppt', 'pptx' => 'PowerPoint',
                'mp4', 'avi', 'mov' => 'Vidéo',
                'jpg', 'jpeg', 'png', 'gif' => 'Image',
                default => 'Autre'
            };

            SupportCours::create([
                'cours_id' => $id,
                'fichier' => $filePath,
                'type' => $type,
                'actif' => 'OUI',
            ]);
        }

        return redirect()->route('dashboard.professeur.cours.index')
            ->with('success', 'Cours mis à jour avec succès.');
    }

    /** Remove the specified course */
    public function destroy(Cours $cours)
    {
        if($cours->actif=='OUI') {
            $cours->actif = 'NON';
        } else {
            $cours->actif = 'OUI';
        }
        $cours->save();
        return redirect()->route('dashboard.professeur.cours.index')
            ->with('success', 'Cours supprimé avec succès.');
    }

    /** Download the support file for a course */
    public function downloadSupport(Cours $cours)
    {
        $support = $cours->supports()->where('actif', 'OUI')->latest()->first();

        if (!$support) {
            return redirect()->route('professeur.cours.index')
                ->with('error', 'Aucun support disponible pour ce cours.');
        }

        $filePath = storage_path('app/public/' . $support->fichier);

        if (!file_exists($filePath)) {
            return redirect()->route('professeur.cours.index')
                ->with('error', 'Le fichier de support n\'existe pas.');
        }

        return response()->download($filePath, basename($support->fichier));
    }
}
?>
