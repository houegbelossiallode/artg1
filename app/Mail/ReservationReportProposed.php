<?php
namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationReportProposed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reservation;
    public $newData;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation, array $newData)
    {
        $this->reservation = $reservation;
        $this->newData = $newData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Proposition de report pour votre réservation')
                    ->markdown('emails.reservation_report_proposed');
    }
}
?>
