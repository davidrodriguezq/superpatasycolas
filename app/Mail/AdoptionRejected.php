<?php

namespace App\Mail;

use App\Models\AdoptionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdoptionRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public AdoptionRequest $adoptionRequest)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Actualización sobre tu solicitud de adopción - Super Patas y Colas',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.adoption-rejected',
            with: [
                'adoptionRequest' => $this->adoptionRequest,
                'user'            => $this->adoptionRequest->user,
                'animal'          => $this->adoptionRequest->animal,
            ],
        );
    }
}
