@extends('layouts.admin')

@section('title', 'Solicitud ' . $adoptionRequest->tracking_code)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.adoption-requests.index') }}">Solicitudes de adopción</a>
    <span class="sep">/</span>
    {{ $adoptionRequest->tracking_code }}
@endsection

@section('content')

{{-- Encabezado --}}
<div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-4">
    <div>
        <h3 class="mb-1 fw-bold">Solicitud de adopción</h3>
        <p class="text-muted small mb-0" style="font-family: ui-monospace, SFMono-Regular, Menlo, monospace;">
            Código: {{ $adoptionRequest->tracking_code }}
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.adoption-requests.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
    </div>
</div>

{{-- Estado y metadata --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-body px-4 py-3 d-flex flex-wrap gap-3 align-items-center justify-content-between">
        <div>
            <div class="text-muted small mb-1">Estado de la solicitud</div>
            <span class="badge {{ $adoptionRequest->status_badge_class }} fs-6 px-3 py-2">
                {{ $adoptionRequest->status_label }}
            </span>
        </div>
        <div>
            <div class="text-muted small mb-1">Fecha de solicitud</div>
            <div class="fw-semibold">{{ $adoptionRequest->created_at?->format('d/m/Y H:i') }}</div>
        </div>
        @if ($adoptionRequest->status === \App\Enums\AdoptionRequestStatus::Approved)
            <div>
                <div class="text-muted small mb-1">Fecha de aprobación</div>
                <div class="fw-semibold">
                    {{ optional($adoptionRequest->approved_at ?? $adoptionRequest->updated_at)->format('d/m/Y H:i') }}
                </div>
            </div>
            <div>
                <div class="text-muted small mb-1">Aprobado por</div>
                <div class="fw-semibold">{{ $adoptionRequest->approvedBy?->name ?? '—' }}</div>
            </div>
        @elseif ($adoptionRequest->status === \App\Enums\AdoptionRequestStatus::Rejected)
            <div>
                <div class="text-muted small mb-1">Fecha de rechazo</div>
                <div class="fw-semibold">
                    {{ optional($adoptionRequest->rejected_at ?? $adoptionRequest->updated_at)->format('d/m/Y H:i') }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Solicitante + Animal --}}
<div class="row g-3 mb-4">

    {{-- Solicitante --}}
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 8px;">
            <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                <i class="bi bi-person-circle me-2 spyc-text-naranja"></i> Datos del solicitante
            </div>
            <div class="card-body px-4 pb-4">
                @if ($adoptionRequest->user)
                    <dl class="row mb-0 small">
                        <dt class="col-sm-4 text-muted fw-normal py-1">Nombre</dt>
                        <dd class="col-sm-8 fw-semibold py-1">
                            <a href="{{ route('admin.users.show', $adoptionRequest->user) }}">
                                {{ $adoptionRequest->user->name }}
                            </a>
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal py-1">Correo</dt>
                        <dd class="col-sm-8 fw-semibold py-1">{{ $adoptionRequest->user->email }}</dd>

                        <dt class="col-sm-4 text-muted fw-normal py-1">Teléfono</dt>
                        <dd class="col-sm-8 fw-semibold py-1">{{ $adoptionRequest->user->phone ?: '—' }}</dd>

                        <dt class="col-sm-4 text-muted fw-normal py-1">Dirección</dt>
                        <dd class="col-sm-8 fw-semibold py-1">{{ $adoptionRequest->user->address ?: '—' }}</dd>
                    </dl>
                @else
                    <p class="text-muted small mb-0">Usuario no disponible.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Animal --}}
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 8px;">
            <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                <i class="bi bi-heart-pulse me-2 spyc-text-naranja"></i> Datos del animal
            </div>
            <div class="card-body px-4 pb-4">
                @if ($adoptionRequest->animal)
                    @php
                        $animal = $adoptionRequest->animal;
                        $primary = $animal->photos->firstWhere('is_primary', true) ?? $animal->photos->first();
                    @endphp

                    <div class="d-flex gap-3 align-items-center mb-3">
                        @if ($primary)
                            <img src="{{ asset('storage/' . $primary->path) }}"
                                 alt="{{ $animal->name }}"
                                 class="rounded"
                                 style="width: 72px; height: 72px; object-fit: cover;">
                        @else
                            <div class="rounded d-flex align-items-center justify-content-center"
                                 style="width: 72px; height: 72px; background: #faf6f2; color: #c5bcaf;">
                                <i class="bi bi-image fs-4"></i>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('admin.animals.show', $animal) }}" class="fw-bold text-decoration-none">
                                {{ $animal->name }}
                            </a>
                            <div class="small text-muted">
                                {{ $animal->species->label() }}{{ $animal->breed ? ' · ' . $animal->breed : '' }}
                            </div>
                            @include('admin.animals._status_badge', ['status' => $animal->status])
                        </div>
                    </div>

                    <dl class="row mb-0 small">
                        <dt class="col-sm-5 text-muted fw-normal py-1">Sexo</dt>
                        <dd class="col-sm-7 fw-semibold py-1">{{ $animal->sex === 'male' ? 'Macho' : 'Hembra' }}</dd>

                        <dt class="col-sm-5 text-muted fw-normal py-1">Edad</dt>
                        <dd class="col-sm-7 fw-semibold py-1">{{ $animal->age_formatted }}</dd>
                    </dl>
                @else
                    <p class="text-muted small mb-0">Animal no disponible.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Datos de la solicitud --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
        <i class="bi bi-card-list me-2 spyc-text-naranja"></i> Información de la solicitud
    </div>
    <div class="card-body px-4 pb-4">
        <dl class="row mb-0 small">
            <dt class="col-sm-4 col-lg-3 text-muted fw-normal py-1">Tipo de vivienda</dt>
            <dd class="col-sm-8 col-lg-9 fw-semibold py-1">
                @switch($adoptionRequest->housing_type)
                    @case('casa_propia')    Casa propia @break
                    @case('departamento')   Departamento @break
                    @case('casa_alquilada') Casa alquilada @break
                    @case('otro')           Otro @break
                    @default                {{ $adoptionRequest->housing_type }}
                @endswitch
            </dd>

            <dt class="col-sm-4 col-lg-3 text-muted fw-normal py-1">Personas en el hogar</dt>
            <dd class="col-sm-8 col-lg-9 fw-semibold py-1">{{ $adoptionRequest->household_members }}</dd>

            <dt class="col-sm-4 col-lg-3 text-muted fw-normal py-1">¿Tiene otras mascotas?</dt>
            <dd class="col-sm-8 col-lg-9 fw-semibold py-1">
                {{ $adoptionRequest->previous_pets ? 'Sí' : 'No' }}
            </dd>

            @if ($adoptionRequest->previous_pets && $adoptionRequest->other_pets_description)
                <dt class="col-sm-4 col-lg-3 text-muted fw-normal py-1">Descripción de mascotas</dt>
                <dd class="col-sm-8 col-lg-9 py-1">{{ $adoptionRequest->other_pets_description }}</dd>
            @endif

            <dt class="col-sm-4 col-lg-3 text-muted fw-normal py-1">Espacio al aire libre</dt>
            <dd class="col-sm-8 col-lg-9 fw-semibold py-1">
                {{ $adoptionRequest->has_outdoor_space ? 'Sí' : 'No' }}
            </dd>

            <dt class="col-sm-4 col-lg-3 text-muted fw-normal py-1">Motivación</dt>
            <dd class="col-sm-8 col-lg-9 py-1" style="white-space: pre-line;">{{ $adoptionRequest->motivation }}</dd>
        </dl>
    </div>
</div>

{{-- Botones de acción --}}
@if ($adoptionRequest->status === \App\Enums\AdoptionRequestStatus::Pending)
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
        <div class="card-body px-4 py-4">
            <h6 class="fw-semibold mb-3">
                <i class="bi bi-arrow-left-right me-2 spyc-text-naranja"></i>
                Decisión sobre la solicitud
            </h6>
            <p class="text-muted small mb-3">
                Aprobar marcará al animal como adoptado. Rechazar dejará al animal disponible si no hay otras solicitudes pendientes.
            </p>
            <div class="d-flex gap-2 flex-wrap">
                <form method="POST"
                      action="{{ route('admin.adoption-requests.approve', $adoptionRequest) }}"
                      onsubmit="return confirm('¿Aprobar esta solicitud? El animal quedará marcado como adoptado y las demás solicitudes pendientes serán rechazadas automáticamente.');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Aprobar solicitud
                    </button>
                </form>
                <form method="POST"
                      action="{{ route('admin.adoption-requests.reject', $adoptionRequest) }}"
                      onsubmit="return confirm('¿Rechazar esta solicitud?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i> Rechazar solicitud
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif

@endsection
