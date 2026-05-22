<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'shelter_name'         => 'Super Patas y Colas',
            'shelter_slogan'       => 'Albergue de animales · SMP, Lima',
            'shelter_description'  => 'Damos hogar a perros y gatos rescatados en San Martín de Porres desde 2019. Cada adopción responsable cambia dos vidas.',
            'shelter_district'     => 'San Martín de Porres',
            'shelter_city'         => 'Lima, Perú',
            'shelter_phone'        => '+51 999 000 000',
            'shelter_email'        => 'contacto@superpatasycolas.pe',
            'shelter_schedule'     => 'Sábados y domingos de 10:00 a 17:00',
            'shelter_facebook'     => '',
            'shelter_instagram'    => '',
            'shelter_mission'      => 'Rescatar, rehabilitar y dar en adopción responsable a perros y gatos en situación de abandono, promoviendo una cultura de respeto hacia los animales en la comunidad.',
            'shelter_vision'       => 'Ser el albergue de referencia en San Martín de Porres, reconocido por su gestión transparente y su impacto positivo en la reducción del abandono animal.',
            'shelter_history'      => 'Super Patas y Colas nace en 2019 con la misión de brindar refugio temporal y cuidado a perros y gatos en situación de abandono en San Martín de Porres, Lima. Desde entonces, hemos rescatado y dado en adopción a decenas de animales, gracias al compromiso de nuestros voluntarios y la comunidad.',
            'shelter_privacy_note' => 'Por seguridad de nuestros animales, la dirección exacta se comparte al coordinar una visita.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
