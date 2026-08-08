<?php
namespace App\Http\Controllers\Professeur;

use App\Http\Controllers\Controller;
use App\Models\Disponibilite;
// use App\Models\Cours; // removed: availability not linked to a course
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisponibiliteController extends Controller
{
    /** List disponibilités */
    public function index()
    {
        $prof = Auth::user();
        $dispos = Disponibilite::where('professeur_id', $prof->id)

            ->get();
        return view('professeur.disponibilites.index', compact('dispos'));
    }

    /** Store new disponibilité */
    public function store(Request $request)
    {
        $data = $request->validate([
            'jour' => 'required|string',
            'debut' => 'required|date_format:H:i',
            'fin' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $debut = $request->input('debut');
                    if ($debut && $value !== '00:00' && $value <= $debut) {
                        $fail('L\'heure de fin doit être supérieure à l\'heure de début.');
                    }
                },
            ],
            'statut' => 'sometimes|string',
        ], [
            'fin.after' => 'L\'heure de fin doit être supérieure à l\'heure de début.',
            'debut.date_format' => 'Le format de l\'heure de début est invalide.',
            'fin.date_format' => 'Le format de l\'heure de fin est invalide.',
        ]);
        $data['professeur_id'] = Auth::id();
        Disponibilite::create($data);
        return back()->with('success', 'Disponibilité ajoutée avec succès.');
    }

    /** Update existing disponibilité */
    public function update(Request $request, $id)
    {
        $dispo = Disponibilite::findOrFail($id);
        $data = $request->validate([
            'jour' => 'required|string',
            'debut' => 'required|date_format:H:i',
            'fin' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $debut = $request->input('debut');
                    if ($debut && $value !== '00:00' && $value <= $debut) {
                        $fail('L\'heure de fin doit être supérieure à l\'heure de début.');
                    }
                },
            ],
            'statut' => 'sometimes|string',
        ], [
            'fin.after' => 'L\'heure de fin doit être supérieure à l\'heure de début.',
            'debut.date_format' => 'Le format de l\'heure de début est invalide.',
            'fin.date_format' => 'Le format de l\'heure de fin est invalide.',
        ]);
        $dispo->update($data);
        return back()->with('success', 'Disponibilité mise à jour avec succès.');
    }

    /** Delete disponibilité */
    public function destroy($id)
    {
        $dispo = Disponibilite::findOrFail($id);
        //$this->authorize('delete', $dispo);
        $dispo->delete();
        return back()->with('success', 'Disponibilité supprimée');
    }
}
?>