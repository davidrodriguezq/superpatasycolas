@extends('layouts.admin')

@section('title', 'Solicitudes de adopción')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    Solicitudes de adopción
@endsection

@section('page-title', 'Solicitudes de adopción')

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
            <a href="{{ route('admin.adoption-requests.index') }}" class="btn btn-sm btn-link text-muted ms-2 p-0">
                <i class="bi bi-x-circle me-1"></i>Limpiar filtros
            </a>
        @endif
    </div>
    <div class="collapse {{ request()->hasAny(['status','search']) ? 'show' : '' }}" id="filterCollapse">
        <div class="card-body pt-0 pb-3 px-4">
            <form method="GET" action="{{ route('admin.adoption-requests.index') }}" data-auto-search>
                <div class="row g-3 align-items-end">
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label small fw-semibold text-muted">Estado</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pendiente</option>
                            <option value="approved"  {{ request('status') === 'approved'  ? 'selected' : '' }}>Aprobada</option>
                            <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Rechazada</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>
                    <div class="col-sm-8 col-md-5">
                        <label class="form-label small fw-semibold text-muted">Buscar</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="Escribe código de seguimiento o nombre..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-sm-4 col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary flex-grow-1">Buscar</button>
                        <a href="{{ route('admin.adoption-requests.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
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
                    <th>Código</th>
                    <th>Solicitante</th>
                    <th>Animal</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($adoptionRequests as $req)
                    <tr>
                        <td>
                            <span class="small fw-semibold" style="font-family: ui-monospace, SFMono-Regular, Menlo, monospace;">
                                {{ $req->tracking_code }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $req->user?->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $req->user?->email ?? '—' }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $req->animal?->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $req->animal?->species?->label() ?? '' }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $req->status_badge_class }}">
                                {{ $req->status_label }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $req->created_at?->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-1 flex-nowrap">
                                <a href="{{ route('admin.adoption-requests.show', $req) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if ($req->status === \App\Enums\AdoptionRequestStatus::Pending)
                                    <form method="POST"
                                          action="{{ route('admin.adoption-requests.approve', $req) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Aprobar esta solicitud? El animal quedará marcado como adoptado.');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-success"
                                                title="Aprobar">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                    <form method="POST"
                                          action="{{ route('admin.adoption-requests.reject', $req) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Rechazar esta solicitud?');">
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
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-house-heart fs-2 d-block mb-2 opacity-25"></i>
                            No se encontraron solicitudes con los filtros aplicados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
@if ($adoptionRequests->hasPages())
    <div class="mt-4 d-flex justify-content-between align-items-center">
        <p class="text-muted small mb-0">
            Mostrando {{ $adoptionRequests->firstItem() }}–{{ $adoptionRequests->lastItem() }} de {{ $adoptionRequests->total() }} solicitudes
        </p>
        {{ $adoptionRequests->links() }}
    </div>
@endif

@endsection
