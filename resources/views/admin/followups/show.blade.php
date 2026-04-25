@extends('layouts.admin')

@section('title', 'Seguimiento #' . $followup->id . ' - Admin')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.followups.index') }}">Seguimientos</a>
    <span class="sep">/</span>
    Seguimiento #{{ $followup->id }}
@endsection

@section('page-title', 'Detalle del seguimiento')

@section('page-actions')
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.adoption-requests.show', $followup->adoptionRequest) }}"
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver a la solicitud
        </a>
        <form method="POST"
              action="{{ route('admin.followups.destroy', $followup) }}"
              onsubmit="return confirm('¿Eliminar este seguimiento? Esta acción no se puede deshacer.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-trash me-1"></i> Eliminar
            </button>
        </form>
    </div>
@endsection

@section('content')

{{-- Alerta crítica --}}
@if ($followup->is_critical)
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0"></i>
        <div>
            <strong>Alerta crítica:</strong>
            Este seguimiento presenta condiciones que requieren atención inmediata.
        </div>
    </div>
@endif

{{-- Contexto de la adopción --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
         style="border-radius: 8px 8px 0 0;">
        <i class="bi bi-info-circle me-2 spyc-text-naranja"></i> Contexto de la adopción
    </div>
    <div class="card-body px-4 pb-4">
        @php
            $adoptionRequest = $followup->adoptionRequest;
            $animal          = $adoptionRequest->animal;
            $primary         = $animal->photos->firstWhere('is_primary', true) ?? $animal->photos->first();
        @endphp
        <div class="row g-4 align-items-start">
            <div class="col-12 col-md-5">
                <div class="d-flex align-items-center gap-3">
                    @if ($primary)
                        <img src="{{ asset('storage/' . $primary->path) }}"
                             class="rounded"
                             style="width: 72px; height: 72px; object-fit: cover;"
                             alt="{{ $animal->name }}">
                    @else
                        <div class="rounded d-flex align-items-center justify-content-center"
                             style="width: 72px; height: 72px; background: #faf6f2; color: #c5bcaf;">
                            <i class="bi bi-image fs-4"></i>
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('admin.animals.show', $animal) }}"
                           class="fw-bold text-decoration-none d-block">
                            {{ $animal->name }}
                        </a>
                        <div class="text-muted small">
                            {{ $animal->species?->label() }}{{ $animal->breed ? ' · ' . $animal->breed : '' }}
                        </div>
                        <span class="badge" style="background: #FCEAE0; color: #b9411a; font-size: .72rem;">
                            Adoptado
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <dl class="row mb-0 small">
                    <dt class="col-sm-5 text-muted fw-normal py-1">Adoptante</dt>
                    <dd class="col-sm-7 fw-semibold py-1">
                        @if ($adoptionRequest->user)
                            <a href="{{ route('admin.users.show', $adoptionRequest->user) }}"
                               class="text-decoration-none">
                                {{ $adoptionRequest->user->name }}
                            </a>
                        @else
                            —
                        @endif
                    </dd>

                    <dt class="col-sm-5 text-muted fw-normal py-1">Correo</dt>
                    <dd class="col-sm-7 py-1">{{ $adoptionRequest->user?->email ?? '—' }}</dd>

                    <dt class="col-sm-5 text-muted fw-normal py-1">Teléfono</dt>
                    <dd class="col-sm-7 py-1">{{ $adoptionRequest->user?->phone ?: '—' }}</dd>

                    <dt class="col-sm-5 text-muted fw-normal py-1">Código de adopción</dt>
                    <dd class="col-sm-7 py-1">
                        <a href="{{ route('admin.adoption-requests.show', $adoptionRequest) }}"
                           class="text-decoration-none font-monospace small">
                            {{ $adoptionRequest->tracking_code }}
                        </a>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

{{-- Datos de la visita --}}
<div class="row g-3 mb-4">

    {{-- Fecha y evaluación --}}
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 8px;">
            <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
                 style="border-radius: 8px 8px 0 0;">
                <i class="bi bi-calendar3 me-2 spyc-text-naranja"></i> Datos de la visita
            </div>
            <div class="card-body px-4 pb-4">
                <dl class="row mb-0 small">
                    <dt class="col-sm-5 text-muted fw-normal py-2">Fecha de visita</dt>
                    <dd class="col-sm-7 fw-semibold py-2">
                        {{ $followup->visit_date?->format('d/m/Y') }}
                    </dd>

                    <dt class="col-sm-5 text-muted fw-normal py-2">Registrado</dt>
                    <dd class="col-sm-7 py-2 text-muted">
                        {{ $followup->created_at?->format('d/m/Y H:i') }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    {{-- Evaluación --}}
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 8px;">
            <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
                 style="border-radius: 8px 8px 0 0;">
                <i class="bi bi-clipboard-check me-2 spyc-text-naranja"></i> Evaluación
            </div>
            <div class="card-body px-4 pb-4">
                <dl class="row mb-0 small">
                    <dt class="col-sm-5 text-muted fw-normal py-2">Estado del animal</dt>
                    <dd class="col-sm-7 py-2">
                        <span class="badge {{ $followup->animal_condition_badge_class }}">
                            {{ $followup->animal_condition_label }}
                        </span>
                        @if ($followup->animal_condition?->value === 'poor')
                            <i class="bi bi-exclamation-triangle-fill text-danger ms-1"
                               title="Condición crítica"></i>
                        @endif
                    </dd>

                    <dt class="col-sm-5 text-muted fw-normal py-2">Condición del hogar</dt>
                    <dd class="col-sm-7 py-2">
                        <span class="badge {{ $followup->home_condition_badge_class }}">
                            {{ $followup->home_condition_label }}
                        </span>
                        @if ($followup->home_condition?->value === 'inadequate')
                            <i class="bi bi-exclamation-triangle-fill text-danger ms-1"
                               title="Condición crítica"></i>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

{{-- Observaciones --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
         style="border-radius: 8px 8px 0 0;">
        <i class="bi bi-pencil-square me-2 spyc-text-naranja"></i> Observaciones
    </div>
    <div class="card-body px-4 pb-4">
        <p class="mb-0 small" style="white-space: pre-line;">{{ $followup->observations }}</p>
    </div>
</div>

{{-- Galería de fotos --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
         style="border-radius: 8px 8px 0 0;">
        <i class="bi bi-images me-2 spyc-text-naranja"></i> Fotografías de evidencia
    </div>
    <div class="card-body px-4 pb-4">
        @if ($followup->photos->count() > 0)
            <div class="row g-3">
                @foreach ($followup->photos as $photo)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ asset('storage/' . $photo->path) }}"
                           target="_blank" rel="noopener"
                           title="Ver en tamaño completo">
                            <img src="{{ asset('storage/' . $photo->path) }}"
                                 class="img-thumbnail w-100"
                                 style="height: 120px; object-fit: cover;"
                                 alt="Foto del seguimiento">
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted small mb-0">
                <i class="bi bi-image me-1"></i> No se adjuntaron fotografías en este seguimiento.
            </p>
        @endif
    </div>
</div>

{{-- Botón para nuevo seguimiento de la misma adopción --}}
<div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.followups.create', $followup->adoptionRequest) }}"
       class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Registrar nuevo seguimiento
    </a>
    <a href="{{ route('admin.followups.index') }}"
       class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-list-ul me-1"></i> Ver todos los seguimientos
    </a>
</div>

@endsection
