@extends('layouts.public')

@section('title', $post->title . ' — Blog Super Patas y Colas')
@section('meta-description', Str::limit(strip_tags($post->content), 160))

@push('og-image')
@if($post->featured_image)
<meta property="og:image" content="{{ asset('storage/' . $post->featured_image) }}">
@endif
@endpush

@section('content')

<section class="py-4 py-md-5">
    <div class="container" style="max-width:800px;">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('blog.index') }}" class="text-decoration-none">Blog</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ Str::limit($post->title, 50) }}
                </li>
            </ol>
        </nav>

        @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}"
             alt="{{ $post->title }}"
             class="w-100 rounded-3 shadow-sm mb-4"
             style="max-height:400px; object-fit:cover;">
        @endif

        <h1 class="fw-bold mb-3" style="color:#2a2622; font-size:clamp(1.5rem,4vw,2rem);">
            {{ $post->title }}
        </h1>

        <div class="text-muted small mb-4 d-flex flex-wrap gap-2 align-items-center">
            <span>
                <i class="bi bi-calendar3 me-1"></i>
                {{ $post->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
            </span>
            @if($post->author)
                <span class="text-muted">·</span>
                <span>
                    <i class="bi bi-person me-1"></i>{{ $post->author->name }}
                </span>
            @endif
        </div>

        <hr style="border-color:#f0e8de;">

        <div class="mt-4 mb-5" style="line-height:1.8; color:#4a4138; font-size:1.02rem;">
            {!! nl2br(e($post->content)) !!}
        </div>

        <hr style="border-color:#f0e8de;">

        @if($recentPosts->isNotEmpty())
        <div class="mt-4">
            <h3 class="fw-bold mb-4" style="color:#2a2622; font-size:1.2rem;">Otros artículos</h3>
            <div class="row g-3">
                @foreach($recentPosts as $recent)
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100 spyc-blog-card">
                        @if($recent->featured_image)
                            <img src="{{ asset('storage/' . $recent->featured_image) }}"
                                 alt="{{ $recent->title }}"
                                 class="card-img-top spyc-blog-recent-img">
                        @else
                            <div class="spyc-blog-recent-img spyc-blog-placeholder-sm">
                                <i class="bi bi-newspaper"></i>
                            </div>
                        @endif
                        <div class="card-body p-3">
                            <div class="small text-muted mb-1">
                                {{ $recent->created_at->format('d/m/Y') }}
                            </div>
                            <h6 class="fw-bold mb-2" style="color:#2a2622; font-size:.9rem;">
                                {{ $recent->title }}
                            </h6>
                            <a href="{{ route('blog.show', $recent->slug) }}"
                               class="text-decoration-none small fw-semibold spyc-text-naranja">
                                Leer más <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Volver al blog
            </a>
        </div>

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
.spyc-blog-recent-img {
    height: 140px;
    width: 100%;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
}
.spyc-blog-placeholder-sm {
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3ece1;
    color: #c5bcaf;
    font-size: 2rem;
    border-radius: 12px 12px 0 0;
}
</style>
@endpush
