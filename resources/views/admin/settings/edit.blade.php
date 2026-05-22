@extends('layouts.admin')

@section('title', 'Configuración del albergue')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span> Configuración
@endsection

@section('page-title', 'Configuración del albergue')

@section('content')

@if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('PUT')

    {{-- CARD 1 — Identidad --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
        <div class="card-header bg-white border-bottom" style="border-radius:12px 12px 0 0; padding:16px 20px;">
            <h6 class="fw-bold mb-0" style="color:#2a2622;">
                <i class="bi bi-building me-2 spyc-text-naranja"></i>Identidad del albergue
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">
                        Nombre del albergue <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="shelter_name"
                           value="{{ old('shelter_name', $settings['shelter_name'] ?? '') }}"
                           class="form-control @error('shelter_name') is-invalid @enderror"
                           required>
                    @error('shelter_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Slogan</label>
                    <input type="text"
                           name="shelter_slogan"
                           value="{{ old('shelter_slogan', $settings['shelter_slogan'] ?? '') }}"
                           class="form-control @error('shelter_slogan') is-invalid @enderror"
                           placeholder="Albergue de animales · SMP, Lima">
                    @error('shelter_slogan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Descripción breve</label>
                    <textarea name="shelter_description"
                              rows="3"
                              class="form-control @error('shelter_description') is-invalid @enderror"
                              placeholder="Descripción corta que aparece en el footer del sitio…">{{ old('shelter_description', $settings['shelter_description'] ?? '') }}</textarea>
                    @error('shelter_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 2 — Ubicación y contacto --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
        <div class="card-header bg-white border-bottom" style="border-radius:12px 12px 0 0; padding:16px 20px;">
            <h6 class="fw-bold mb-0" style="color:#2a2622;">
                <i class="bi bi-geo-alt me-2 spyc-text-naranja"></i>Ubicación y contacto
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">
                        Distrito <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="shelter_district"
                           value="{{ old('shelter_district', $settings['shelter_district'] ?? '') }}"
                           class="form-control @error('shelter_district') is-invalid @enderror"
                           required>
                    @error('shelter_district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">
                        Ciudad <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="shelter_city"
                           value="{{ old('shelter_city', $settings['shelter_city'] ?? '') }}"
                           class="form-control @error('shelter_city') is-invalid @enderror"
                           required>
                    @error('shelter_city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Teléfono</label>
                    <input type="text"
                           name="shelter_phone"
                           value="{{ old('shelter_phone', $settings['shelter_phone'] ?? '') }}"
                           class="form-control @error('shelter_phone') is-invalid @enderror"
                           placeholder="+51 999 000 000">
                    @error('shelter_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Correo electrónico</label>
                    <input type="email"
                           name="shelter_email"
                           value="{{ old('shelter_email', $settings['shelter_email'] ?? '') }}"
                           class="form-control @error('shelter_email') is-invalid @enderror"
                           placeholder="contacto@superpatasycolas.pe">
                    @error('shelter_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Horarios de visita</label>
                    <input type="text"
                           name="shelter_schedule"
                           value="{{ old('shelter_schedule', $settings['shelter_schedule'] ?? '') }}"
                           class="form-control @error('shelter_schedule') is-invalid @enderror"
                           placeholder="Sábados y domingos de 10:00 a 17:00">
                    @error('shelter_schedule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Nota de privacidad de ubicación</label>
                    <input type="text"
                           name="shelter_privacy_note"
                           value="{{ old('shelter_privacy_note', $settings['shelter_privacy_note'] ?? '') }}"
                           class="form-control @error('shelter_privacy_note') is-invalid @enderror"
                           placeholder="Por seguridad de nuestros animales…">
                    <div class="form-text">Este mensaje se muestra junto a la información de contacto.</div>
                    @error('shelter_privacy_note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 3 — Redes sociales --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
        <div class="card-header bg-white border-bottom" style="border-radius:12px 12px 0 0; padding:16px 20px;">
            <h6 class="fw-bold mb-0" style="color:#2a2622;">
                <i class="bi bi-share me-2 spyc-text-naranja"></i>Redes sociales
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Facebook</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                        <input type="url"
                               name="shelter_facebook"
                               value="{{ old('shelter_facebook', $settings['shelter_facebook'] ?? '') }}"
                               class="form-control @error('shelter_facebook') is-invalid @enderror"
                               placeholder="https://facebook.com/superpatasycolas">
                        @error('shelter_facebook')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Instagram</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                        <input type="url"
                               name="shelter_instagram"
                               value="{{ old('shelter_instagram', $settings['shelter_instagram'] ?? '') }}"
                               class="form-control @error('shelter_instagram') is-invalid @enderror"
                               placeholder="https://instagram.com/superpatasycolas">
                        @error('shelter_instagram')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 4 — Información institucional --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
        <div class="card-header bg-white border-bottom" style="border-radius:12px 12px 0 0; padding:16px 20px;">
            <h6 class="fw-bold mb-0" style="color:#2a2622;">
                <i class="bi bi-file-text me-2 spyc-text-naranja"></i>Información institucional
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Misión</label>
                    <textarea name="shelter_mission"
                              rows="4"
                              class="form-control @error('shelter_mission') is-invalid @enderror">{{ old('shelter_mission', $settings['shelter_mission'] ?? '') }}</textarea>
                    @error('shelter_mission')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Visión</label>
                    <textarea name="shelter_vision"
                              rows="4"
                              class="form-control @error('shelter_vision') is-invalid @enderror">{{ old('shelter_vision', $settings['shelter_vision'] ?? '') }}</textarea>
                    @error('shelter_vision')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold" style="color:#4a4138;">Historia del albergue</label>
                    <textarea name="shelter_history"
                              rows="6"
                              class="form-control @error('shelter_history') is-invalid @enderror">{{ old('shelter_history', $settings['shelter_history'] ?? '') }}</textarea>
                    @error('shelter_history')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-floppy me-2"></i>Guardar configuración
        </button>
    </div>

</form>

@endsection
