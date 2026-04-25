@extends('layouts.public')

@section('title', $animal->name . ' — Adopta en Super Patas y Colas')
@section('meta-description', 'Adopta a ' . $animal->name . ', ' . $animal->species->label() . ($animal->breed ? ' ' . $animal->breed : '') . ' de ' . $animal->age_formatted . '. Disponible en Super Patas y Colas, albergue en San Martín de Porres, Lima.')

@push('og-image')
<meta property="og:image" content="{{ $animal->primaryPhoto ? asset('storage/' . $animal->primaryPhoto->path) : asset('images/logo.png') }}">
@endpush

@section('content')

<section class="py-4 py-md-5">
    <div class="container">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('catalog.index') }}" class="text-decoration-none">Catálogo</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $animal->name }}</li>
            </ol>
        </nav>

        <div class="row g-4 g-md-5">

            {{-- Columna izquierda — Galería --}}
            <div class="col-md-6">
                @if($animal->photos->isNotEmpty())
                    <div class="position-relative mb-3">
                        <img id="mainPhoto"
                             src="{{ asset('storage/' . ($animal->primaryPhoto?->path ?? $animal->photos->first()->path)) }}"
                             alt="{{ $animal->name }}"
                             class="w-100 rounded-3 shadow-sm"
                             style="height: 360px; object-fit: cover;">
                    </div>
                    @if($animal->photos->count() > 1)
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach($animal->photos as $photo)
                        <img src="{{ asset('storage/' . $photo->path) }}"
                             alt="{{ $animal->name }}"
                             class="rounded spyc-thumb {{ $photo->is_primary ? 'spyc-thumb-active' : '' }}"
                             onclick="document.getElementById('mainPhoto').src=this.src; document.querySelectorAll('.spyc-thumb').forEach(t=>t.classList.remove('spyc-thumb-active')); this.classList.add('spyc-thumb-active');"
                             style="width:72px; height:72px; object-fit:cover; cursor:pointer;">
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="w-100 rounded-3 d-flex flex-column align-items-center justify-content-center"
                         style="height:360px; background:#f3ece1; color:#c5bcaf;">
                        <i class="bi bi-heart-pulse" style="font-size:3.5rem;"></i>
                        <span class="mt-2 small">Sin fotografías disponibles</span>
                    </div>
                @endif
            </div>

            {{-- Columna derecha — Datos y acción --}}
            <div class="col-md-6">
                <div class="d-flex align-items-start gap-3 mb-3 flex-wrap">
                    <h1 class="fw-bold mb-0" style="color:#2a2622; font-size:clamp(1.5rem,4vw,2rem);">
                        {{ $animal->name }}
                    </h1>
                    @if($animal->status->value === 'available')
                        <span class="badge bg-success align-self-center" style="font-size:.8rem; padding:6px 12px;">
                            Disponible para adopción
                        </span>
                    @else
                        <span class="badge bg-secondary align-self-center" style="font-size:.8rem; padding:6px 12px;">
                            {{ $animal->status->label() }}
                        </span>
                    @endif
                </div>

                {{-- Datos del animal --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                    <div class="card-body">
                        <dl class="row mb-0 small" style="row-gap:10px;">
                            <dt class="col-5 text-muted fw-normal">
                                <i class="bi bi-heart-pulse me-1 spyc-text-naranja"></i>Especie
                            </dt>
                            <dd class="col-7 fw-semibold mb-0">{{ $animal->species->label() }}</dd>

                            <dt class="col-5 text-muted fw-normal">
                                <i class="bi bi-tag me-1 spyc-text-naranja"></i>Raza
                            </dt>
                            <dd class="col-7 fw-semibold mb-0">{{ $animal->breed ?: 'Mestizo' }}</dd>

                            <dt class="col-5 text-muted fw-normal">
                                @if($animal->sex === 'male')
                                    <i class="bi bi-gender-male me-1 text-primary"></i>
                                @else
                                    <i class="bi bi-gender-female me-1" style="color:#d63384;"></i>
                                @endif
                                Sexo
                            </dt>
                            <dd class="col-7 fw-semibold mb-0">
                                {{ $animal->sex === 'male' ? 'Macho' : 'Hembra' }}
                            </dd>

                            <dt class="col-5 text-muted fw-normal">
                                <i class="bi bi-calendar3 me-1 spyc-text-naranja"></i>Edad aprox.
                            </dt>
                            <dd class="col-7 fw-semibold mb-0">{{ $animal->age_formatted }}</dd>

                            @if($animal->weight)
                            <dt class="col-5 text-muted fw-normal">
                                <i class="bi bi-speedometer2 me-1 spyc-text-naranja"></i>Peso
                            </dt>
                            <dd class="col-7 fw-semibold mb-0">{{ number_format((float) $animal->weight, 1) }} kg</dd>
                            @endif

                            <dt class="col-5 text-muted fw-normal">
                                <i class="bi bi-door-open me-1 spyc-text-naranja"></i>Ingresó
                            </dt>
                            <dd class="col-7 fw-semibold mb-0">{{ $animal->entry_date->format('d/m/Y') }}</dd>

                            <dt class="col-5 text-muted fw-normal">
                                <i class="bi bi-activity me-1 spyc-text-naranja"></i>Salud
                            </dt>
                            <dd class="col-7 fw-semibold mb-0">{{ $animal->health_status ?: '—' }}</dd>
                        </dl>
                    </div>
                </div>

                @if($animal->description)
                <p class="text-muted mb-4" style="line-height:1.65;">{{ $animal->description }}</p>
                @endif

                <hr class="my-3" style="border-color:#f0e8de;">

                {{-- Botón de acción --}}
                @if($animal->status->value !== 'available')
                    <div class="alert alert-warning border-0 d-flex align-items-center gap-2" style="border-radius:10px;">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                        <span>Este animal ya no está disponible para adopción.</span>
                    </div>
                @elseif(!auth()->check())
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Inicia sesión para solicitar adopción
                    </a>
                    <p class="text-center text-muted small mt-2">
                        ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
                    </p>
                @elseif(auth()->user()->hasRole('adopter'))
                    @if($hasPendingRequest)
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="bi bi-check-circle me-2"></i>Ya enviaste una solicitud
                        </button>
                        <p class="text-center small mt-2">
                            <a href="{{ route('adoption.my-requests') }}" class="text-decoration-none">
                                <i class="bi bi-list-ul me-1"></i>Ver mis solicitudes
                            </a>
                        </p>
                    @else
                        <a href="{{ route('adoption.create', $animal) }}"
                           class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-heart me-2"></i>Solicitar adopción de {{ $animal->name }}
                        </a>
                        <p class="text-muted small text-center mt-2 mb-0">
                            El equipo del albergue revisará tu solicitud y te contactará.
                        </p>
                    @endif
                @else
                    <div class="alert alert-info border-0 d-flex align-items-center gap-2" style="border-radius:10px;">
                        <i class="bi bi-info-circle fs-5"></i>
                        <span>Para más información sobre la adopción de {{ $animal->name }}, <a href="{{ route('contact') }}">contáctanos</a>.</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sección: otras mascotas sugeridas --}}
        @if($suggestions->isNotEmpty())
        <div class="mt-5 pt-4 border-top" style="border-color:#f0e8de !important;">
            <h3 class="fw-bold mb-4" style="color:#2a2622; font-size:1.2rem;">
                Otras mascotas que podrían interesarte
            </h3>
            <div class="row g-3">
                @foreach($suggestions as $s)
                @php $sp = $s->primaryPhoto; @endphp
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm spyc-catalog-card">
                        <div class="row g-0 align-items-center">
                            <div class="col-auto">
                                @if($sp)
                                    <img src="{{ asset('storage/' . $sp->path) }}"
                                         alt="{{ $s->name }}"
                                         class="rounded-start"
                                         style="width:80px; height:80px; object-fit:cover;">
                                @else
                                    <div class="rounded-start d-flex align-items-center justify-content-center"
                                         style="width:80px; height:80px; background:#f3ece1; color:#c5bcaf;">
                                        <i class="bi bi-heart-pulse fs-4"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <div class="card-body py-2 px-3">
                                    <h6 class="fw-bold mb-0" style="color:#2a2622;">{{ $s->name }}</h6>
                                    <div class="small text-muted">
                                        {{ $s->species->label() }}{{ $s->breed ? ' · ' . $s->breed : '' }}
                                    </div>
                                    <a href="{{ route('catalog.show', $s) }}"
                                       class="btn btn-outline-primary btn-sm mt-2 px-2 py-1"
                                       style="font-size:.78rem;">
                                        Ver perfil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@endsection

@push('styles')
<style>
.spyc-thumb {
    border: 2px solid transparent;
    opacity: .7;
    transition: all .15s ease;
}
.spyc-thumb:hover { opacity: 1; border-color: var(--spyc-dorado); }
.spyc-thumb-active { opacity: 1; border-color: var(--spyc-naranja) !important; }
.spyc-catalog-card {
    border-radius: 12px !important;
    transition: transform .2s ease, box-shadow .2s ease;
}
.spyc-catalog-card:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 24px rgba(0,0,0,.10) !important;
}
</style>
@endpush
