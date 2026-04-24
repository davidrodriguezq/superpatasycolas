<?php

namespace App\Mail;

use App\Models\AdoptionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdoptionApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public AdoptionRequest $adoptionRequest)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Tu solicitud de adopción ha sido aprobada! - Super Patas y Colas',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.adoption-approved',
            with: [
                'adoptionRequest' => $this->adoptionRequest,
                'user'            => $this->adoptionRequest->user,
                'animal'          => $this->adoptionRequest->animal,
            ],
        );
    }
}
