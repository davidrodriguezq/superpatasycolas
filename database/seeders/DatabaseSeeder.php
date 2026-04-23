<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AnimalSeeder::class,
            AnimalPhotoSeeder::class,
            MedicalRecordSeeder::class,
            AdoptionRequestSeeder::class,
            CessionRequestSeeder::class,
            PostAdoptionFollowupSeeder::class,
            BlogPostSeeder::class,
        ]);
    }
}
