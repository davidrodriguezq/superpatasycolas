<?php

namespace Database\Seeders;

use App\Enums\AdoptionRequestStatus;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdoptionRequestSeeder extends Seeder
{
    public function run(): void
    {
        $ana   = User::where('email', 'ana.torres@gmail.com')->first();
        $luis  = User::where('email', 'luis.mendoza@gmail.com')->first();
        $rosa  = User::where('email', 'rosa.flores@gmail.com')->first();

        $rocky  = Animal::where('name', 'Rocky')->first();
        $toby   = Animal::where('name', 'Toby')->first();
        $michi  = Animal::where('name', 'Michi')->first();
        $copito = Animal::where('name', 'Copito')->first();
        $negrita = Animal::where('name', 'Negrita')->first();

        $requests = [
            [
                'user_id'           => $ana->id,
                'animal_id'         => $copito->id,
                'housing_type'      => 'Departamento',
                'household_members' => 3,
                'previous_pets'     => true,
                'motivation'        => 'Siempre he querido tener un perro pequeño y tranquilo que se adapte a vivir en departamento. Tengo experiencia cuidando mascotas y cuento con el espacio y el tiempo necesarios para brindarle un hogar cálido a Copito.',
                'status'            => AdoptionRequestStatus::Pending->value,
                'tracking_code'     => 'SPC-20260310-0001',
            ],
            [
                'user_id'           => $luis->id,
                'animal_id'         => $negrita->id,
                'housing_type'      => 'Casa propia',
                'household_members' => 2,
                'previous_pets'     => false,
                'motivation'        => 'Mi esposa y yo llevamos mucho tiempo queriendo adoptar una gata. Negrita nos parece perfecta por su temperamento tranquilo. Vivimos en casa propia con patio y tenemos todas las condiciones para recibirla.',
                'status'            => AdoptionRequestStatus::Pending->value,
                'tracking_code'     => 'SPC-20260312-0002',
            ],
            [
                'user_id'           => $rosa->id,
                'animal_id'         => $toby->id,
                'housing_type'      => 'Casa propia',
                'household_members' => 4,
                'previous_pets'     => true,
                'motivation'        => 'Toda mi familia ama a los perros grandes. Tenemos una casa amplia con jardín en Los Olivos, ideal para un pastor alemán. Mi esposo y yo hemos criado perros toda la vida y queremos darle a Toby el hogar que merece.',
                'status'            => AdoptionRequestStatus::Approved->value,
                'tracking_code'     => 'SPC-20260115-0003',
            ],
            [
                'user_id'           => $ana->id,
                'animal_id'         => $michi->id,
                'housing_type'      => 'Casa alquilada',
                'household_members' => 2,
                'previous_pets'     => true,
                'motivation'        => 'Vivo sola con mi hermana y queremos adoptar un gatito para que nos acompañe. Tenemos experiencia con gatos y la dueña de la casa nos permitió tener mascotas. Michi encaja perfecto con nuestro ritmo de vida.',
                'status'            => AdoptionRequestStatus::Approved->value,
                'tracking_code'     => 'SPC-20260120-0004',
            ],
            [
                'user_id'           => $luis->id,
                'animal_id'         => $rocky->id,
                'housing_type'      => 'Departamento',
                'household_members' => 1,
                'previous_pets'     => false,
                'motivation'        => 'Me gustaría adoptar a Rocky para hacerle compañía en mi departamento. Trabajo desde casa y podría dedicarle bastante tiempo.',
                'status'            => AdoptionRequestStatus::Rejected->value,
                'tracking_code'     => 'SPC-20260205-0005',
            ],
        ];

        foreach ($requests as $data) {
            AdoptionRequest::create($data);
        }
    }
}
