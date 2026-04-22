<?php

namespace App\Enums;

enum AnimalStatus: string
{
    case Available = 'available';
    case InProcess = 'in_process';
    case Adopted = 'adopted';
    case Quarantine = 'quarantine';
    case Deceased = 'deceased';

    public function label(): string
    {
        return match($this) {
            self::Available  => 'Disponible',
            self::InProcess  => 'En proceso',
            self::Adopted    => 'Adoptado',
            self::Quarantine => 'En cuarentena',
            self::Deceased   => 'Fallecido',
        };
    }
}
