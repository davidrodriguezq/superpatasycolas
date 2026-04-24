@extends('layouts.admin')

@section('title', 'Detalle de cesión')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.cession-requests.index') }}">Solicitudes de cesión</a>
    <span class="sep">/</span>
    Detalle
@endsection

@section('page-title', 'Detalle de solicitud de cesión')

@section('page-actions')
    <a href="{{ route('admin.cession-requests.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Volver al listado
    </a>
@endsection

@section('content')

<div class="row g-4">

    {{-- Columna izquierda: datos del cedente + solicitud --}}
    <div class="col-12 col-lg-5">

        {{-- Card: datos del cedente --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <h6 class="fw-bold mb-0" style="color: #2a2622;">
                    <i class="bi bi-person-circle me-2 spyc-text-naranja"></i>Cedente
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                @if ($cessionRequest->user)
                    <dl class="row small mb-0" style="row-gap: 8px;">
                        <dt class="col-4 text-muted fw-normal">Nombre</dt>
                        <dd class="col-8 mb-0 fw-semibold">{{ $cessionRequest->user->name }}</dd>

                        <dt class="col-4 text-muted fw-normal">Correo</dt>
                        <dd class="col-8 mb-0">{{ $cessionRequest->user->email }}</dd>

                        @if ($cessionRequest->user->phone)
                            <dt class="col-4 text-muted fw-normal">Teléfono</dt>
                            <dd class="col-8 mb-0">{{ $cessionRequest->user->phone }}</dd>
                        @endif

                        @if ($cessionRequest->user->address)
                            <dt class="col-4 text-muted fw-normal">Dirección</dt>
                            <dd class="col-8 mb-0">{{ $cessionRequest->user->address }}</dd>
                        @endif
                    </dl>
                @else
                    <p class="text-muted small mb-0">Sin usuario asociado.</p>
                @endif
            </div>
        </div>

        {{-- Card: datos de la solicitud --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <h6 class="fw-bold mb-0" style="color: #2a2622;">
                    <i class="bi bi-file-earmark-text me-2 spyc-text-naranja"></i>Datos de la solicitud
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <dl class="row small mb-0" style="row-gap: 8px;">
                    <dt class="col-5 text-muted fw-normal">Estado</dt>
                    <dd class="col-7 mb-0">
                        <span class="badge {{ $cessionRequest->status_badge_class }}">
                            {{ $cessionRequest->status_label }}
                        </span>
                    </dd>

                    <dt class="col-5 text-muted fw-normal">Urgencia</dt>
                    <dd class="col-7 mb-0">
                        @if ($cessionRequest->urgency === 'urgent')
                            <span class="badge bg-danger">Urgente</span>
                        @elseif ($cessionRequest->urgency === 'normal')
                            <span class="badge bg-info">Normal</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </dd>

                    <dt class="col-5 text-muted fw-normal">Fecha solicitud</dt>
                    <dd class="col-7 mb-0">{{ $cessionRequest->created_at->format('d/m/Y H:i') }}</dd>

                    @if ($cessionRequest->status === \App\Enums\CessionRequestStatus::Accepted)
                        <dt class="col-5 text-muted fw-normal">Fecha aceptación</dt>
                        <dd class="col-7 mb-0">{{ $cessionRequest->updated_at->format('d/m/Y H:i') }}</dd>
                    @elseif ($cessionRequest->status === \App\Enums\CessionRequestStatus::Rejected)
                        <dt class="col-5 text-muted fw-normal">Fecha rechazo</dt>
                        <dd class="col-7 mb-0">{{ $cessionRequest->updated_at->format('d/m/Y H:i') }}</dd>
                    @endif
                </dl>

                @if ($cessionRequest->reason)
                    <hr style="border-color: #f3ece1;">
                    <p class="text-muted small fw-semibold mb-1 text-uppercase" style="font-size: .72rem; letter-spacing: .08em;">Motivo</p>
                    <p class="small mb-0" style="white-space: pre-line;">{{ $cessionRequest->reason }}</p>
                @endif
            </div>
        </div>

    </div>

    {{-- Columna derecha: datos del animal + acciones --}}
    <div class="col-12 col-lg-7">

        {{-- Card: datos del animal propuesto --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <h6 class="fw-bold mb-0" style="color: #2a2622;">
                    <i class="bi bi-heart-pulse me-2 spyc-text-naranja"></i>Animal a ceder
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                @if ($cessionRequest->animal_name)
                    <dl class="row small mb-0" style="row-gap: 8px;">
                        <dt class="col-5 text-muted fw-normal">Nombre</dt>
                        <dd class="col-7 mb-0 fw-semibold">{{ $cessionRequest->animal_name }}</dd>

                        @if ($cessionRequest->animal_species)
                            <dt class="col-5 text-muted fw-normal">Especie</dt>
                            <dd class="col-7 mb-0">{{ $cessionRequest->animal_species === 'dog' ? 'Perro' : 'Gato' }}</dd>
                        @endif

                        @if ($cessionRequest->animal_breed)
                            <dt class="col-5 text-muted fw-normal">Raza</dt>
                            <dd class="col-7 mb-0">{{ $cessionRequest->animal_breed }}</dd>
                        @endif

                        @if ($cessionRequest->animal_sex)
                            <dt class="col-5 text-muted fw-normal">Sexo</dt>
                            <dd class="col-7 mb-0">{{ $cessionRequest->animal_sex === 'male' ? 'Macho' : 'Hembra' }}</dd>
                        @endif

                        @if ($cessionRequest->animal_approximate_age)
                            <dt class="col-5 text-muted fw-normal">Edad aproximada</dt>
                            <dd class="col-7 mb-0">{{ $cessionRequest->animal_approximate_age }}</dd>
                        @endif

                        @if ($cessionRequest->animal_weight)
                            <dt class="col-5 text-muted fw-normal">Peso</dt>
                            <dd class="col-7 mb-0">{{ number_format((float) $cessionRequest->animal_weight, 1) }} kg</dd>
                        @endif

                        @if ($cessionRequest->animal_condition)
                            <dt class="col-5 text-muted fw-normal">Estado</dt>
                            <dd class="col-7 mb-0">
                                @php
                                    $condClass = match($cessionRequest->animal_condition->value) {
                                        'good' => 'bg-success',
                                        'fair' => 'bg-warning text-dark',
                                        'poor' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $condClass }}">{{ $cessionRequest->animal_condition->label() }}</span>
                            </dd>
                        @endif
                    </dl>

                    @if ($cessionRequest->animal_description)
                        <hr style="border-color: #f3ece1;">
                        <p class="text-muted small fw-semibold mb-1 text-uppercase" style="font-size: .72rem; letter-spacing: .08em;">Descripción</p>
                        <p class="small mb-0" style="white-space: pre-line;">{{ $cessionRequest->animal_description }}</p>
                    @endif
                @else
                    <p class="text-muted small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Esta solicitud no tiene datos del animal (registro previo al formulario).
                    </p>
                @endif
            </div>
        </div>

        {{-- Acciones según estado --}}
        @if ($cessionRequest->status === \App\Enums\CessionRequestStatus::Pending)

            @if ($cessionRequest->animal_name)
                {{-- Formulario de aceptación --}}
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; border: 2px solid #e8f4ea !important;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #2a2622;">
                            <i class="bi bi-check-circle me-2 text-success"></i>Aceptar cesión
                        </h6>
                        <form method="POST"
                              action="{{ route('admin.cession-requests.accept', $cessionRequest) }}"
                              onsubmit="return confirm('¿Aceptar esta cesión? Se creará un nuevo registro de animal en el sistema.');">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="initial_status" class="form-label small fw-semibold">
                                    Estado inicial del animal <span class="text-danger">*</span>
                                </label>
                                <select name="initial_status"
                                        id="initial_status"
                                        class="form-select @error('initial_status') is-invalid @enderror"
                                        required>
                                    <option value="available" {{ old('initial_status', 'available') === 'available' ? 'selected' : '' }}>
                                        Disponible — listo para adopción
                                    </option>
                                    <option value="quarantine" {{ old('initial_status') === 'quarantine' ? 'selected' : '' }}>
                                        En cuarentena — requiere evaluación veterinaria
                                    </option>
                                </select>
                                @error('initial_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i> Aceptar cesión y registrar animal
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Esta solicitud no tiene datos del animal y no puede ser aceptada automáticamente.
                    Contacta al cedente para obtener la información.
                </div>
            @endif

            {{-- Botón rechazar --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border: 2px solid #fce8e8 !important;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: #2a2622;">
                        <i class="bi bi-x-circle me-2 text-danger"></i>Rechazar cesión
                    </h6>
                    <form method="POST"
                          action="{{ route('admin.cession-requests.reject', $cessionRequest) }}"
                          onsubmit="return confirm('¿Rechazar esta solicitud de cesión? Esta acción no puede deshacerse.');">
                        @csrf
                        @method('PATCH')
                        <p class="text-muted small mb-3">
                            Al rechazar, la solicitud quedará marcada como rechazada y no se creará
                            ningún registro de animal en el sistema.
                        </p>
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-x-circle me-1"></i> Rechazar cesión
                        </button>
                    </form>
                </div>
            </div>

        @elseif ($cessionRequest->status === \App\Enums\CessionRequestStatus::Accepted)

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-check-circle-fill text-success d-block mb-2" style="font-size: 2.2rem;"></i>
                    <h6 class="fw-bold mb-2">Cesión aceptada</h6>
                    <p class="text-muted small mb-3">
                        El animal fue registrado exitosamente en el sistema del albergue.
                    </p>
                    @if ($cessionRequest->animal)
                        <a href="{{ route('admin.animals.show', $cessionRequest->animal) }}"
                           class="btn btn-primary">
                            <i class="bi bi-heart-pulse me-1"></i> Ver ficha del animal
                        </a>
                    @endif
                </div>
            </div>

        @elseif ($cessionRequest->status === \App\Enums\CessionRequestStatus::Rejected)

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-x-circle-fill text-danger d-block mb-2" style="font-size: 2.2rem;"></i>
                    <h6 class="fw-bold mb-2">Cesión rechazada</h6>
                    <p class="text-muted small mb-0">
                        Rechazada el {{ $cessionRequest->updated_at->format('d/m/Y \a \l\a\s H:i') }}.
                        No se creó ningún registro de animal.
                    </p>
                </div>
            </div>

        @endif

    </div>
</div>

@endsection
