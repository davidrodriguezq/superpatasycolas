@extends('layouts.public')

@section('title', 'Mi perfil - Super Patas y Colas')

@section('content')

<div class="spyc-auth-wrap py-5">
    <div class="container" style="max-width: 700px;">

        {{-- Encabezado --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color: #2a2622; font-size: 1.45rem;">Mi perfil</h2>
                <p class="mb-0 text-muted small">Gestiona tu información personal</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil me-1"></i> Editar perfil
            </a>
        </div>

        {{-- Datos personales --}}
        <div class="spyc-auth-card is-wide mb-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width: 56px; height: 56px; border-radius: 50%;
                            background: linear-gradient(135deg, var(--spyc-dorado), var(--spyc-naranja));
                            display: flex; align-items: center; justify-content: center;
                            color: #fff; font-weight: 700; font-size: 1.3rem; flex-shrink: 0;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <div class="fw-bold fs-5" style="color: #2a2622;">{{ $user->name }}</div>
                    <div class="text-muted small">{{ $user->email }}</div>
                </div>
            </div>

            <dl class="row mb-0" style="row-gap: 10px;">
                <dt class="col-sm-4 text-muted small">Tipo de cuenta</dt>
                <dd class="col-sm-8 mb-0">
                    @php $role = $user->getRoleNames()->first() @endphp
                    @if ($role === 'admin')
                        <span class="badge bg-danger">Administrador</span>
                    @elseif ($role === 'collaborator')
                        <span class="badge bg-info">Colaborador</span>
                    @elseif ($role === 'adopter')
                        <span class="badge bg-success">Adoptante</span>
                    @elseif ($role === 'surrenderer')
                        <span class="badge bg-success">Adoptante</span>
                    @endif
                </dd>

                <dt class="col-sm-4 text-muted small">Teléfono</dt>
                <dd class="col-sm-8 mb-0">{{ $user->phone ?: '—' }}</dd>

                <dt class="col-sm-4 text-muted small">Dirección</dt>
                <dd class="col-sm-8 mb-0">{{ $user->address ?: '—' }}</dd>

                <dt class="col-sm-4 text-muted small">Miembro desde</dt>
                <dd class="col-sm-8 mb-0">{{ $user->created_at->translatedFormat('d \d\e F \d\e Y') }}</dd>
            </dl>
        </div>

        {{-- Actividad --}}
        <div class="spyc-auth-card is-wide">
            <h6 class="spyc-form-section-label mb-3">Mi actividad</h6>

            @if ($role === 'adopter')

                @if ($user->adoptionRequests->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-house-heart text-muted fs-2 d-block mb-2"></i>
                        <p class="text-muted mb-3">Aún no has enviado solicitudes de adopción.</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-search me-1"></i> Explora nuestro catálogo
                        </a>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach ($user->adoptionRequests->take(3) as $request)
                            <div class="list-group-item px-0 py-3 border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-semibold small" style="color: #2a2622;">
                                            {{ $request->animal ? $request->animal->name : 'Animal no disponible' }}
                                        </div>
                                        <div class="text-muted" style="font-size: .8rem;">
                                            Código: <span class="fw-semibold">{{ $request->tracking_code }}</span>
                                            &nbsp;·&nbsp;
                                            {{ $request->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    <span class="badge {{ $request->status_badge_class }}">{{ $request->status_label }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('adoption.my-requests') }}" class="btn btn-sm btn-outline-primary">
                            Ver todas mis solicitudes <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                @endif

            @elseif ($role === 'surrenderer')

                {{-- DESACTIVADO: Módulo de cesión deshabilitado. Usuarios con rol surrenderer se muestran como adoptantes. --}}
                <div class="text-center py-4">
                    <i class="bi bi-house-heart text-muted fs-2 d-block mb-2"></i>
                    <p class="text-muted mb-3">Aún no has enviado solicitudes de adopción.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-search me-1"></i> Explora nuestro catálogo
                    </a>
                </div>

            @else
                <p class="text-muted mb-0 small">
                    <i class="bi bi-shield-check me-1 spyc-text-naranja"></i>
                    Eres parte del equipo del albergue Super Patas y Colas.
                </p>
            @endif

        </div>

    </div>
</div>

@endsection
