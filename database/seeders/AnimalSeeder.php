<?php

namespace Database\Seeders;

use App\Enums\AnimalSpecies;
use App\Enums\AnimalStatus;
use App\Enums\EntryType;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    public function run(): void
    {
        $pedro  = User::where('email', 'pedro.huaman@gmail.com')->first();
        $carmen = User::where('email', 'carmen.quispe@gmail.com')->first();

        $animals = [
            [
                'name'             => 'Rocky',
                'species'          => AnimalSpecies::Dog->value,
                'breed'            => 'Mestizo',
                'sex'              => 'male',
                'approximate_age'  => '3 años',
                'weight'           => 18.50,
                'health_status'    => 'Saludable',
                'description'      => 'Rocky es un perro alegre y muy sociable que se lleva bien con niños. Le encanta correr y jugar al aire libre.',
                'status'           => AnimalStatus::Available->value,
                'entry_date'       => '2025-11-10',
                'entry_type'       => EntryType::Rescue->value,
                'user_id'          => null,
            ],
            [
                'name'             => 'Luna',
                'species'          => AnimalSpecies::Cat->value,
                'breed'            => 'Siamés',
                'sex'              => 'female',
                'approximate_age'  => '2 años',
                'weight'           => 3.20,
                'health_status'    => 'Saludable',
                'description'      => 'Luna es una gata tranquila y cariñosa, ideal para hogares con ambiente apacible. Disfruta del sol y las caricias.',
                'status'           => AnimalStatus::Available->value,
                'entry_date'       => '2025-12-05',
                'entry_type'       => EntryType::Rescue->value,
                'user_id'          => null,
            ],
            [
                'name'             => 'Max',
                'species'          => AnimalSpecies::Dog->value,
                'breed'            => 'Labrador',
                'sex'              => 'male',
                'approximate_age'  => '1 año',
                'weight'           => 22.00,
                'health_status'    => 'Saludable',
                'description'      => 'Max es un labrador joven y enérgico, muy obediente y fácil de entrenar. Ideal para familias activas.',
                'status'           => AnimalStatus::Available->value,
                'entry_date'       => '2026-01-15',
                'entry_type'       => EntryType::Rescue->value,
                'user_id'          => null,
            ],
            [
                'name'             => 'Pelusa',
                'species'          => AnimalSpecies::Cat->value,
                'breed'            => 'Persa',
                'sex'              => 'female',
                'approximate_age'  => '4 años',
                'weight'           => 4.10,
                'health_status'    => 'Saludable',
                'description'      => 'Pelusa es una gata persa muy tranquila, de pelaje largo y esponjoso. Perfecta para un hogar sin otros animales.',
                'status'           => AnimalStatus::Available->value,
                'entry_date'       => '2026-02-03',
                'entry_type'       => EntryType::Rescue->value,
                'user_id'          => null,
            ],
            [
                'name'             => 'Canela',
                'species'          => AnimalSpecies::Dog->value,
                'breed'            => 'Mestizo',
                'sex'              => 'female',
                'approximate_age'  => '5 años',
                'weight'           => 14.00,
                'health_status'    => 'Saludable',
                'description'      => 'Canela es una perra adulta muy dulce y dócil. Convive bien con otros animales y es muy tranquila dentro del hogar.',
                'status'           => AnimalStatus::Available->value,
                'entry_date'       => '2026-02-28',
                'entry_type'       => EntryType::Rescue->value,
                'user_id'          => null,
            ],
            [
                'name'             => 'Toby',
                'species'          => AnimalSpecies::Dog->value,
                'breed'            => 'Pastor Alemán',
                'sex'              => 'male',
                'approximate_age'  => '4 años',
                'weight'           => 29.80,
                'health_status'    => 'Saludable',
                'description'      => 'Toby es un pastor alemán leal y protector. Ya fue adoptado y vive feliz con su nueva familia en Los Olivos.',
                'status'           => AnimalStatus::Adopted->value,
                'entry_date'       => '2025-10-20',
                'entry_type'       => EntryType::Rescue->value,
                'user_id'          => null,
            ],
            [
                'name'             => 'Michi',
                'species'          => AnimalSpecies::Cat->value,
                'breed'            => 'Mestizo',
                'sex'              => 'male',
                'approximate_age'  => '2 meses',
                'weight'           => 1.50,
                'health_status'    => 'Saludable',
                'description'      => 'Michi llegó al albergue siendo un cachorro muy pequeño. Fue adoptado por una familia de San Martín de Porres.',
                'status'           => AnimalStatus::Adopted->value,
                'entry_date'       => '2025-11-25',
                'entry_type'       => EntryType::Rescue->value,
                'user_id'          => null,
            ],
            [
                'name'             => 'Copito',
                'species'          => AnimalSpecies::Dog->value,
                'breed'            => 'Shih Tzu',
                'sex'              => 'male',
                'approximate_age'  => '6 años',
                'weight'           => 6.50,
                'health_status'    => 'Saludable',
                'description'      => 'Copito es un Shih Tzu tranquilo y afectuoso, cedido por su dueño por motivos de mudanza. Actualmente tiene una solicitud de adopción en evaluación.',
                'status'           => AnimalStatus::InProcess->value,
                'entry_date'       => '2026-01-08',
                'entry_type'       => EntryType::Cession->value,
                'user_id'          => $pedro->id,
            ],
            [
                'name'             => 'Negrita',
                'species'          => AnimalSpecies::Cat->value,
                'breed'            => 'Mestizo',
                'sex'              => 'female',
                'approximate_age'  => '3 años',
                'weight'           => 3.80,
                'health_status'    => 'Saludable',
                'description'      => 'Negrita es una gata mestiza de pelaje negro brillante. Fue cedida por su dueña por problemas económicos y está en proceso de adopción.',
                'status'           => AnimalStatus::InProcess->value,
                'entry_date'       => '2026-02-14',
                'entry_type'       => EntryType::Cession->value,
                'user_id'          => $carmen->id,
            ],
            [
                'name'             => 'Firulais',
                'species'          => AnimalSpecies::Dog->value,
                'breed'            => 'Mestizo',
                'sex'              => 'male',
                'approximate_age'  => '8 años',
                'weight'           => 12.30,
                'health_status'    => 'En tratamiento',
                'description'      => 'Firulais es un perro mayor cedido por su dueño por enfermedad. Actualmente en cuarentena para evaluación de salud antes de ser puesto en adopción.',
                'status'           => AnimalStatus::Quarantine->value,
                'entry_date'       => '2026-03-01',
                'entry_type'       => EntryType::Cession->value,
                'user_id'          => $pedro->id,
            ],
        ];

        foreach ($animals as $data) {
            Animal::create($data);
        }
    }
}
