@extends('layouts.admin')

@section('title', 'Editar ' . $animal->name)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.animals.index') }}">Animales</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.animals.show', $animal) }}">{{ $animal->name }}</a>
    <span class="sep">/</span>
    Editar
@endsection

@section('page-title', 'Editar animal')

@section('page-actions')
    <a href="{{ route('admin.animals.show', $animal) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Cancelar
    </a>
@endsection

@section('content')

@if ($animal->hasActiveAdoptionRequests())
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Este animal tiene solicitudes de adopción activas. Algunos cambios pueden estar restringidos.
    </div>
@endif

<form method="POST" action="{{ route('admin.animals.update', $animal) }}" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- SECCIÓN 1 — Datos básicos --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
                <div class="card-header bg-white border-0 fw-semibold pt-4 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                    <i class="bi bi-card-list me-2 spyc-text-naranja"></i> Datos básicos
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold small">Nombre <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <input type="text" id="name" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $animal->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="species" class="form-label fw-semibold small">Especie <span class="text-danger">*</span></label>
                            <select id="species" name="species"
                                    class="form-select @error('species') is-invalid @enderror" required>
                                <option value="dog" {{ old('species', $animal->species->value) === 'dog' ? 'selected' : '' }}>Perro</option>
                                <option value="cat" {{ old('species', $animal->species->value) === 'cat' ? 'selected' : '' }}>Gato</option>
                            </select>
                            @error('species')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label for="sex" class="form-label fw-semibold small">Sexo <span class="text-danger">*</span></label>
                            <select id="sex" name="sex"
                                    class="form-select @error('sex') is-invalid @enderror" required>
                                <option value="male"   {{ old('sex', $animal->sex) === 'male'   ? 'selected' : '' }}>Macho</option>
                                <option value="female" {{ old('sex', $animal->sex) === 'female' ? 'selected' : '' }}>Hembra</option>
                            </select>
                            @error('sex')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="breed" class="form-label fw-semibold small">Raza</label>
                            <input type="text" id="breed" name="breed"
                                   class="form-control @error('breed') is-invalid @enderror"
                                   value="{{ old('breed', $animal->breed) }}">
                            @error('breed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label for="approximate_age" class="form-label fw-semibold small">Edad aproximada <span class="text-danger">*</span></label>
                            <input type="text" id="approximate_age" name="approximate_age"
                                   class="form-control @error('approximate_age') is-invalid @enderror"
                                   value="{{ old('approximate_age', $animal->approximate_age) }}" required>
                            @error('approximate_age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label for="weight" class="form-label fw-semibold small">Peso (kg)</label>
                            <input type="number" id="weight" name="weight" step="0.1" min="0" max="200"
                                   class="form-control @error('weight') is-invalid @enderror"
                                   value="{{ old('weight', $animal->weight) }}">
                            @error('weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 2 — Información adicional --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
                <div class="card-header bg-white border-0 fw-semibold pt-4 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                    <i class="bi bi-info-circle me-2 spyc-text-naranja"></i> Información adicional
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="health_status" class="form-label fw-semibold small">Estado de salud</label>
                            <textarea id="health_status" name="health_status" rows="2"
                                      class="form-control @error('health_status') is-invalid @enderror">{{ old('health_status', $animal->health_status) }}</textarea>
                            @error('health_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold small">Descripción</label>
                            <textarea id="description" name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $animal->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="entry_type" class="form-label fw-semibold small">Tipo de ingreso <span class="text-danger">*</span></label>
                            <select id="entry_type" name="entry_type"
                                    class="form-select @error('entry_type') is-invalid @enderror" required>
                                <option value="rescue"  {{ old('entry_type', $animal->entry_type->value) === 'rescue'  ? 'selected' : '' }}>Rescate</option>
                                <option value="cession" {{ old('entry_type', $animal->entry_type->value) === 'cession' ? 'selected' : '' }}>Cesión</option>
                            </select>
                            @error('entry_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="entry_date" class="form-label fw-semibold small">Fecha de ingreso <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                <input type="date" id="entry_date" name="entry_date"
                                       class="form-control @error('entry_date') is-invalid @enderror"
                                       value="{{ old('entry_date', $animal->entry_date?->toDateString()) }}"
                                       max="{{ now()->toDateString() }}" required>
                                @error('entry_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label fw-semibold small">Estado <span class="text-danger">*</span></label>
                            <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                @foreach ($animal->allowedStatusTransitions() as $allowed)
                                    <option value="{{ $allowed->value }}"
                                        {{ old('status', $animal->status->value) === $allowed->value ? 'selected' : '' }}>
                                        {{ $allowed->label() }}{{ $allowed === $animal->status ? ' (actual)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text text-muted">Solo se muestran los estados a los que este animal puede transicionar.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 3 — Fotografías actuales --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
                <div class="card-header bg-white border-0 fw-semibold pt-4 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                    <i class="bi bi-images me-2 spyc-text-naranja"></i> Fotografías actuales
                </div>
                <div class="card-body px-4 pb-4">
                    @if ($animal->photos->count() > 0)
                        <div class="row g-2 mb-3">
                            @foreach ($animal->photos as $photo)
                                <div class="col-6 col-sm-4 col-md-3">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $photo->path) }}"
                                             class="w-100 rounded"
                                             alt="Foto de {{ $animal->name }}"
                                             style="height:130px;object-fit:cover;border:2px solid {{ $photo->is_primary ? 'var(--spyc-naranja)' : '#e7dfd6' }}">
                                        @if ($photo->is_primary)
                                            <span class="position-absolute top-0 start-0 badge bg-primary m-1" style="font-size:.65rem">
                                                <i class="bi bi-star-fill"></i> Principal
                                            </span>
                                        @endif
                                        <div class="position-absolute top-0 end-0 m-1 d-flex flex-column gap-1">
                                            @if (! $photo->is_primary)
                                                <button type="button"
                                                        class="btn btn-sm btn-light border p-1"
                                                        style="width:28px;height:28px;line-height:1"
                                                        title="Marcar como principal"
                                                        onclick="document.getElementById('form-primary-{{ $photo->id }}').submit()">
                                                    <i class="bi bi-star"></i>
                                                </button>
                                            @endif
                                            <button type="button"
                                                    class="btn btn-sm btn-light border p-1 text-danger"
                                                    style="width:28px;height:28px;line-height:1"
                                                    title="Eliminar"
                                                    onclick="if(confirm('¿Eliminar esta fotografía?')) document.getElementById('form-delete-{{ $photo->id }}').submit()">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small mb-3">Este animal aún no tiene fotografías.</p>
                    @endif

                    <label for="photos" class="form-label fw-semibold small">Agregar nuevas fotos (máximo 5 por carga)</label>
                    <input type="file" id="photos" name="photos[]" multiple
                           accept="image/jpeg,image/png,image/webp"
                           class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror">
                    <div class="form-text text-muted">Formatos: JPG, PNG o WEBP. Hasta 5 MB cada una.</div>
                    @error('photos')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    @error('photos.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

                    <div id="photoPreview" class="row g-2 mt-3"></div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.animals.show', $animal) }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2 me-1"></i> Guardar cambios
                </button>
            </div>

        </div>
    </div>
</form>

{{-- Formularios auxiliares para fotos (fuera del form principal) --}}
@foreach ($animal->photos as $photo)
    <form id="form-delete-{{ $photo->id }}"
          method="POST"
          action="{{ route('admin.animals.destroy-photo', [$animal, $photo]) }}"
          class="d-none">
        @csrf
        @method('DELETE')
    </form>
    @if (! $photo->is_primary)
        <form id="form-primary-{{ $photo->id }}"
              method="POST"
              action="{{ route('admin.animals.set-primary-photo', [$animal, $photo]) }}"
              class="d-none">
            @csrf
            @method('PATCH')
        </form>
    @endif
@endforeach

@push('scripts')
<script>
    (function () {
        const input   = document.getElementById('photos');
        const preview = document.getElementById('photoPreview');
        if (!input || !preview) return;

        input.addEventListener('change', function () {
            preview.innerHTML = '';
            const files = Array.from(this.files).slice(0, 5);
            files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = e => {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-sm-4 col-md-3';
                    col.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" class="w-100 rounded" style="height:110px;object-fit:cover;border:1px dashed #c5bcaf">
                            <span class="position-absolute top-0 start-0 badge bg-secondary m-1" style="font-size:.65rem">Nueva</span>
                        </div>`;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        });
    })();
</script>
@endpush

@endsection
