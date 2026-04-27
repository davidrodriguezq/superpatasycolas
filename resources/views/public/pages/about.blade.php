@extends('layouts.public')

@section('title', 'Sobre nosotros — Super Patas y Colas')
@section('meta-description', 'Conoce la historia, misión y equipo de Super Patas y Colas, albergue de animales en San Martín de Porres, Lima.')

@section('content')

{{-- Hero --}}
<section class="spyc-bg-rosa py-4 py-md-5">
    <div class="container text-center">
        <h1 class="fw-bold mb-2" style="color:#2a2622; font-size:clamp(1.4rem,4vw,2rem);">
            Sobre Super Patas y Colas
        </h1>
        <p class="text-muted mb-0">Albergue de animales en San Martín de Porres, Lima</p>
    </div>
</section>

{{-- Nuestra historia --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-md-5 text-center">
                <div class="d-inline-block p-3 rounded-3 shadow-sm" style="background:#FFF5EE;">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Super Patas y Colas"
                         style="width:160px; height:160px; object-fit:contain;">
                </div>
            </div>
            <div class="col-md-7">
                <h2 class="fw-bold mb-3" style="color:#2a2622;">Nuestra historia</h2>
                <p class="text-muted" style="line-height:1.7;">
                    Super Patas y Colas nace en 2019 con la misión de brindar refugio temporal y cuidado a
                    perros y gatos en situación de abandono en San Martín de Porres, Lima. Desde entonces,
                    hemos rescatado y dado en adopción a decenas de animales, gracias al compromiso de
                    nuestros voluntarios y la comunidad.
                </p>
                <p class="text-muted" style="line-height:1.7;">
                    Creemos que cada animal merece una segunda oportunidad y que cada adopción responsable
                    transforma vidas. Nuestro trabajo no sería posible sin el apoyo de personas como tú.
                </p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-search-heart me-2"></i>Ver mascotas disponibles
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Misión y Visión --}}
<section class="py-5 spyc-bg-rosa">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color:#2a2622;">Misión y Visión</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="spyc-about-icon-wrap">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <h4 class="fw-bold mb-0" style="color:#2a2622;">Misión</h4>
                        </div>
                        <p class="text-muted mb-0" style="line-height:1.7;">
                            Rescatar, rehabilitar y dar en adopción responsable a perros y gatos en situación
                            de abandono, promoviendo una cultura de respeto hacia los animales en la comunidad
                            de San Martín de Porres y Lima Metropolitana.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="spyc-about-icon-wrap">
                                <i class="bi bi-eye"></i>
                            </div>
                            <h4 class="fw-bold mb-0" style="color:#2a2622;">Visión</h4>
                        </div>
                        <p class="text-muted mb-0" style="line-height:1.7;">
                            Ser el albergue de referencia en San Martín de Porres, reconocido por su gestión
                            transparente, su impacto positivo en la reducción del abandono animal y su red de
                            adoptantes responsables.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Nuestro equipo --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1" style="color:#2a2622;">Nuestro equipo</h2>
            <p class="text-muted">Personas que hacen posible esta labor</p>
        </div>
        <div class="row g-4 justify-content-center">
            @php
            $equipo = [
                ['iniciales' => 'VR', 'nombre' => 'Valeria Ríos', 'cargo' => 'Fundadora y directora', 'frase' => '"Cada animal tiene derecho a un hogar lleno de amor."'],
                ['iniciales' => 'JM', 'nombre' => 'Jorge Mendoza', 'cargo' => 'Coordinador de adopciones', 'frase' => '"Conectar familias con mascotas es lo más gratificante que hago."'],
                ['iniciales' => 'AL', 'nombre' => 'Andrea Lozano', 'cargo' => 'Voluntaria veterinaria', 'frase' => '"La salud de cada animal es nuestra prioridad número uno."'],
                ['iniciales' => 'CT', 'nombre' => 'Carlos Torres', 'cargo' => 'Voluntario de rescate', 'frase' => '"Ningún llamado de auxilio animal queda sin respuesta."'],
            ];
            @endphp
            @foreach($equipo as $m)
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center h-100" style="border-radius:12px;">
                    <div class="card-body p-3 p-md-4">
                        <div class="spyc-avatar mx-auto mb-3">{{ $m['iniciales'] }}</div>
                        <div class="fw-bold mb-1" style="color:#2a2622;">{{ $m['nombre'] }}</div>
                        <div class="small text-muted mb-2">{{ $m['cargo'] }}</div>
                        <div class="small" style="color:#8a7f72; font-style:italic;">{{ $m['frase'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <p class="text-center text-muted mt-4 mb-0">
            ¿Quieres ser parte del equipo?
            <a href="{{ route('contact') }}" class="text-decoration-none fw-semibold">Contáctanos.</a>
        </p>
    </div>
</section>

{{-- Contacto --}}
<section class="py-5 spyc-bg-rosa">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1" style="color:#2a2622;">¿Cómo contactarnos?</h2>
            <p class="text-muted">Escríbenos o llámanos para coordinar tu visita</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0" style="line-height:2;">
                            <li class="d-flex gap-3">
                                <i class="bi bi-geo-alt-fill spyc-text-naranja flex-shrink-0 mt-1"></i>
                                <span>
                                    Nos ubicamos en el distrito de San Martín de Porres, Lima.
                                    Para conocer nuestra ubicación exacta, contáctanos por correo o teléfono y coordinaremos una visita.
                                </span>
                            </li>
                            <li class="d-flex gap-3">
                                <i class="bi bi-telephone-fill spyc-text-naranja flex-shrink-0 mt-1"></i>
                                <span>+51 999 000 000</span>
                            </li>
                            <li class="d-flex gap-3">
                                <i class="bi bi-envelope-fill spyc-text-naranja flex-shrink-0 mt-1"></i>
                                <span>contacto@superpatasycolas.pe</span>
                            </li>
                            <li class="d-flex gap-3">
                                <i class="bi bi-clock-fill spyc-text-naranja flex-shrink-0 mt-1"></i>
                                <span>Visitas: sábados y domingos · 10:00 – 17:00</span>
                            </li>
                        </ul>
                        <div class="mt-3">
                            <a href="{{ route('contact') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-envelope me-1"></i> Envíanos un mensaje
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.spyc-about-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--spyc-rosa);
    color: var(--spyc-naranja);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.spyc-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--spyc-dorado), var(--spyc-naranja));
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
}
</style>
@endpush
