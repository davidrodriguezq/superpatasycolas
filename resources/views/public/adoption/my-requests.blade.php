@extends('layouts.public')

@section('title', 'Mis solicitudes - Super Patas y Colas')

@section('content')

<section class="spyc-auth-wrap">
    <div class="container" style="max-width: 900px;">

        <div class="mb-4">
            <h1 class="fw-bold mb-1" style="color: #2a2622; font-size: 1.5rem;">
                Mis solicitudes de adopción
            </h1>
            <p class="text-muted mb-0 small">
                Revisa el estado de las solicitudes que has enviado al albergue.
            </p>
        </div>

        @if ($requests->isEmpty())

            <div class="spyc-auth-card is-wide text-center py-5">
                <i class="bi bi-house-heart text-muted d-block mb-3" style="font-size: 3rem; opacity: .5;"></i>
                <h5 class="fw-semibold mb-2" style="color: #2a2622;">Aún no has enviado solicitudes de adopción</h5>
                <p class="text-muted mb-4">
                    Explora nuestro catálogo y encuentra a tu nueva mascota.
                </p>
                <a href="{{ url('/catalogo') }}" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Explorar catálogo
                </a>
            </div>

        @else

            <div class="spyc-auth-card is-wide p-0" style="max-width: 100%;">
                <div class="list-group list-group-flush">
                    @foreach ($requests as $request)
                        @php
                            $animal = $request->animal;
                            $primary = $animal?->photos->firstWhere('is_primary', true) ?? $animal?->photos->first();
                        @endphp
                        <div class="list-group-item p-4 border-0 border-bottom">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    @if ($primary)
                                        <img src="{{ asset('storage/' . $primary->path) }}"
                                             alt="{{ $animal?->name }}"
                                             class="rounded"
                                             style="width: 72px; height: 72px; object-fit: cover;">
                                    @else
                                        <div class="rounded d-flex align-items-center justify-content-center"
                                             style="width: 72px; height: 72px; background: #faf6f2; color: #c5bcaf;">
                                            <i class="bi bi-image fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <div class="fw-bold mb-1" style="color: #2a2622;">
                                        {{ $animal?->name ?? 'Animal no disponible' }}
                                    </div>
                                    <div class="small text-muted mb-1">
                                        Código:
                                        <span class="fw-semibold" style="font-family: ui-monospace, Menlo, monospace;">
                                            {{ $request->tracking_code }}
                                        </span>
                                    </div>
                                    <div class="small text-muted">
                                        Enviada el {{ $request->created_at?->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <span class="badge {{ $request->status_badge_class }} mb-2">
                                        {{ $request->status_label }}
                                    </span>
                                    <br>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#detail-{{ $request->id }}"
                                            aria-expanded="false"
                                            aria-controls="detail-{{ $request->id }}">
                                        <i class="bi bi-chevron-down me-1"></i> Ver detalle
                                    </button>
                                </div>
                            </div>

                            <div class="collapse mt-3" id="detail-{{ $request->id }}">
                                <div class="p-3 rounded" style="background: #FFF5EE;">
                                    <dl class="row small mb-0" style="row-gap: 6px;">
                                        <dt class="col-sm-4 text-muted fw-normal">Tipo de vivienda</dt>
                                        <dd class="col-sm-8 fw-semibold mb-0">
                                            @switch($request->housing_type)
                                                @case('casa_propia')    Casa propia @break
                                                @case('departamento')   Departamento @break
                                                @case('casa_alquilada') Casa alquilada @break
                                                @case('otro')           Otro @break
                                                @default                {{ $request->housing_type }}
                                            @endswitch
                                        </dd>

                                        <dt class="col-sm-4 text-muted fw-normal">Personas en el hogar</dt>
                                        <dd class="col-sm-8 fw-semibold mb-0">{{ $request->household_members }}</dd>

                                        <dt class="col-sm-4 text-muted fw-normal">¿Otras mascotas?</dt>
                                        <dd class="col-sm-8 fw-semibold mb-0">
                                            {{ $request->previous_pets ? 'Sí' : 'No' }}
                                        </dd>

                                        @if ($request->previous_pets && $request->other_pets_description)
                                            <dt class="col-sm-4 text-muted fw-normal">Descripción</dt>
                                            <dd class="col-sm-8 mb-0">{{ $request->other_pets_description }}</dd>
                                        @endif

                                        <dt class="col-sm-4 text-muted fw-normal">Espacio exterior</dt>
                                        <dd class="col-sm-8 fw-semibold mb-0">
                                            {{ $request->has_outdoor_space ? 'Sí' : 'No' }}
                                        </dd>

                                        <dt class="col-sm-4 text-muted fw-normal">Motivación</dt>
                                        <dd class="col-sm-8 mb-0" style="white-space: pre-line;">{{ $request->motivation }}</dd>
                                    </dl>
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
