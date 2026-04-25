@extends('layouts.public')

@section('title', 'Super Patas y Colas — Albergue de animales en San Martín de Porres')
@section('meta-description', 'Super Patas y Colas es un albergue de animales en San Martín de Porres, Lima. Adopta perros y gatos rescatados. Adopción responsable, gratuita y con seguimiento.')

@section('content')

{{-- ============================================================
     SECCIÓN 1 — Hero
============================================================ --}}
<section class="spyc-hero">
    <div class="container py-5 py-lg-6">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="spyc-hero-title">
                    Dale una segunda oportunidad<br class="d-none d-md-block"> a un amigo
                </h1>
                <p class="spyc-hero-subtitle">
                    En Super Patas y Colas damos hogar temporal a perros y gatos rescatados
                    en San Martín de Porres. Cada adopción responsable cambia dos vidas.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mt-4">
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-search-heart me-2"></i>Ver mascotas disponibles
                    </a>
                    <a href="#contacto" class="btn btn-outline-primary btn-lg px-4">
                        <i class="bi bi-hand-thumbs-up me-2"></i>Quiero ayudar
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SECCIÓN 2 — Estadísticas
============================================================ --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4 justify-content-center text-center">
            <div class="col-6 col-md-4">
                <div class="spyc-stat-card">
                    <i class="bi bi-heart-pulse spyc-stat-icon"></i>
                    <div class="spyc-stat-number">{{ $stats['total'] }}</div>
                    <div class="spyc-stat-label">animales en el albergue</div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="spyc-stat-card">
                    <i class="bi bi-house-heart spyc-stat-icon"></i>
                    <div class="spyc-stat-number">{{ $stats['adoptions'] }}</div>
                    <div class="spyc-stat-label">adopciones realizadas</div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="spyc-stat-card">
                    <i class="bi bi-search-heart spyc-stat-icon"></i>
                    <div class="spyc-stat-number">{{ $stats['available'] }}</div>
                    <div class="spyc-stat-label">mascotas disponibles</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SECCIÓN 3 — Mascotas destacadas
============================================================ --}}
<section class="py-5 spyc-bg-rosa">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1" style="color:#2a2622;">Mascotas que buscan hogar</h2>
            <p class="text-muted">Conoce a algunos de nuestros amigos disponibles para adopción</p>
        </div>

        @if($featuredAnimals->isNotEmpty())
        <div class="row g-4">
            @foreach($featuredAnimals as $animal)
            @php $photo = $animal->primaryPhoto; @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 spyc-animal-card">
                    @if($photo)
                        <img src="{{ asset('storage/' . $photo->path) }}"
                             alt="{{ $animal->name }}"
                             class="card-img-top spyc-card-img">
                    @else
                        <div class="spyc-card-img spyc-img-placeholder">
                            <i class="bi bi-heart-pulse"></i>
                            <span>Sin foto</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="fw-bold mb-1" style="color:#2a2622;">{{ $animal->name }}</h5>
                        <div class="text-muted small mb-2">
                            {{ $animal->species->label() }}{{ $animal->breed ? ' · ' . $animal->breed : '' }}
                        </div>
                        <div class="d-flex flex-wrap gap-2 small text-muted">
                            <span><i class="bi bi-calendar3 me-1"></i>{{ $animal->age_formatted }}</span>
                            <span>
                                @if($animal->sex === 'male')
                                    <i class="bi bi-gender-male me-1 text-primary"></i>Macho
                                @else
                                    <i class="bi bi-gender-female me-1" style="color:#d63384;"></i>Hembra
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                        <a href="{{ route('catalog.show', $animal) }}"
                           class="btn btn-outline-primary btn-sm w-100">
                            Conocer más
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('catalog.index') }}" class="btn btn-primary px-4">
                <i class="bi bi-grid me-2"></i>Ver todo el catálogo
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     SECCIÓN 4 — Últimas noticias
============================================================ --}}
@if($latestPosts->isNotEmpty())
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1" style="color:#2a2622;">Noticias del albergue</h2>
            <p class="text-muted">Mantente al tanto de lo que ocurre en Super Patas y Colas</p>
        </div>
        <div class="row g-4">
            @foreach($latestPosts as $post)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                             alt="{{ $post->title }}"
                             class="card-img-top spyc-card-img">
                    @else
                        <div class="spyc-card-img spyc-img-placeholder">
                            <i class="bi bi-newspaper"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="fw-bold mb-1" style="color:#2a2622;">{{ $post->title }}</h6>
                        <div class="small text-muted mb-2">
                            <i class="bi bi-calendar3 me-1"></i>{{ $post->created_at->format('d/m/Y') }}
                        </div>
                        <p class="text-muted small mb-0">
                            {{ Str::limit(strip_tags($post->content), 150) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                        <a href="{{ route('blog.show', $post->slug) }}"
                           class="btn btn-sm btn-outline-primary w-100">
                            Leer más
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     SECCIÓN 5 — Llamado a la acción (naranja)
============================================================ --}}
<section id="contacto" class="py-5" style="background: var(--spyc-naranja);">
    <div class="container text-center text-white py-2">
        <h2 class="fw-bold mb-2">¿Quieres adoptar o ceder un animal?</h2>
        <p class="mb-4" style="opacity:.9; font-size:1.05rem;">
            Regístrate y comienza el proceso. Es rápido y completamente gratis.
        </p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            <a href="{{ route('register') }}"
               class="btn btn-light btn-lg px-4 fw-semibold"
               style="color: var(--spyc-naranja);">
                <i class="bi bi-person-plus me-2"></i>Crear cuenta
            </a>
            <a href="{{ route('contact') }}"
               class="btn btn-outline-light btn-lg px-4">
                <i class="bi bi-envelope me-2"></i>Contáctanos
            </a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Hero */
