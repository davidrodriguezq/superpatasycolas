@extends('layouts.public')

@section('title', 'Blog — Super Patas y Colas')
@section('meta-description', 'Noticias, consejos y campañas del albergue Super Patas y Colas. Información sobre adopción responsable y cuidado animal.')

@section('content')

{{-- Hero --}}
<section class="spyc-bg-rosa py-4 py-md-5">
    <div class="container text-center">
        <h1 class="fw-bold mb-2" style="color:#2a2622; font-size:clamp(1.4rem,4vw,2rem);">
            Blog del albergue
        </h1>
        <p class="text-muted mb-0">Noticias, consejos y campañas</p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        @if($posts->isNotEmpty())
        <div class="row g-4">
            @foreach($posts as $post)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 spyc-blog-card">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                             alt="{{ $post->title }}"
                             class="card-img-top spyc-blog-card-img">
                    @else
                        <div class="spyc-blog-card-img spyc-blog-placeholder">
                            <i class="bi bi-newspaper"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="small text-muted mb-2">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $post->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                        </div>
                        <h5 class="fw-bold mb-2" style="color:#2a2622;">{{ $post->title }}</h5>
                        <p class="text-muted small mb-0">
                            {{ Str::limit(strip_tags($post->content), 200) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                        <a href="{{ route('blog.show', $post->slug) }}"
                           class="text-decoration-none fw-semibold spyc-text-naranja">
                            Leer más <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($posts->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm mx-auto" style="max-width:420px; border-radius:12px;">
                <div class="card-body py-5 px-4">
                    <i class="bi bi-newspaper d-block mb-3 spyc-text-naranja" style="font-size:3rem; opacity:.6;"></i>
                    <h5 class="fw-bold mb-2" style="color:#2a2622;">Próximamente</h5>
                    <p class="text-muted mb-0">Próximamente publicaremos noticias y consejos del albergue.</p>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

@endsection

@push('styles')
<style>
.spyc-blog-card {
    border-radius: 12px !important;
    transition: transform .2s ease, box-shadow .2s ease;
}
.spyc-blog-card:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 24px rgba(0,0,0,.10) !important;
}
.spyc-blog-card-img {
    height: 200px;
    width: 100%;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
}
.spyc-blog-placeholder {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3ece1;
    color: #c5bcaf;
    font-size: 2.4rem;
    border-radius: 12px 12px 0 0;
}
</style>
@endpush
