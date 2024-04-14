<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordCode extends Mailable
{


    use Queueable, SerializesModels;

    public $code;
    /**
     * Crée une nouvelle instance du message.
     *
     * @param string $code Le code de réinitialisation du mot de passe
     */
    public function __construct($code)
    {
       $this->code = $code;
    }

    /**
     * Obtient l'enveloppe du message.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Code',
        );
    }

    /**
     * Obtient la définition du contenu du message.
     *
     * @return \Illuminate\Mail\Mailables\Content La définition du contenu du message
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.passwordCodeEmail',
        );
    }

    /**
     * Obtient les pièces jointes du message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
