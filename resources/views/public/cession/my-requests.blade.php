@extends('layouts.public')

@section('title', 'Mis cesiones - Super Patas y Colas')

@section('content')

<section class="spyc-auth-wrap">
    <div class="container" style="max-width: 900px;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1" style="color: #2a2622; font-size: 1.45rem;">
                    Mis solicitudes de cesión
                </h1>
                <p class="mb-0 text-muted small">Historial de animales que has solicitado entregar al albergue</p>
            </div>
            <a href="{{ route('cession.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Nueva cesión
            </a>
        </div>

        @if ($cessionRequests->isEmpty())
            <div class="spyc-auth-card text-center py-5">
                <i class="bi bi-box-arrow-in-right text-muted d-block mb-3" style="font-size: 2.5rem; opacity: .3;"></i>
                <p class="text-muted mb-3">No has registrado solicitudes de cesión.</p>
                <a href="{{ route('cession.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Registrar cesión
                </a>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach ($cessionRequests as $cession)
                    @php
                        $collapseId = 'collapse-cession-' . $cession->id;
                        $urgencyBadge = $cession->urgency === 'urgent' ? 'bg-danger' : 'bg-info';
                        $urgencyLabel = $cession->urgency === 'urgent' ? 'Urgente' : 'Normal';
                    @endphp
                    <div class="spyc-auth-card p-0 overflow-hidden" style="max-width: 100%;">
                        <div class="d-flex align-items-center justify-content-between p-4 flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 42px; height: 42px; border-radius: 10px;
                                            background: var(--spyc-rosa); flex-shrink: 0;
                                            display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-box-arrow-in-right spyc-text-naranja"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="color: #2a2622;">
                                        {{ $cession->animal_name ?? 'Solicitud de cesión' }}
                                    </div>
                                    <div class="text-muted small">
                                        @if ($cession->animal_species)
                                            {{ $cession->animal_species === 'dog' ? 'Perro' : 'Gato' }}
                                            @if ($cession->animal_breed) · {{ $cession->animal_breed }} @endif
                                            &nbsp;·&nbsp;
                                        @endif
                                        {{ $cession->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if ($cession->urgency)
                                    <span class="badge {{ $urgencyBadge }}">{{ $urgencyLabel }}</span>
                                @endif
                                <span class="badge {{ $cession->status_badge_class }}">{{ $cession->status_label }}</span>
                                <button class="btn btn-sm btn-outline-secondary"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $collapseId }}"
                                        aria-expanded="false">
                                    Ver detalle
                                </button>
                            </div>
                        </div>

                        <div class="collapse" id="{{ $collapseId }}">
                            <div class="border-top px-4 py-3" style="background: var(--spyc-rosa-soft);">
                                <div class="row g-3">
                                    @if ($cession->animal_name)
                                        <div class="col-12">
                                            <p class="fw-semibold small text-muted mb-2 text-uppercase"
                                               style="font-size: .72rem; letter-spacing: .08em;">
                                                Datos del animal
                                            </p>
                                            <dl class="row small mb-0" style="row-gap: 4px;">
                                                <dt class="col-5 col-sm-3 text-muted fw-normal">Nombre</dt>
                                                <dd class="col-7 col-sm-9 mb-0 fw-semibold">{{ $cession->animal_name }}</dd>

                                                @if ($cession->animal_species)
                                                    <dt class="col-5 col-sm-3 text-muted fw-normal">Especie</dt>
                                                    <dd class="col-7 col-sm-9 mb-0">{{ $cession->animal_species === 'dog' ? 'Perro' : 'Gato' }}</dd>
                                                @endif

                                                @if ($cession->animal_breed)
                                                    <dt class="col-5 col-sm-3 text-muted fw-normal">Raza</dt>
                                                    <dd class="col-7 col-sm-9 mb-0">{{ $cession->animal_breed }}</dd>
                                                @endif

                                                @if ($cession->animal_sex)
                                                    <dt class="col-5 col-sm-3 text-muted fw-normal">Sexo</dt>
                                                    <dd class="col-7 col-sm-9 mb-0">{{ $cession->animal_sex === 'male' ? 'Macho' : 'Hembra' }}</dd>
                                                @endif

                                                @if ($cession->animal_approximate_age)
                                                    <dt class="col-5 col-sm-3 text-muted fw-normal">Edad</dt>
                                                    <dd class="col-7 col-sm-9 mb-0">{{ $cession->animal_approximate_age }}</dd>
                                                @endif

                                                @if ($cession->animal_condition)
                                                    <dt class="col-5 col-sm-3 text-muted fw-normal">Estado</dt>
                                                    <dd class="col-7 col-sm-9 mb-0">{{ $cession->animal_condition->label() }}</dd>
                                                @endif
                                            </dl>
                                        </div>
                                    @endif

                                    @if ($cession->reason)
                                        <div class="col-12">
                                            <p class="fw-semibold small text-muted mb-1 text-uppercase"
                                               style="font-size: .72rem; letter-spacing: .08em;">
                                                Motivo de la cesión
                                            </p>
                                            <p class="small mb-0" style="white-space: pre-line;">{{ $cession->reason }}</p>
                                        </div>
                                    @endif

                                    @if ($cession->status === \App\Enums\CessionRequestStatus::Accepted && $cession->animal)
                                        <div class="col-12">
                                            <div class="alert alert-success py-2 px-3 mb-0 small">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Tu cesión fue aceptada. El animal
                                                <strong>{{ $cession->animal->name }}</strong>
                                                ha sido registrado en el sistema del albergue.
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

@endsection
