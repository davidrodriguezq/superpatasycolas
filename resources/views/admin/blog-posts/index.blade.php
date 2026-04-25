@extends('layouts.admin')

@section('title', 'Blog')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    Blog
@endsection

@section('page-title', 'Artículos del blog')

@section('page-actions')
    <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Nuevo artículo
    </a>
@endsection

@section('content')

@if($posts->isNotEmpty())
<div class="admin-table">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Título</th>
                <th>Estado</th>
                <th>Autor</th>
                <th>Fecha</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td class="fw-semibold" style="max-width:340px;">
                    {{ $post->title }}
                </td>
                <td>
                    @if($post->is_published)
                        <span class="status-pill status-available">
                            <i class="bi bi-check-circle me-1"></i>Publicado
                        </span>
                    @else
                        <span class="status-pill status-deceased">
                            <i class="bi bi-file-earmark me-1"></i>Borrador
                        </span>
                    @endif
                </td>
                <td class="text-muted small">
                    {{ $post->author?->name ?? '—' }}
                </td>
                <td class="text-muted small">
                    {{ $post->created_at->format('d/m/Y') }}
                </td>
                <td class="text-end">
                    <div class="d-flex gap-1 justify-content-end">
                        @if($post->is_published)
                        <a href="{{ route('blog.show', $post->slug) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-secondary"
                           title="Ver en blog">
                            <i class="bi bi-eye"></i>
                        </a>
                        @endif
                        <a href="{{ route('admin.blog-posts.edit', $post) }}"
                           class="btn btn-sm btn-outline-primary"
                           title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('admin.blog-posts.destroy', $post) }}"
                              onsubmit="return confirm('¿Eliminar este artículo? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($posts->hasPages())
<div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <p class="text-muted small mb-0">
        Mostrando {{ $posts->firstItem() }}–{{ $posts->lastItem() }} de {{ $posts->total() }} artículos
    </p>
    {{ $posts->withQueryString()->links() }}
</div>
@endif

@else
<div class="card border-0 shadow-sm" style="border-radius:10px;">
    <div class="card-body text-center py-5">
        <i class="bi bi-newspaper fs-1 opacity-25 d-block mb-2"></i>
        <p class="text-muted mb-3">Aún no hay artículos publicados.</p>
        <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Crear primer artículo
        </a>
    </div>
</div>
@endif

@endsection
