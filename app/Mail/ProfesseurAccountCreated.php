<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ProfesseurAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $professeur;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct(User $professeur, string $password)
    {
        $this->professeur = $professeur;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vos identifiants d\'accès Professeur - ARTG',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.professeur_account_created',
        );
    }
}
