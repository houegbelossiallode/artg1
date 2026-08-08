<?php
namespace App\Http\Controllers;

use App\Models\Disponibilite;
use App\Models\Reservation;
use App\Models\Cours;
use App\Models\User;
use App\Models\SupportCours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationAccepted;
use App\Mail\ReservationRefused;
use App\Mail\ReservationReportProposed;

class ProfesseurController extends Controller
{
    /** Dashboard for the professor */
    public function index()
    {
        $prof = Auth::user();
        $coursCount = Cours::where('user_id', $prof->id)->count();
        $reservationCount = Reservation::whereHas('course', fn($q) => $q->where('user_id', $prof->id))->count();
        $eleveCount = User::whereHas('reservations.course', fn($q) => $q->where('user_id', $prof->id))->distinct()->count();
        return view('dashboards.professeur', compact('prof','coursCount','reservationCount','eleveCount'));
    }

    /** Disponibilités CRUD */
    public function disponibilites()
    {
        $prof = Auth::user();
        $dispos = Disponibilite::where('professeur_id',$prof->id)->with('course')->get();
        return view('professeur.disponibilites.index', compact('dispos'));
    }
    public function storeDisponibilite(Request $request)
    {
        $data = $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'jour' => 'required|string',
            'debut' => 'required|date_format:H:i',
            'fin' => 'required|date_format:H:i|after:debut',
            'statut' => 'sometimes|string',
        ]);
        $data['professeur_id'] = Auth::id();
        Disponibilite::create($data);
        return back()->with('success','Disponibilité ajoutée');
    }
    public function updateDisponibilite(Request $request,$id)
    {
        $dispo = Disponibilite::findOrFail($id);
        $this->authorize('update',$dispo);
        $data = $request->validate([
            'jour' => 'required|string',
            'debut' => 'required|date_format:H:i',
            'fin' => 'required|date_format:H:i|after:debut',
            'statut' => 'sometimes|string',
        ]);
        $dispo->update($data);
        return back()->with('success','Disponibilité mise à jour');
    }
    public function destroyDisponibilite($id)
    {
        $dispo = Disponibilite::findOrFail($id);
        $this->authorize('delete',$dispo);
        $dispo->delete();
        return back()->with('success','Disponibilité supprimée');
    }

    /** Reservations list */
    public function reservations()
    {
        $prof = Auth::user();
        $reservations = Reservation::whereHas('course',fn($q)=>$q->where('user_id',$prof->id))
            ->with(['course','user'])->get();
        return view('professeur.reservations.index',compact('reservations'));
    }

    /** Students (élèves) list */
    public function eleves()
    {
        $prof = Auth::user();
        $eleves = User::whereHas('reservations.course',fn($q)=>$q->where('user_id',$prof->id))
            ->distinct()
            ->get();
        return view('professeur.eleves.index',compact('eleves'));
    }

    /** Supports management */
    public function supports()
    {
        $prof = Auth::user();
        $supports = SupportCours::whereHas('cours',fn($q)=>$q->where('user_id',$prof->id))
            ->with('cours')->get();
        return view('professeur.supports.index',compact('supports'));
    }
}
?>