.spyc-hero {
    background: var(--spyc-rosa);
    position: relative;
    overflow: hidden;
}
.spyc-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    opacity: .25;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'><g fill='%23E8531E' fill-opacity='0.18'><path d='M30 52c0 3.5-2.7 6.3-6 6.3S18 55.5 18 52s2.7-6.3 6-6.3S30 48.5 30 52zM44 42c0 3.5-2.7 6.3-6 6.3S32 45.5 32 42s2.7-6.3 6-6.3S44 38.5 44 42zM58 42c0 3.5-2.7 6.3-6 6.3S46 45.5 46 42s2.7-6.3 6-6.3S58 38.5 58 42zM72 52c0 3.5-2.7 6.3-6 6.3S60 55.5 60 52s2.7-6.3 6-6.3S72 48.5 72 52zM45 78c-9 0-14-5.5-14-11.5 0-4.5 3.8-7.5 8.5-7.5 2.2 0 3.7.9 5.5 2.3 1.8-1.4 3.3-2.3 5.5-2.3 4.7 0 8.5 3 8.5 7.5C59 72.5 54 78 45 78z'/></g></svg>");
    background-size: 160px 160px;
}
.spyc-hero-title {
    font-size: clamp(1.8rem, 5vw, 2.8rem);
    font-weight: 800;
    color: #2a2622;
    letter-spacing: -.02em;
    line-height: 1.15;
}
.spyc-hero-subtitle {
    font-size: 1.05rem;
    color: #6b6358;
    max-width: 560px;
    margin: 16px auto 0;
    line-height: 1.6;
}
/* Stats */
.spyc-stat-card {
    padding: 24px 16px;
    border-radius: 12px;
    border: 1px solid #f0e8de;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.spyc-stat-icon {
    font-size: 2rem;
    color: var(--spyc-naranja);
    margin-bottom: 10px;
    display: block;
}
.spyc-stat-number {
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--spyc-naranja);
    line-height: 1;
    margin-bottom: 6px;
}
.spyc-stat-label {
    font-size: .85rem;
    color: #8a7f72;
}
/* Animal cards */
.spyc-animal-card {
    border-radius: 12px !important;
    transition: transform .2s ease, box-shadow .2s ease;
}
.spyc-animal-card:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 24px rgba(0,0,0,.1) !important;
}
/* Shared image sizing */
.spyc-card-img {
    height: 220px;
    width: 100%;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
}
.spyc-img-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f3ece1;
    color: #c5bcaf;
    gap: 8px;
    border-radius: 12px 12px 0 0;
}
.spyc-img-placeholder i { font-size: 2.2rem; }
.spyc-img-placeholder span { font-size: .8rem; }
@media (max-width: 575.98px) {
    .spyc-hero { padding-top: 2rem; padding-bottom: 2rem; }
    .spyc-stat-number { font-size: 1.8rem; }
}
</style>
@endpush
