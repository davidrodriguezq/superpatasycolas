@extends('layouts.admin')

@section('title', 'Animales')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    Animales
@endsection

@section('page-title', 'Gestión de animales')

@section('page-actions')
    <a href="{{ route('admin.animals.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Registrar animal
    </a>
@endsection

@section('content')

@php
    $hasFilters = request()->hasAny(['species','status','sex','entry_type','search']);
@endphp

{{-- Filtros --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 d-flex align-items-center" style="border-radius: 8px 8px 0 0; padding: 14px 20px;">
        <button class="btn btn-sm btn-outline-secondary" type="button"
                data-bs-toggle="collapse" data-bs-target="#filterCollapse"
                aria-expanded="{{ $hasFilters ? 'true' : 'false' }}">
            <i class="bi bi-funnel me-1"></i> Filtros
        </button>
        @if ($hasFilters)
            <a href="{{ route('admin.animals.index') }}" class="btn btn-sm btn-link text-muted ms-2 p-0">
                <i class="bi bi-x-circle me-1"></i>Limpiar filtros
            </a>
        @endif
    </div>
    <div class="collapse {{ $hasFilters ? 'show' : '' }}" id="filterCollapse">
        <div class="card-body pt-0 pb-3 px-4">
            <form method="GET" action="{{ route('admin.animals.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label small fw-semibold text-muted">Especie</label>
                        <select name="species" class="form-select form-select-sm">
                            <option value="">Todas</option>
                            <option value="dog" {{ request('species') === 'dog' ? 'selected' : '' }}>Perro</option>
                            <option value="cat" {{ request('species') === 'cat' ? 'selected' : '' }}>Gato</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label small fw-semibold text-muted">Estado</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            @foreach (\App\Enums\AnimalStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <label class="form-label small fw-semibold text-muted">Sexo</label>
                        <select name="sex" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="male"   {{ request('sex') === 'male'   ? 'selected' : '' }}>Macho</option>
                            <option value="female" {{ request('sex') === 'female' ? 'selected' : '' }}>Hembra</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <label class="form-label small fw-semibold text-muted">Tipo de ingreso</label>
                        <select name="entry_type" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="rescue"  {{ request('entry_type') === 'rescue'  ? 'selected' : '' }}>Rescate</option>
                            <option value="cession" {{ request('entry_type') === 'cession' ? 'selected' : '' }}>Cesión</option>
                        </select>
                    </div>
                    <div class="col-sm-8 col-md-12 col-lg-10">
                        <label class="form-label small fw-semibold text-muted">Buscar</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="Nombre o raza..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-sm-4 col-md-12 col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary flex-grow-1">Buscar</button>
                        <a href="{{ route('admin.animals.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Grid de animales --}}
@if ($animals->count() > 0)
    <div class="row g-3">
        @foreach ($animals as $animal)
            @php $primary = $animal->primaryPhoto; @endphp
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; overflow: hidden;">
                    @if ($primary)
                        <img src="{{ asset('storage/' . $primary->path) }}"
                             alt="Foto de {{ $animal->name }}"
                             class="card-img-top"
                             style="height: 180px; object-fit: cover;"
                             onerror="this.onerror=null;this.parentElement.querySelector('.card-img-placeholder')?.classList.remove('d-none');this.classList.add('d-none');">
                        <div class="card-img-placeholder d-none d-flex align-items-center justify-content-center"
                             style="height: 180px; background: #faf6f2; color: #c5bcaf;">
                            <i class="bi bi-heart-pulse" style="font-size: 2.4rem;"></i>
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center"
                             style="height: 180px; background: #faf6f2; color: #c5bcaf;">
                            <i class="bi bi-heart-pulse" style="font-size: 2.4rem;"></i>
                        </div>
                    @endif

                    <div class="card-body pb-2">
                        <h6 class="fw-bold mb-1">{{ $animal->name }}</h6>
                        <p class="text-muted small mb-2">
                            {{ $animal->species->label() }}{{ $animal->breed ? ' · '.$animal->breed : '' }}
                        </p>

                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @include('admin.animals._status_badge', ['status' => $animal->status])
                            @if ($animal->sex === 'male')
                                <span class="badge bg-primary-subtle text-primary" style="background:#e7f1ff !important;color:#1a66c7 !important;">
                                    <i class="bi bi-gender-male"></i> Macho
                                </span>
                            @else
                                <span class="badge" style="background:#fde7f1;color:#c73f7a;">
                                    <i class="bi bi-gender-female"></i> Hembra
                                </span>
                            @endif
                        </div>

                        <p class="small text-muted mb-0">
                            <i class="bi bi-calendar3 me-1"></i>{{ $animal->age_formatted }}
                            @if ($animal->weight)
                                <span class="mx-1">·</span>
                                <i class="bi bi-speedometer me-1"></i>{{ number_format((float) $animal->weight, 1) }} kg
                            @endif
                        </p>
                    </div>

                    <div class="card-footer bg-white border-0 pt-0 pb-3 d-flex gap-2">
                        <a href="{{ route('admin.animals.show', $animal) }}"
                           class="btn btn-sm btn-outline-primary flex-grow-1">
                            <i class="bi bi-eye me-1"></i> Ver
                        </a>
                        <a href="{{ route('admin.animals.edit', $animal) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($animals->hasPages())
        <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <p class="text-muted small mb-0">
                Mostrando {{ $animals->firstItem() }}–{{ $animals->lastItem() }} de {{ $animals->total() }} animales
            </p>
            {{ $animals->withQueryString()->links() }}
        </div>
    @endif
@else
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body text-center py-5">
            <i class="bi bi-heart-pulse fs-1 opacity-25 d-block mb-2"></i>
            <p class="text-muted mb-3">No se encontraron animales con los filtros aplicados.</p>
            @if ($hasFilters)
                <a href="{{ route('admin.animals.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle me-1"></i> Limpiar filtros
                </a>
            @else
                <a href="{{ route('admin.animals.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Registrar primer animal
                </a>
            @endif
        </div>
    </div>
@endif

@endsection
