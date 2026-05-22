<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            AnimalSeeder::class,
            AnimalPhotoSeeder::class,
            MedicalRecordSeeder::class,
            AdoptionRequestSeeder::class,
            // CessionRequestSeeder::class, // CessionRequestSeeder desactivado — módulo de cesión deshabilitado
            PostAdoptionFollowupSeeder::class,
            BlogPostSeeder::class,
        ]);
    }
}
