<?php

namespace App\Notifications;

use App\Models\AdoptionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAdoptionRequest extends Notification
{
    use Queueable;

    public function __construct(private readonly AdoptionRequest $adoptionRequest) {}

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toArray(mixed $notifiable): array
    {
        $adopter = $this->adoptionRequest->user?->name ?? 'Alguien';
        $animal  = $this->adoptionRequest->animal?->name ?? 'un animal';

        return [
            'title'               => 'Nueva solicitud de adopción',
            'message'             => "{$adopter} ha solicitado adoptar a {$animal}",
            'icon'                => 'bi-house-heart',
            'color'               => 'primary',
            'url'                 => route('admin.adoption-requests.show', $this->adoptionRequest->id),
            'adoption_request_id' => $this->adoptionRequest->id,
        ];
    }
}
