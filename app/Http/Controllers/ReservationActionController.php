<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationAccepted;
use App\Mail\ReservationRefused;
use App\Mail\ReservationReportProposed;

class ReservationActionController extends Controller
{
    public function accept($id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('update', $reservation);
        $reservation->status = 'accepted';
        $reservation->save();
        Mail::to($reservation->user->email)->queue(new ReservationAccepted($reservation));
        return back()->with('success', 'Réservation acceptée');
    }

    public function refuse($id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('update', $reservation);
        $reservation->status = 'refused';
        $reservation->save();
        Mail::to($reservation->user->email)->queue(new ReservationRefused($reservation));
        return back()->with('success', 'Réservation refusée');
    }

    public function proposeReport($id, Request $request)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('update', $reservation);
        $data = $request->validate([
            'new_date' => 'required|date',
            'new_time' => 'required|date_format:H:i',
        ]);
        $reservation->status = 'rescheduled';
        $reservation->report_proposed_at = $data['new_date'] . ' ' . $data['new_time'];
        $reservation->save();
        Mail::to($reservation->user->email)->queue(new ReservationReportProposed($reservation, $data));
        return back()->with('success', 'Report proposé');
    }
}
?>
