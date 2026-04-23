<?php

namespace Database\Seeders;

use App\Enums\AnimalCondition;
use App\Enums\CessionRequestStatus;
use App\Models\Animal;
use App\Models\CessionRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class CessionRequestSeeder extends Seeder
{
    public function run(): void
    {
        $pedro  = User::where('email', 'pedro.huaman@gmail.com')->first();
        $carmen = User::where('email', 'carmen.quispe@gmail.com')->first();

        $copito  = Animal::where('name', 'Copito')->first();
        $negrita = Animal::where('name', 'Negrita')->first();

        $requests = [
            [
                'user_id'          => $pedro->id,
                'animal_id'        => $copito->id,
                'reason'           => 'Me mudo a un departamento que no acepta mascotas. Copito lleva 6 años conmigo y quiero asegurarme de que vaya a un buen hogar donde lo cuiden como se merece.',
                'animal_condition' => AnimalCondition::Good->value,
                'status'           => CessionRequestStatus::Accepted->value,
            ],
            [
                'user_id'          => $carmen->id,
                'animal_id'        => $negrita->id,
                'reason'           => 'Problemas económicos me impiden seguir manteniendo a Negrita. Ha estado bien cuidada, pero ya no puedo costear su alimentación y atención veterinaria.',
                'animal_condition' => AnimalCondition::Good->value,
                'status'           => CessionRequestStatus::Accepted->value,
            ],
            [
                'user_id'          => $pedro->id,
                'animal_id'        => null,
                'reason'           => 'Enfermedad crónica me impide continuar cuidando a mi perro Firulais. Tiene 8 años y necesita atención veterinaria regular que ya no puedo proporcionarle.',
                'animal_condition' => AnimalCondition::Fair->value,
                'status'           => CessionRequestStatus::Pending->value,
            ],
        ];

        foreach ($requests as $data) {
            CessionRequest::create($data);
        }
    }
}
