<?php

namespace App\Notifications;

use App\Models\PostAdoptionFollowup;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CriticalFollowup extends Notification
{
    use Queueable;

    public function __construct(private readonly PostAdoptionFollowup $followup) {}

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toArray(mixed $notifiable): array
    {
        $animal  = $this->followup->adoptionRequest?->animal?->name ?? 'un animal';
        $adopter = $this->followup->adoptionRequest?->user?->name ?? 'el adoptante';

        return [
            'title'       => 'Alerta de seguimiento crítico',
            'message'     => "El seguimiento de {$animal} (adoptado por {$adopter}) presenta condiciones que requieren atención",
            'icon'        => 'bi-exclamation-triangle',
            'color'       => 'danger',
            'url'         => route('admin.followups.show', $this->followup->id),
            'followup_id' => $this->followup->id,
        ];
    }
}
