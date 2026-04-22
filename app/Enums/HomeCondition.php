<?php

namespace App\Enums;

enum HomeCondition: string
{
    case Adequate         = 'adequate';
    case NeedsImprovement = 'needs_improvement';
    case Inadequate       = 'inadequate';

    public function label(): string
    {
        return match($this) {
            self::Adequate         => 'Adecuado',
            self::NeedsImprovement => 'Necesita mejoras',
            self::Inadequate       => 'Inadecuado',
        };
    }
}
