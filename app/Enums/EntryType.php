<?php

namespace App\Enums;

enum EntryType: string
{
    case Rescue  = 'rescue';
    case Cession = 'cession';

    public function label(): string
    {
        return match($this) {
            self::Rescue  => 'Rescate',
            self::Cession => 'Cesión',
        };
    }
}
