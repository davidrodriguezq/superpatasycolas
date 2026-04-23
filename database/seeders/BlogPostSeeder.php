<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@superpatasycolas.com')->first();

        $posts = [
            [
                'title'          => 'Campaña de adopción responsable en San Martín de Porres',
                'featured_image' => 'blog/campana-adopcion.jpg',
                'is_published'   => true,
                'content'        => "El pasado fin de semana, el albergue Super Patas y Colas organizó una exitosa campaña de adopción en el parque principal de San Martín de Porres. Más de 200 vecinos se acercaron a conocer a nuestros animales y tres de ellos encontraron nuevos hogares ese mismo día.\n\nEste tipo de eventos nos permite acercar el albergue a la comunidad y visibilizar la situación de los animales en situación de abandono. Agradecemos a todos los voluntarios que hicieron posible esta jornada: sin su ayuda, nada de esto sería posible.\n\nSi te perdiste la campaña, no te preocupes: pronto anunciaremos la fecha de nuestro próximo evento. Síguenos en redes sociales para estar al tanto de nuestras actividades y no olvides que en nuestro catálogo en línea puedes conocer a todos los animales disponibles para adopción.",
            ],
            [
                'title'          => 'Consejos para recibir a tu nueva mascota',
                'featured_image' => 'blog/consejos-adopcion.jpg',
                'is_published'   => true,
                'content'        => "Adoptar una mascota es una decisión maravillosa, pero también requiere preparación. Antes de que tu nuevo compañero llegue a casa, asegúrate de tener todo lo necesario: cama, comedero, bebedero, juguetes y, en el caso de los gatos, una caja de arena en un lugar privado.\n\nLos primeros días son clave para la adaptación. Dale espacio a tu mascota para que explore el ambiente a su propio ritmo. Evita las visitas masivas durante la primera semana y mantén una rutina de alimentación y paseos desde el primer día. La constancia genera confianza.\n\nRecuerda agendar una visita al veterinario dentro de los primeros siete días para una revisión general y actualizar el calendario de vacunas si es necesario. En el albergue te entregamos toda la información médica disponible del animal para que el veterinario pueda darle la mejor atención.",
            ],
            [
                'title'          => 'Próxima jornada de esterilización gratuita',
                'featured_image' => 'blog/jornada-esterilizacion.jpg',
                'is_published'   => false,
                'content'        => "En coordinación con la Municipalidad de San Martín de Porres y la clínica veterinaria VetSalud, el albergue Super Patas y Colas organizará una jornada gratuita de esterilización para perros y gatos. El evento está pensado para familias de bajos recursos económicos que deseen esterilizar a sus mascotas pero no cuentan con los medios para costear la cirugía.\n\nLa jornada se realizará en las instalaciones del albergue. Se atenderá por orden de llegada con un máximo de 30 animales por día. Los animales deben llegar en ayunas de 8 horas y con correa o transportadora según corresponda.\n\nPróximamente publicaremos la fecha confirmada y el procedimiento de inscripción. Si deseas recibir información directa, escríbenos a través del formulario de contacto de nuestra página web.",
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create(array_merge($post, [
                'user_id' => $admin->id,
                'slug'    => Str::slug($post['title']),
            ]));
        }
    }
}
