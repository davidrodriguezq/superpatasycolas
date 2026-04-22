<?php

namespace App\Enums;

enum AnimalSpecies: string
{
    case Dog = 'dog';
    case Cat = 'cat';

    public function label(): string
    {
        return match($this) {
            self::Dog => 'Perro',
            self::Cat => 'Gato',
        };
    }
}
