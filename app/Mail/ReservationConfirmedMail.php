<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de votre réservation ARTG',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $meetingUrl = null;
        if ($this->reservation->jitsi_room_id) {
            $meetingUrl = route('meeting.show', $this->reservation->id);
        }

        return new Content(
            markdown: 'emails.reservation_confirmed',
            with: [
                'reservation' => $this->reservation,
                'cours' => $this->reservation->course,
                'user' => $this->reservation->user,
                'meetingUrl' => $meetingUrl,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
