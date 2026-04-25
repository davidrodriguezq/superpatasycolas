@extends('layouts.admin')

@section('title', 'Registrar seguimiento - Admin')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.followups.index') }}">Seguimientos</a>
    <span class="sep">/</span>
    Nuevo registro
@endsection

@section('page-title', 'Registrar seguimiento post-adopción')

@section('content')

{{-- Contexto de la adopción --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
         style="border-radius: 8px 8px 0 0;">
        <i class="bi bi-info-circle me-2 spyc-text-naranja"></i> Contexto de la adopción
    </div>
    <div class="card-body px-4 pb-4">
        @php
            $animal  = $adoptionRequest->animal;
            $primary = $animal->photos->firstWhere('is_primary', true) ?? $animal->photos->first();
        @endphp
        <div class="row g-4 align-items-start">
            <div class="col-12 col-md-5">
                <div class="d-flex align-items-center gap-3">
                    @if ($primary)
                        <img src="{{ asset('storage/' . $primary->path) }}"
                             class="rounded"
                             style="width: 72px; height: 72px; object-fit: cover;"
                             alt="{{ $animal->name }}">
                    @else
                        <div class="rounded d-flex align-items-center justify-content-center"
                             style="width: 72px; height: 72px; background: #faf6f2; color: #c5bcaf;">
                            <i class="bi bi-image fs-4"></i>
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('admin.animals.show', $animal) }}"
                           class="fw-bold text-decoration-none d-block">
                            {{ $animal->name }}
                        </a>
                        <div class="text-muted small">
                            {{ $animal->species?->label() }}{{ $animal->breed ? ' · ' . $animal->breed : '' }}
                        </div>
                        <span class="badge" style="background: #FCEAE0; color: #b9411a; font-size: .72rem;">
                            Adoptado
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <dl class="row mb-0 small">
                    <dt class="col-sm-5 text-muted fw-normal py-1">Adoptante</dt>
                    <dd class="col-sm-7 fw-semibold py-1">{{ $adoptionRequest->user?->name ?? '—' }}</dd>

                    <dt class="col-sm-5 text-muted fw-normal py-1">Correo</dt>
                    <dd class="col-sm-7 py-1">{{ $adoptionRequest->user?->email ?? '—' }}</dd>

                    <dt class="col-sm-5 text-muted fw-normal py-1">Teléfono</dt>
                    <dd class="col-sm-7 py-1">{{ $adoptionRequest->user?->phone ?: '—' }}</dd>

                    <dt class="col-sm-5 text-muted fw-normal py-1">Fecha de adopción</dt>
                    <dd class="col-sm-7 py-1">
                        {{ optional($adoptionRequest->approved_at ?? $adoptionRequest->updated_at)->format('d/m/Y') }}
                    </dd>

                    <dt class="col-sm-5 text-muted fw-normal py-1">Seguimientos previos</dt>
                    <dd class="col-sm-7 py-1">{{ $adoptionRequest->followups->count() }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

{{-- Formulario principal --}}
<form method="POST"
      action="{{ route('admin.followups.store', $adoptionRequest) }}"
      enctype="multipart/form-data">
    @csrf

    {{-- Alerta crítica — visible con JS cuando corresponde --}}
    <div id="criticalAlert" class="alert alert-danger d-none mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Atención:</strong> Este seguimiento será marcado como alerta crítica y aparecerá en el dashboard.
    </div>

    {{-- Datos de la visita --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
        <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
             style="border-radius: 8px 8px 0 0;">
            <i class="bi bi-calendar3 me-2 spyc-text-naranja"></i> Datos de la visita
        </div>
        <div class="card-body px-4 pb-4">
            <div class="col-md-4">
                <label for="visit_date" class="form-label fw-semibold small">
                    Fecha de visita <span class="text-danger">*</span>
                </label>
                <input type="date" id="visit_date" name="visit_date"
                       class="form-control @error('visit_date') is-invalid @enderror"
                       value="{{ old('visit_date', now()->toDateString()) }}"
                       max="{{ now()->toDateString() }}" required>
                @error('visit_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- Evaluación --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
        <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
             style="border-radius: 8px 8px 0 0;">
            <i class="bi bi-clipboard-check me-2 spyc-text-naranja"></i> Evaluación
        </div>
        <div class="card-body px-4 pb-4">
            <div class="row g-4">

                {{-- Estado del animal --}}
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold small d-block mb-2">
                        Estado del animal <span class="text-danger">*</span>
                    </label>
                    @error('animal_condition')
                        <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror
                    <div class="d-flex flex-column gap-2">
                        @foreach ([
                            ['value' => 'good', 'icon' => 'bi-emoji-smile',   'label' => 'Bueno',   'desc' => 'El animal se ve saludable, activo y bien cuidado'],
                            ['value' => 'fair', 'icon' => 'bi-emoji-neutral', 'label' => 'Regular', 'desc' => 'El animal presenta algunas necesidades que requieren atención'],
                            ['value' => 'poor', 'icon' => 'bi-emoji-frown',   'label' => 'Malo',    'desc' => 'El animal presenta signos de descuido, enfermedad o maltrato'],
                        ] as $opt)
                            <div class="spyc-role-option">
                                <input type="radio"
                                       name="animal_condition"
                                       id="ac_{{ $opt['value'] }}"
                                       value="{{ $opt['value'] }}"
                                       {{ old('animal_condition') === $opt['value'] ? 'checked' : '' }}
                                       onchange="checkCritical()">
                                <label for="ac_{{ $opt['value'] }}">
                                    <div class="spyc-role-icon">
                                        <i class="bi {{ $opt['icon'] }}"></i>
                                    </div>
                                    <div class="spyc-role-title">{{ $opt['label'] }}</div>
                                    <div class="spyc-role-desc">{{ $opt['desc'] }}</div>
                                    <div class="spyc-role-check">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Condición del hogar --}}
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold small d-block mb-2">
                        Condición del hogar <span class="text-danger">*</span>
                    </label>
                    @error('home_condition')
                        <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror
                    <div class="d-flex flex-column gap-2">
                        @foreach ([
                            ['value' => 'adequate',          'icon' => 'bi-house-check',      'label' => 'Adecuado',        'desc' => 'El hogar ofrece condiciones apropiadas para el animal'],
                            ['value' => 'needs_improvement', 'icon' => 'bi-house-exclamation', 'label' => 'Necesita mejora', 'desc' => 'El hogar requiere algunos ajustes para el bienestar del animal'],
                            ['value' => 'inadequate',        'icon' => 'bi-house-x',           'label' => 'Inadecuado',      'desc' => 'El hogar no cumple con las condiciones mínimas para el animal'],
                        ] as $opt)
                            <div class="spyc-role-option">
                                <input type="radio"
                                       name="home_condition"
                                       id="hc_{{ $opt['value'] }}"
                                       value="{{ $opt['value'] }}"
                                       {{ old('home_condition') === $opt['value'] ? 'checked' : '' }}
                                       onchange="checkCritical()">
                                <label for="hc_{{ $opt['value'] }}">
                                    <div class="spyc-role-icon">
                                        <i class="bi {{ $opt['icon'] }}"></i>
                                    </div>
                                    <div class="spyc-role-title">{{ $opt['label'] }}</div>
                                    <div class="spyc-role-desc">{{ $opt['desc'] }}</div>
                                    <div class="spyc-role-check">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Observaciones --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
        <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
             style="border-radius: 8px 8px 0 0;">
            <i class="bi bi-pencil-square me-2 spyc-text-naranja"></i> Observaciones
        </div>
        <div class="card-body px-4 pb-4">
            <label for="observations" class="form-label fw-semibold small">
                Observaciones de la visita <span class="text-danger">*</span>
            </label>
            <textarea id="observations" name="observations" rows="5"
                      class="form-control @error('observations') is-invalid @enderror"
                      maxlength="2000"
                      placeholder="Describe lo observado durante la visita: comportamiento del animal, interacción con la familia, alimentación, higiene, espacio, etc."
                      oninput="updateObsCount(this)">{{ old('observations') }}</textarea>
            @error('observations')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="d-flex justify-content-between mt-1">
                <small class="text-muted">Mínimo 10 caracteres.</small>
                <small class="text-muted">
                    <span id="obsCount">{{ strlen(old('observations', '')) }}</span>/2000
                </small>
            </div>
        </div>
    </div>

    {{-- Fotografías --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
        <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2"
             style="border-radius: 8px 8px 0 0;">
            <i class="bi bi-images me-2 spyc-text-naranja"></i> Fotografías de evidencia
        </div>
        <div class="card-body px-4 pb-4">
            <input type="file" id="photos" name="photos[]" multiple accept="image/*"
                   class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror"
                   onchange="previewFollowupPhotos(this)">
            @error('photos')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            @error('photos.*')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1">
                Sube fotos del animal y su entorno durante la visita (máximo 5 fotos, 5 MB cada una).
                Formatos: JPG, PNG, WebP.
            </small>
            <div id="photoPreviewContainer" class="d-flex flex-wrap gap-2 mt-3"></div>
        </div>
    </div>

    {{-- Botones --}}
    <div class="d-flex gap-2 flex-wrap">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle me-1"></i> Registrar seguimiento
        </button>
        <a href="{{ route('admin.adoption-requests.show', $adoptionRequest) }}"
           class="btn btn-outline-secondary">
            Cancelar
        </a>
    </div>

</form>

@endsection

@push('scripts')
<script>
function checkCritical() {
    const animalCond = document.querySelector('input[name="animal_condition"]:checked')?.value;
    const homeCond   = document.querySelector('input[name="home_condition"]:checked')?.value;
    const alertEl    = document.getElementById('criticalAlert');
    if (alertEl) {
        const isCritical = animalCond === 'poor' || homeCond === 'inadequate';
        alertEl.classList.toggle('d-none', !isCritical);
    }
}

function updateObsCount(el) {
    const counter = document.getElementById('obsCount');
    if (counter) counter.textContent = el.value.length;
}

function previewFollowupPhotos(input) {
    const container = document.getElementById('photoPreviewContainer');
    container.innerHTML = '';
    if (!input.files) return;
    const files = Array.from(input.files).slice(0, 5);
    files.forEach(function (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'rounded';
            img.style.cssText = 'width:80px;height:80px;object-fit:cover;border:2px solid #e7dfd6;';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

document.addEventListener('DOMContentLoaded', checkCritical);
</script>
@endpush
