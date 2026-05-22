@extends('layouts.public')

@section('title', 'Política de privacidad — Super Patas y Colas')
@section('meta-description', 'Política de privacidad y tratamiento de datos personales del albergue Super Patas y Colas conforme a la Ley N° 29733 del Perú.')

@section('content')

{{-- Hero --}}
<section class="spyc-bg-rosa py-4 py-md-5">
    <div class="container text-center">
        <h1 class="fw-bold mb-2" style="color:#2a2622; font-size:clamp(1.4rem,4vw,2rem);">
            Política de Privacidad y Tratamiento de Datos Personales
        </h1>
        <p class="text-muted mb-0">Última actualización: abril de 2026</p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container" style="max-width:800px;">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body p-4 p-md-5">

                <h5 class="fw-bold mb-2" style="color:#2a2622;">1. Responsable del tratamiento</h5>
                <p class="text-muted mb-4" style="line-height:1.7;">
                    Super Patas y Colas, albergue de animales ubicado en el distrito de San Martín de Porres, Lima, Perú,
                    es responsable del tratamiento de los datos personales proporcionados a través de este sitio web.
                </p>

                <h5 class="fw-bold mb-2" style="color:#2a2622;">2. Datos que recopilamos</h5>
                <p class="text-muted mb-4" style="line-height:1.7;">
                    Al registrarse en nuestra plataforma, se recopilan los siguientes datos personales: nombre completo,
                    correo electrónico, teléfono (opcional) y dirección (opcional). Al enviar una solicitud de adopción,
                    se recopilan adicionalmente: tipo de vivienda, cantidad de personas en el hogar, tenencia de mascotas,
                    disponibilidad de espacio exterior y motivación para la adopción.
                </p>

                <h5 class="fw-bold mb-2" style="color:#2a2622;">3. Finalidad del tratamiento</h5>
                <p class="text-muted mb-4" style="line-height:1.7;">
                    Sus datos personales se utilizan exclusivamente para: gestionar su cuenta de usuario, procesar y
                    evaluar solicitudes de adopción, realizar seguimiento post-adopción del bienestar del animal, y
                    comunicarnos con usted respecto a su solicitud o consulta.
                </p>

                <h5 class="fw-bold mb-2" style="color:#2a2622;">4. Compartición de datos</h5>
                <p class="text-muted mb-4" style="line-height:1.7;">
                    Sus datos personales no serán compartidos, vendidos ni cedidos a terceros. Solo serán accesibles por
                    el personal autorizado del albergue Super Patas y Colas.
                </p>

                <h5 class="fw-bold mb-2" style="color:#2a2622;">5. Derechos del titular</h5>
                <p class="text-muted mb-4" style="line-height:1.7;">
                    De conformidad con la Ley N° 29733, Ley de Protección de Datos Personales del Perú, usted tiene
                    derecho a acceder, rectificar, cancelar y oponerse al tratamiento de sus datos personales. Para
                    ejercer estos derechos, puede contactarnos a través del correo
                    <a href="mailto:{{ $settings['shelter_email'] ?? 'contacto@superpatasycolas.pe' }}">{{ $settings['shelter_email'] ?? 'contacto@superpatasycolas.pe' }}</a>.
                </p>

                <h5 class="fw-bold mb-2" style="color:#2a2622;">6. Seguridad</h5>
                <p class="text-muted mb-4" style="line-height:1.7;">
                    Implementamos medidas de seguridad técnicas y organizativas para proteger sus datos personales contra
                    el acceso no autorizado, la alteración, divulgación o destrucción.
                </p>

                <h5 class="fw-bold mb-2" style="color:#2a2622;">7. Consentimiento</h5>
                <p class="text-muted mb-0" style="line-height:1.7;">
                    Al registrarse y utilizar este sitio web, usted otorga su consentimiento libre, expreso e informado
                    para el tratamiento de sus datos personales conforme a esta política.
                </p>

            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-1"></i> Volver al inicio
            </a>
        </div>
    </div>
</section>

@endsection
