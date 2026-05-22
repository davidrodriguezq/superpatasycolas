<?php

namespace App\Notifications;

use App\Enums\AnimalStatus;
use App\Models\Animal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnimalStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Animal $animal,
        private readonly string $newStatus,
    ) {}

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toArray(mixed $notifiable): array
    {
        $statusLabel = AnimalStatus::tryFrom($this->newStatus)?->label() ?? $this->newStatus;

        return [
            'title'     => 'Cambio de estado de animal',
            'message'   => "{$this->animal->name} cambió de estado a {$statusLabel}",
            'icon'      => 'bi-heart-pulse',
            'color'     => 'info',
            'url'       => route('admin.animals.show', $this->animal->id),
            'animal_id' => $this->animal->id,
        ];
    }
}
