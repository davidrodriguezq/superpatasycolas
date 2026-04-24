@extends('layouts.admin')

@section('title', 'Solicitudes de cesión')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    Solicitudes de cesión
@endsection

@section('page-title', 'Solicitudes de cesión')

@section('content')

{{-- Filtros --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 d-flex align-items-center" style="border-radius: 8px 8px 0 0; padding: 14px 20px;">
        <button class="btn btn-sm btn-outline-secondary" type="button"
                data-bs-toggle="collapse" data-bs-target="#filterCollapse"
                aria-expanded="{{ request()->hasAny(['status','search']) ? 'true' : 'false' }}">
            <i class="bi bi-funnel me-1"></i> Filtros
        </button>
        @if (request()->hasAny(['status', 'search']))
            <a href="{{ route('admin.cession-requests.index') }}" class="btn btn-sm btn-link text-muted ms-2 p-0">
                <i class="bi bi-x-circle me-1"></i>Limpiar filtros
            </a>
        @endif
    </div>
    <div class="collapse {{ request()->hasAny(['status','search']) ? 'show' : '' }}" id="filterCollapse">
        <div class="card-body pt-0 pb-3 px-4">
            <form method="GET" action="{{ route('admin.cession-requests.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label small fw-semibold text-muted">Estado</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pendiente</option>
                            <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Aceptada</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>
                    <div class="col-sm-8 col-md-5">
                        <label class="form-label small fw-semibold text-muted">Buscar</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="Nombre del cedente o nombre del animal..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-sm-4 col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary flex-grow-1">Buscar</button>
                        <a href="{{ route('admin.cession-requests.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tabla --}}
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Cedente</th>
                    <th>Animal</th>
                    <th>Especie</th>
                    <th>Cond. animal</th>
                    <th>Urgencia</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cessionRequests as $cession)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $cession->user?->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $cession->user?->email ?? '—' }}</div>
                        </td>
                        <td class="fw-semibold">{{ $cession->animal_name ?? '—' }}</td>
                        <td class="small text-muted">
                            @if ($cession->animal_species === 'dog') Perro
                            @elseif ($cession->animal_species === 'cat') Gato
                            @else —
                            @endif
                        </td>
                        <td>
                            @if ($cession->animal_condition)
                                @php
                                    $condClass = match($cession->animal_condition->value) {
                                        'good' => 'bg-success',
                                        'fair' => 'bg-warning text-dark',
                                        'poor' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $condClass }}">{{ $cession->animal_condition->label() }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if ($cession->urgency === 'urgent')
                                <span class="badge bg-danger">Urgente</span>
                            @elseif ($cession->urgency === 'normal')
                                <span class="badge bg-info">Normal</span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $cession->status_badge_class }}">
                                {{ $cession->status_label }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $cession->created_at?->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-1 flex-nowrap">
                                <a href="{{ route('admin.cession-requests.show', $cession) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if ($cession->status === \App\Enums\CessionRequestStatus::Pending)
                                    <form method="POST"
                                          action="{{ route('admin.cession-requests.reject', $cession) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Rechazar esta solicitud de cesión?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Rechazar">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-box-arrow-in-right fs-2 d-block mb-2 opacity-25"></i>
                            No se encontraron solicitudes con los filtros aplicados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
@if ($cessionRequests->hasPages())
    <div class="mt-4 d-flex justify-content-between align-items-center">
        <p class="text-muted small mb-0">
            Mostrando {{ $cessionRequests->firstItem() }}–{{ $cessionRequests->lastItem() }} de {{ $cessionRequests->total() }} solicitudes
        </p>
        {{ $cessionRequests->links() }}
    </div>
@endif

@endsection
