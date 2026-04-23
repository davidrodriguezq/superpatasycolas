<?php

namespace Database\Seeders;

use App\Enums\AnimalCondition;
use App\Enums\HomeCondition;
use App\Models\AdoptionRequest;
use App\Models\PostAdoptionFollowup;
use Illuminate\Database\Seeder;

class PostAdoptionFollowupSeeder extends Seeder
{
    public function run(): void
    {
        $tobyRequest  = AdoptionRequest::where('tracking_code', 'SPC-20260115-0003')->first();
        $michiRequest = AdoptionRequest::where('tracking_code', 'SPC-20260120-0004')->first();

        $followups = [
            [
                'adoption_request_id' => $tobyRequest->id,
                'visit_date'          => '2026-02-15',
                'animal_condition'    => AnimalCondition::Good->value,
                'home_condition'      => HomeCondition::Adequate->value,
                'observations'        => 'Toby se encuentra en excelente estado de salud. Convive perfectamente con los dos niños de la familia. El hogar cuenta con jardín amplio y el animal dispone de su propio espacio con cama y juguetes. La familia muestra compromiso y cariño hacia el animal.',
            ],
            [
                'adoption_request_id' => $michiRequest->id,
                'visit_date'          => '2026-02-20',
                'animal_condition'    => AnimalCondition::Good->value,
                'home_condition'      => HomeCondition::Adequate->value,
                'observations'        => 'Michi se ha adaptado bien a su nuevo hogar. Está activo, bien alimentado y con su calendario de vacunas al día. Las adoptantes demostraron conocimiento en el cuidado felino y el departamento es adecuado para un gato de interior.',
            ],
            [
                'adoption_request_id' => $tobyRequest->id,
                'visit_date'          => '2026-03-15',
                'animal_condition'    => AnimalCondition::Fair->value,
                'home_condition'      => HomeCondition::NeedsImprovement->value,
                'observations'        => 'En esta segunda visita se observó que Toby ha bajado de peso ligeramente. La familia informa que por viajes de trabajo el perro quedó al cuidado de un vecino. Se recomienda mejorar la rutina de alimentación y retomar las caminatas diarias. Se programó visita de seguimiento en 30 días.',
            ],
        ];

        foreach ($followups as $data) {
            PostAdoptionFollowup::create($data);
        }
    }
}
