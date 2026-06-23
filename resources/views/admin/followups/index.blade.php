@extends('layouts.admin')

@section('title', 'Seguimientos post-adopción - Admin')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    Seguimientos post-adopción
@endsection

@section('page-title', 'Seguimientos post-adopción')

@section('page-actions')
    @if (request()->filled('critical'))
        <span class="badge bg-danger fs-6 px-3 py-2">
            <i class="bi bi-exclamation-triangle me-1"></i> Filtrando: Alertas críticas
        </span>
    @endif
@endsection

@section('content')

{{-- Filtros --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3 px-4"
         style="border-radius: 8px; cursor: pointer;"
         data-bs-toggle="collapse" data-bs-target="#filterPanel" aria-expanded="false">
        <span class="fw-semibold small">
            <i class="bi bi-funnel me-2 spyc-text-naranja"></i> Filtros
            @if (request()->hasAny(['animal_condition', 'home_condition', 'search']))
                <span class="badge bg-primary ms-2" style="font-size:.7rem;">Activos</span>
            @endif
        </span>
        <i class="bi bi-chevron-down small text-muted"></i>
    </div>
    <div class="collapse" id="filterPanel">
        <div class="card-body px-4 pb-4 pt-2">
            <form method="GET" action="{{ route('admin.followups.index') }}" class="row g-3" data-auto-search>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Estado del animal</label>
                    <select name="animal_condition" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        @foreach (\App\Enums\AnimalCondition::cases() as $case)
                            <option value="{{ $case->value }}"
                                    {{ request('animal_condition') === $case->value ? 'selected' : '' }}>
                                {{ $case->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Condición del hogar</label>
                    <select name="home_condition" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        @foreach (\App\Enums\HomeCondition::cases() as $case)
                            <option value="{{ $case->value }}"
                                    {{ request('home_condition') === $case->value ? 'selected' : '' }}>
                                {{ $case->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Buscar</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="Escribe nombre del animal o adoptante..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                        <i class="bi bi-search me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.followups.index') }}" class="btn btn-outline-secondary btn-sm"
                       title="Limpiar filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tabla --}}
<div class="admin-table shadow-sm">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Animal</th>
                <th>Adoptante</th>
                <th>Fecha visita</th>
                <th>Estado animal</th>
                <th>Condición hogar</th>
                <th style="width: 80px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($followups as $followup)
                @php
                    $isCritical = $followup->is_critical;
                    $animal     = $followup->adoptionRequest?->animal;
                    $adopter    = $followup->adoptionRequest?->user;
                    $photo      = $animal?->photos->firstWhere('is_primary', true) ?? $animal?->photos->first();
                @endphp
                <tr class="{{ $isCritical ? 'table-danger' : '' }}">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if ($photo)
                                <img src="{{ asset('storage/' . $photo->path) }}"
                                     class="rounded"
                                     style="width: 36px; height: 36px; object-fit: cover;" alt="">
                            @else
                                <div class="rounded d-flex align-items-center justify-content-center"
                                     style="width: 36px; height: 36px; background: #faf6f2; color: #c5bcaf;">
                                    <i class="bi bi-image" style="font-size: .9rem;"></i>
                                </div>
                            @endif
                            <div>
                                @if ($animal)
                                    <a href="{{ route('admin.animals.show', $animal) }}"
                                       class="fw-semibold small text-decoration-none">
                                        {{ $animal->name }}
                                    </a>
                                    @if ($isCritical)
                                        <i class="bi bi-exclamation-triangle-fill text-danger ms-1"
                                           style="font-size: .75rem;" title="Alerta crítica"></i>
                                    @endif
                                    <div class="text-muted" style="font-size: .76rem;">
                                        {{ $animal->species?->label() }}
                                    </div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="small">{{ $adopter?->name ?? '—' }}</td>
                    <td class="small">{{ $followup->visit_date?->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $followup->animal_condition_badge_class }}">
                            {{ $followup->animal_condition_label }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $followup->home_condition_badge_class }}">
                            {{ $followup->home_condition_label }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.followups.show', $followup) }}"
                           class="btn btn-sm btn-outline-secondary" title="Ver detalle">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-clipboard-x d-block mb-2" style="font-size: 2rem;"></i>
                        No se encontraron seguimientos.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($followups->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $followups->links() }}
    </div>
@endif

@endsection
