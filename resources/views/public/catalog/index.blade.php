@extends('layouts.public')

@section('title', 'Catálogo de mascotas — Super Patas y Colas')
@section('meta-description', 'Conoce a las mascotas disponibles para adopción en Super Patas y Colas. Perros y gatos rescatados esperan un hogar en Lima.')

@section('content')

{{-- Hero pequeño --}}
<section class="spyc-bg-rosa py-4 py-md-5">
    <div class="container text-center">
        <h1 class="fw-bold mb-2" style="color:#2a2622; font-size:clamp(1.4rem,4vw,2rem);">
            Nuestras mascotas disponibles
        </h1>
        <p class="text-muted mb-0">Cada uno de ellos espera una familia. ¿Serás tú?</p>
    </div>
</section>

<section class="py-4">
    <div class="container">

        {{-- Filtros --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('catalog.index') }}" class="row g-2 align-items-end">
                    <div class="col-6 col-sm-4 col-md-auto">
                        <label class="form-label small fw-semibold text-muted mb-1">Especie</label>
                        <select name="species" class="form-select form-select-sm" style="min-width:120px;">
                            <option value="">Todas</option>
                            <option value="dog" {{ request('species') === 'dog' ? 'selected' : '' }}>Perro</option>
                            <option value="cat" {{ request('species') === 'cat' ? 'selected' : '' }}>Gato</option>
                        </select>
                    </div>
                    <div class="col-6 col-sm-4 col-md-auto">
                        <label class="form-label small fw-semibold text-muted mb-1">Sexo</label>
                        <select name="sex" class="form-select form-select-sm" style="min-width:110px;">
                            <option value="">Todos</option>
                            <option value="male"   {{ request('sex') === 'male'   ? 'selected' : '' }}>Macho</option>
                            <option value="female" {{ request('sex') === 'female' ? 'selected' : '' }}>Hembra</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm col-md">
                        <label class="form-label small fw-semibold text-muted mb-1">Buscar</label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control form-control-sm"
                               placeholder="Buscar por nombre o raza...">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-search me-1"></i>Buscar
                        </button>
                    </div>
                    @if(request()->hasAny(['species','sex','search']))
                    <div class="col-auto">
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                            <i class="bi bi-x me-1"></i>Limpiar
                        </a>
                    </div>
                    @endif
                </form>
                <div class="mt-2">
                    <small class="text-muted">
                        Mostrando <strong>{{ $animals->total() }}</strong>
                        {{ $animals->total() === 1 ? 'mascota disponible' : 'mascotas disponibles' }}
                    </small>
                </div>
            </div>
        </div>

        {{-- Grid de animales --}}
        @if($animals->isNotEmpty())
        <div class="row g-3 g-md-4">
            @foreach($animals as $animal)
            @php $photo = $animal->primaryPhoto; @endphp
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100 spyc-catalog-card">
                    @if($photo)
                        <div class="spyc-catalog-img-wrap">
                            <img src="{{ asset('storage/' . $photo->path) }}"
                                 alt="{{ $animal->name }}"
                                 class="spyc-catalog-img">
                        </div>
                    @else
                        <div class="spyc-catalog-img-wrap spyc-catalog-placeholder">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                    @endif
                    <div class="card-body p-3">
                        <h5 class="fw-bold mb-2" style="color:#2a2622; font-size:.97rem;">{{ $animal->name }}</h5>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <span class="badge bg-light text-dark border" style="font-size:.72rem;">
                                <i class="bi bi-heart-pulse me-1 spyc-text-naranja"></i>{{ $animal->species->label() }}
                            </span>
                            @if($animal->sex === 'male')
                                <span class="badge bg-light text-primary border" style="font-size:.72rem;">
                                    <i class="bi bi-gender-male me-1"></i>Macho
                                </span>
                            @else
                                <span class="badge bg-light border" style="font-size:.72rem; color:#d63384;">
                                    <i class="bi bi-gender-female me-1"></i>Hembra
                                </span>
                            @endif
                        </div>
                        @if($animal->breed)
                            <div class="text-muted small mb-1">{{ $animal->breed }}</div>
                        @endif
                        <div class="text-muted small">
                            {{ $animal->age_formatted }}
                            @if($animal->weight)
                                · {{ number_format((float) $animal->weight, 1) }} kg
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                        <a href="{{ route('catalog.show', $animal) }}"
                           class="btn btn-primary btn-sm w-100">
                            Conocer a {{ $animal->name }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        @if($animals->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $animals->withQueryString()->links() }}
        </div>
        @endif

        @else
        {{-- Sin resultados --}}
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm mx-auto" style="max-width:420px; border-radius:12px;">
                <div class="card-body py-5 px-4">
                    <i class="bi bi-emoji-frown d-block mb-3 spyc-text-naranja" style="font-size:3rem; opacity:.6;"></i>
                    <h5 class="fw-bold mb-2" style="color:#2a2622;">No encontramos mascotas</h5>
                    <p class="text-muted mb-4">No hay mascotas disponibles con esos filtros. Intenta con otras opciones.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                        <i class="bi bi-grid me-1"></i>Ver todas las mascotas
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

@endsection

@push('styles')
<style>
.spyc-catalog-card {
    border-radius: 12px !important;
    transition: transform .2s ease, box-shadow .2s ease;
}
.spyc-catalog-card:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 24px rgba(0,0,0,.10) !important;
}
.spyc-catalog-img-wrap {
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    border-radius: 12px 12px 0 0;
    background: #f3ece1;
}
.spyc-catalog-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.spyc-catalog-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c5bcaf;
    font-size: 2.4rem;
}
</style>
@endpush
