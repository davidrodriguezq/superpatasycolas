@extends('layouts.admin')

@section('title', 'Registrar animal')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.animals.index') }}">Animales</a>
    <span class="sep">/</span>
    Registrar
@endsection

@section('page-title', 'Registrar animal')

@section('page-actions')
    <a href="{{ route('admin.animals.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Cancelar
    </a>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.animals.store') }}" enctype="multipart/form-data" novalidate>
    @csrf

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
                                       value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="species" class="form-label fw-semibold small">Especie <span class="text-danger">*</span></label>
                            <select id="species" name="species"
                                    class="form-select @error('species') is-invalid @enderror" required>
                                <option value="">Selecciona</option>
                                <option value="dog" {{ old('species') === 'dog' ? 'selected' : '' }}>Perro</option>
                                <option value="cat" {{ old('species') === 'cat' ? 'selected' : '' }}>Gato</option>
                            </select>
                            @error('species')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label for="sex" class="form-label fw-semibold small">Sexo <span class="text-danger">*</span></label>
                            <select id="sex" name="sex"
                                    class="form-select @error('sex') is-invalid @enderror" required>
                                <option value="">Selecciona</option>
                                <option value="male"   {{ old('sex') === 'male'   ? 'selected' : '' }}>Macho</option>
                                <option value="female" {{ old('sex') === 'female' ? 'selected' : '' }}>Hembra</option>
                            </select>
                            @error('sex')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="breed" class="form-label fw-semibold small">Raza</label>
                            <input type="text" id="breed" name="breed"
                                   class="form-control @error('breed') is-invalid @enderror"
                                   value="{{ old('breed') }}" placeholder="Mestizo, Labrador, Siamés...">
                            @error('breed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label for="approximate_age" class="form-label fw-semibold small">Edad aproximada <span class="text-danger">*</span></label>
                            <input type="text" id="approximate_age" name="approximate_age"
                                   class="form-control @error('approximate_age') is-invalid @enderror"
                                   value="{{ old('approximate_age') }}" placeholder="3 años" required>
                            @error('approximate_age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label for="weight" class="form-label fw-semibold small">Peso (kg)</label>
                            <input type="number" id="weight" name="weight" step="0.1" min="0" max="200"
                                   class="form-control @error('weight') is-invalid @enderror"
                                   value="{{ old('weight') }}" placeholder="12.5">
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
                                      class="form-control @error('health_status') is-invalid @enderror"
                                      placeholder="Saludable, En tratamiento...">{{ old('health_status') }}</textarea>
                            @error('health_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold small">Descripción</label>
                            <textarea id="description" name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Carácter, comportamiento, preferencias...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="entry_type" class="form-label fw-semibold small">Tipo de ingreso <span class="text-danger">*</span></label>
                            <select id="entry_type" name="entry_type"
                                    class="form-select @error('entry_type') is-invalid @enderror" required>
                                <option value="rescue"  {{ old('entry_type', 'rescue') === 'rescue'  ? 'selected' : '' }}>Rescate</option>
                                <option value="cession" {{ old('entry_type') === 'cession' ? 'selected' : '' }}>Cesión</option>
                            </select>
                            @error('entry_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="entry_date" class="form-label fw-semibold small">Fecha de ingreso <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                <input type="date" id="entry_date" name="entry_date"
                                       class="form-control @error('entry_date') is-invalid @enderror"
                                       value="{{ old('entry_date', now()->toDateString()) }}"
                                       max="{{ now()->toDateString() }}" required>
                                @error('entry_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label fw-semibold small">Estado inicial <span class="text-danger">*</span></label>
                            <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                <option value="available"  {{ old('status', 'available') === 'available'  ? 'selected' : '' }}>Disponible</option>
                                <option value="quarantine" {{ old('status') === 'quarantine' ? 'selected' : '' }}>En cuarentena</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 3 — Fotografías --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
                <div class="card-header bg-white border-0 fw-semibold pt-4 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                    <i class="bi bi-images me-2 spyc-text-naranja"></i> Fotografías
                </div>
                <div class="card-body px-4 pb-4">
                    <label for="photos" class="form-label fw-semibold small">Subir fotos (máximo 5, hasta 5 MB c/u)</label>
                    <input type="file" id="photos" name="photos[]" multiple
                           accept="image/jpeg,image/png,image/webp"
                           class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror">
                    <div class="form-text text-muted">
                        La primera imagen quedará marcada como principal. Formatos: JPG, PNG o WEBP.
                    </div>
                    @error('photos')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    @error('photos.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

                    <input type="hidden" name="primary_photo" id="primary_photo" value="0">

                    <div id="photoPreview" class="row g-2 mt-3"></div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.animals.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2 me-1"></i> Registrar animal
                </button>
            </div>

        </div>
    </div>
</form>

@push('scripts')
<script>
    (function () {
        const input   = document.getElementById('photos');
        const preview = document.getElementById('photoPreview');
        const primary = document.getElementById('primary_photo');
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
                            <img src="${e.target.result}" class="w-100 rounded" style="height:110px;object-fit:cover;border:2px solid ${idx===0?'var(--spyc-naranja)':'#e7dfd6'}" data-idx="${idx}">
                            <span class="position-absolute top-0 start-0 badge ${idx===0?'bg-primary':'bg-secondary'} m-1" style="font-size:.65rem">${idx===0?'Principal':'#'+(idx+1)}</span>
                        </div>`;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
            primary.value = '0';
        });
    })();
</script>
@endpush

@endsection
