@extends('layouts.admin')

@section('title', 'Editar artículo')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.blog-posts.index') }}">Blog</a>
    <span class="sep">/</span>
    Editar
@endsection

@section('page-title', 'Editar artículo')

@section('page-actions')
    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Volver
    </a>
@endsection

@section('content')

<form method="POST"
      action="{{ route('admin.blog-posts.update', $blogPost) }}"
      enctype="multipart/form-data"
      novalidate>
    @csrf
    @method('PUT')

    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="card border-0 shadow-sm mb-4" style="border-radius:8px;">
                <div class="card-header bg-white border-0 fw-semibold pt-4 px-4 pb-2"
                     style="border-radius:8px 8px 0 0;">
                    <i class="bi bi-card-text me-2 spyc-text-naranja"></i> Contenido del artículo
                </div>
                <div class="card-body px-4 pb-4">

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold small">
                            Título <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title', $blogPost->title) }}"
                               class="form-control @error('title') is-invalid @enderror"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label fw-semibold small">
                            Contenido <span class="text-danger">*</span>
                        </label>
                        <textarea id="content"
                                  name="content"
                                  rows="12"
                                  class="form-control @error('content') is-invalid @enderror"
                                  required>{{ old('content', $blogPost->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">
                            Los saltos de línea se preservan en la vista pública.
                        </div>
                    </div>

                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4" style="border-radius:8px;">
                <div class="card-header bg-white border-0 fw-semibold pt-4 px-4 pb-2"
                     style="border-radius:8px 8px 0 0;">
                    <i class="bi bi-image me-2 spyc-text-naranja"></i> Imagen destacada
                </div>
                <div class="card-body px-4 pb-4">

                    @if($blogPost->featured_image)
                    <div class="mb-3">
                        <p class="small fw-semibold text-muted mb-2">Imagen actual</p>
                        <img src="{{ asset('storage/' . $blogPost->featured_image) }}"
                             alt="{{ $blogPost->title }}"
                             class="rounded-3 shadow-sm"
                             style="max-height:200px; max-width:100%; object-fit:cover;">
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="featured_image" class="form-label fw-semibold small">
                            {{ $blogPost->featured_image ? 'Reemplazar imagen' : 'Agregar imagen' }} (opcional)
                        </label>
                        <input type="file"
                               id="featured_image"
                               name="featured_image"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               class="form-control @error('featured_image') is-invalid @enderror"
                               onchange="previewImage(this)">
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">
                            JPG, PNG o WebP. Máximo 5 MB.
                        </div>
                    </div>
                    <div id="imagePreviewWrap" class="d-none">
                        <img id="imagePreview"
                             src=""
                             alt="Vista previa"
                             class="rounded-3 shadow-sm"
                             style="max-height:220px; max-width:100%; object-fit:cover;">
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4" style="border-radius:8px;">
                <div class="card-body px-4 py-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               id="is_published"
                               name="is_published"
                               value="1"
                               {{ old('is_published', $blogPost->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_published">
                            Publicado
                        </label>
                    </div>
                    <div class="form-text text-muted mt-1">
                        Desmarca para guardar como borrador (no visible en el blog público).
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.blog-posts.index') }}"
                   class="btn btn-outline-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Guardar cambios
                </button>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    const wrap = document.getElementById('imagePreviewWrap');
    const img  = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            wrap.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        wrap.classList.add('d-none');
    }
}
</script>
@endpush
