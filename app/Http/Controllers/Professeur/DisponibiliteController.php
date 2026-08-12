<?php
namespace App\Http\Controllers\Professeur;

use App\Http\Controllers\Controller;
use App\Models\Disponibilite;
// use App\Models\Cours; // removed: availability not linked to a course
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DisponibiliteController extends Controller
{
    /** List disponibilités */
    public function index()
    {
        $prof = Auth::user();
        $dispos = Disponibilite::where('professeur_id', $prof->id)
            ->whereDate('date_dispo', '>=', Carbon::today())
            ->orderBy('date_dispo')
            ->orderBy('debut')
            ->get();
        return view('professeur.disponibilites.index', compact('dispos'));
    }

    /** Store new disponibilité */
    public function store(Request $request)
    {
        $type = $request->input('type_dispo', 'ponctuel');
        
        $request->validate([
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

        $profId = Auth::id();
        $now = now();
        $jourMap = [0 => 'Dimanche', 1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi'];
        
        if ($type === 'ponctuel') {
            $request->validate([
                'date_dispo' => 'required|date|after_or_equal:today',
            ]);
            
            if (Carbon::parse($request->date_dispo)->isToday() && $request->debut <= $now->format('H:i')) {
                return back()->withErrors(['debut' => 'L\'heure de début ne peut pas être dans le passé.'])->withInput();
            }

            $jourName = $jourMap[Carbon::parse($request->date_dispo)->dayOfWeek];

            Disponibilite::create([
                'professeur_id' => $profId,
                'date_dispo' => $request->date_dispo,
                'jour' => $jourName,
                'debut' => $request->debut,
                'fin' => $request->fin,
                'statut' => $request->statut ?? 'actif',
                'actif' => 'OUI'
            ]);
        } else {
            $request->validate([
                'jour' => 'required|string',
                'date_debut_recurrence' => 'required|date|after_or_equal:today',
                'date_fin_recurrence' => 'required|date|after_or_equal:date_debut_recurrence',
            ]);
            
            $startDate = Carbon::parse($request->date_debut_recurrence);
            $endDate = Carbon::parse($request->date_fin_recurrence);
            
            $daysMap = ['Dimanche' => 0, 'Lundi' => 1, 'Mardi' => 2, 'Mercredi' => 3, 'Jeudi' => 4, 'Vendredi' => 5, 'Samedi' => 6];
            $targetDay = $daysMap[$request->jour] ?? -1;
            
            $createdCount = 0;
            
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                if ($date->dayOfWeek === $targetDay) {
                    if ($date->isToday() && $request->debut <= $now->format('H:i')) {
                        continue;
                    }
                    
                    Disponibilite::create([
                        'professeur_id' => $profId,
                        'date_dispo' => $date->format('Y-m-d'),
                        'jour' => $request->jour,
                        'debut' => $request->debut,
                        'fin' => $request->fin,
                        'statut' => $request->statut ?? 'actif',
                        'actif' => 'OUI'
                    ]);
                    $createdCount++;
                }
            }
            
            if ($createdCount === 0) {
                return back()->withErrors(['jour' => 'Aucune date correspondante trouvée dans la plage spécifiée.'])->withInput();
            }
        }
        
        return back()->with('success', 'Disponibilités ajoutées avec succès.');
    }

    /** Update existing disponibilité */
    public function update(Request $request, $id)
    {
        $dispo = Disponibilite::findOrFail($id);
        
        $request->validate([
            'date_dispo' => 'required|date|after_or_equal:today',
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

        $now = now();
        if (Carbon::parse($request->date_dispo)->isToday() && $request->debut <= $now->format('H:i')) {
            return back()->withErrors(['debut' => 'L\'heure de début ne peut pas être dans le passé.'])->withInput();
        }

        $jourMap = [0 => 'Dimanche', 1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi'];
        $jourName = $jourMap[Carbon::parse($request->date_dispo)->dayOfWeek];

        $dispo->update([
            'date_dispo' => $request->date_dispo,
            'jour' => $jourName,
            'debut' => $request->debut,
            'fin' => $request->fin,
            'statut' => $request->statut ?? 'actif',
        ]);
        
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