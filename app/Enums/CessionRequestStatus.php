<?php

namespace App\Enums;

enum CessionRequestStatus: string
{
    case Pending  = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::Pending  => 'Pendiente',
            self::Accepted => 'Aceptada',
            self::Rejected => 'Rechazada',
        };
    }
}
