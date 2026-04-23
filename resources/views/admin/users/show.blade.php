@extends('layouts.admin')

@section('title', $user->name)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.users.index') }}">Usuarios</a>
    <span class="sep">/</span>
    {{ $user->name }}
@endsection

@section('page-title', $user->name)

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Editar
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
    </div>
@endsection

@section('content')

<div class="row g-4">

    {{-- Datos del usuario --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 8px;">
            <div class="card-header bg-white border-0 fw-semibold pt-4 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                <i class="bi bi-person-circle me-2 spyc-text-naranja"></i> Información del usuario
            </div>
            <div class="card-body px-4 pb-4">
                <dl class="row mb-0" style="row-gap: 12px;">
                    <dt class="col-sm-4 text-muted small">Nombre completo</dt>
                    <dd class="col-sm-8 fw-semibold mb-0">{{ $user->name }}</dd>

                    <dt class="col-sm-4 text-muted small">Correo electrónico</dt>
                    <dd class="col-sm-8 mb-0">{{ $user->email }}</dd>

                    <dt class="col-sm-4 text-muted small">Teléfono</dt>
                    <dd class="col-sm-8 mb-0">{{ $user->phone ?? '—' }}</dd>

                    <dt class="col-sm-4 text-muted small">Dirección</dt>
                    <dd class="col-sm-8 mb-0">{{ $user->address ?? '—' }}</dd>

                    <dt class="col-sm-4 text-muted small">Rol</dt>
                    <dd class="col-sm-8 mb-0">
                        @php $role = $user->getRoleNames()->first() @endphp
                        @if ($role === 'admin')
                            <span class="badge bg-danger">Administrador</span>
                        @elseif ($role === 'collaborator')
                            <span class="badge bg-info">Colaborador</span>
                        @elseif ($role === 'adopter')
                            <span class="badge bg-success">Adoptante</span>
                        @elseif ($role === 'surrenderer')
                            <span class="badge bg-warning text-dark">Cedente</span>
                        @else
                            <span class="badge bg-secondary">Sin rol</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4 text-muted small">Estado</dt>
                    <dd class="col-sm-8 mb-0">
                        @if ($user->is_active)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4 text-muted small">Miembro desde</dt>
                    <dd class="col-sm-8 mb-0">{{ $user->created_at->format('d/m/Y') }}</dd>
                </dl>
            </div>
        </div>
    </div>

    {{-- Actividad --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm" style="border-radius: 8px;">
            <div class="card-header bg-white border-0 fw-semibold pt-4 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                <i class="bi bi-activity me-2 spyc-text-naranja"></i> Actividad
            </div>
            <div class="card-body px-4 pb-4">
                @if ($role === 'adopter')
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span class="text-muted small">Solicitudes de adopción</span>
                        <span class="badge bg-primary rounded-pill">{{ $user->adoption_requests_count }}</span>
                    </div>
                @elseif ($role === 'surrenderer')
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span class="text-muted small">Solicitudes de cesión</span>
                        <span class="badge bg-primary rounded-pill">{{ $user->cession_requests_count }}</span>
                    </div>
                @else
                    <p class="text-muted small mb-0 py-2">
                        <i class="bi bi-shield-check me-1 spyc-text-naranja"></i>
                        Usuario del equipo del albergue.
                    </p>
                @endif
            </div>
        </div>
    </div>

</div>

{{-- Acción de desactivar/activar (separada de los botones principales) --}}
@if (auth()->id() !== $user->id)
    <div class="mt-4 pt-2 border-top">
        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}"
              onsubmit="return confirm('{{ $user->is_active ? '¿Desactivar a ' . addslashes($user->name) . '? Su cuenta quedará inhabilitada.' : '¿Activar la cuenta de ' . addslashes($user->name) . '?' }}')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                <i class="bi {{ $user->is_active ? 'bi-toggle-off' : 'bi-toggle-on' }} me-1"></i>
                {{ $user->is_active ? 'Desactivar cuenta' : 'Activar cuenta' }}
            </button>
        </form>
    </div>
@endif

@endsection
