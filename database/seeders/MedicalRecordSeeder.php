<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            'Rocky' => [
                [
                    'date'         => '2025-11-15',
                    'type'         => 'Vacunación',
                    'description'  => 'Vacuna antirrábica y polivalente canina. Animal en buen estado general.',
                    'veterinarian' => 'Dr. Ramírez',
                ],
                [
                    'date'         => '2025-12-01',
                    'type'         => 'Desparasitación',
                    'description'  => 'Desparasitación interna y externa. Se aplicó ivermectina y praziquantel.',
                    'veterinarian' => 'Dr. Ramírez',
                ],
            ],
            'Max' => [
                [
                    'date'         => '2026-01-20',
                    'type'         => 'Control general',
                    'description'  => 'Examen clínico de ingreso. Animal joven y saludable, sin anomalías detectadas.',
                    'veterinarian' => 'Dra. Sánchez',
                ],
            ],
            'Canela' => [
                [
                    'date'         => '2026-03-05',
                    'type'         => 'Esterilización',
                    'description'  => 'Esterilización (ovariohisterectomía) realizada sin complicaciones. Recuperación satisfactoria.',
                    'veterinarian' => 'Dr. Villanueva',
                ],
            ],
            'Toby' => [
                [
                    'date'         => '2025-10-25',
                    'type'         => 'Vacunación',
                    'description'  => 'Vacuna antirrábica y polivalente canina. Animal en excelente condición física.',
                    'veterinarian' => 'Dr. Ramírez',
                ],
                [
                    'date'         => '2025-11-10',
                    'type'         => 'Desparasitación',
                    'description'  => 'Desparasitación interna y externa completada exitosamente.',
                    'veterinarian' => 'Dr. Ramírez',
                ],
            ],
            'Michi' => [
                [
                    'date'         => '2025-12-01',
                    'type'         => 'Control general',
                    'description'  => 'Control de cachorro. Peso adecuado para la edad. Se inicia calendario de vacunación.',
                    'veterinarian' => 'Dra. Sánchez',
                ],
                [
                    'date'         => '2026-01-10',
                    'type'         => 'Tratamiento dermatológico',
                    'description'  => 'Tratamiento para dermatitis leve en zona dorsal. Se aplicó pomada antibiótica y suplemento omega-3.',
                    'veterinarian' => 'Dr. Villanueva',
                ],
            ],
            'Firulais' => [
                [
                    'date'         => '2026-03-10',
                    'type'         => 'Control general',
                    'description'  => 'Evaluación de ingreso. Se detecta artritis leve en miembros posteriores. Se inicia tratamiento con antiinflamatorios.',
                    'veterinarian' => 'Dra. Sánchez',
                ],
            ],
        ];

        foreach ($records as $animalName => $animalRecords) {
            $animal = Animal::where('name', $animalName)->first();

            foreach ($animalRecords as $record) {
                MedicalRecord::create(array_merge($record, ['animal_id' => $animal->id]));
            }
        }
    }
}
