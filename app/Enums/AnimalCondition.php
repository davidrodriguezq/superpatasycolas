<?php

namespace App\Enums;

enum AnimalCondition: string
{
    case Good = 'good';
    case Fair = 'fair';
    case Poor = 'poor';

    public function label(): string
    {
        return match($this) {
            self::Good => 'Buena',
            self::Fair => 'Regular',
            self::Poor => 'Mala',
        };
    }
}
