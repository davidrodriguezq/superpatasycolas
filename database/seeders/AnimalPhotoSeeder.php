<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\AnimalPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnimalPhotoSeeder extends Seeder
{
    // Animales que reciben una segunda foto
    private const WITH_TWO_PHOTOS = ['Rocky', 'Luna', 'Pelusa', 'Toby', 'Michi', 'Negrita'];

    public function run(): void
    {
        $animals = Animal::all();

        foreach ($animals as $animal) {
            $slug = Str::slug($animal->name);

            AnimalPhoto::create([
                'animal_id'  => $animal->id,
                'path'       => "animals/{$slug}_1.jpg",
                'is_primary' => true,
            ]);

            if (in_array($animal->name, self::WITH_TWO_PHOTOS)) {
                AnimalPhoto::create([
                    'animal_id'  => $animal->id,
                    'path'       => "animals/{$slug}_2.jpg",
                    'is_primary' => false,
                ]);
            }
        }
    }
}
