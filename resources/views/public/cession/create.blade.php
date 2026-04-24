@extends('layouts.public')

@section('title', 'Ceder un animal - Super Patas y Colas')

@section('content')

<section class="spyc-auth-wrap">
    <div class="container" style="max-width: 700px;">

        <div class="mb-4 text-center">
            <h1 class="fw-bold mb-1" style="color: #2a2622; font-size: 1.5rem;">
                Formulario de cesión de animal
            </h1>
            <p class="text-muted mb-0 small">
                Completa la información del animal que deseas entregar al albergue. Nuestro equipo evaluará
                la solicitud y se pondrá en contacto contigo.
            </p>
        </div>

        <div class="spyc-auth-card is-wide" style="max-width: 700px;">

            <form method="POST" action="{{ route('cession.store') }}" novalidate>
                @csrf

                {{-- Sección: Datos del animal --}}
                <div class="spyc-form-section-label">Datos del animal</div>

                <div class="mb-3">
                    <label for="animal_name" class="form-label">
                        Nombre del animal <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="animal_name"
                           id="animal_name"
                           class="form-control @error('animal_name') is-invalid @enderror"
                           value="{{ old('animal_name') }}"
                           placeholder="Ej. Firulais"
                           maxlength="255"
                           required>
                    @error('animal_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label for="animal_species" class="form-label">
                            Especie <span class="text-danger">*</span>
                        </label>
                        <select name="animal_species"
                                id="animal_species"
                                class="form-select @error('animal_species') is-invalid @enderror"
                                required>
                            <option value="" disabled {{ old('animal_species') ? '' : 'selected' }}>Selecciona</option>
                            <option value="dog" {{ old('animal_species') === 'dog' ? 'selected' : '' }}>Perro</option>
                            <option value="cat" {{ old('animal_species') === 'cat' ? 'selected' : '' }}>Gato</option>
                        </select>
                        @error('animal_species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="animal_breed" class="form-label">Raza</label>
                        <input type="text"
                               name="animal_breed"
                               id="animal_breed"
                               class="form-control @error('animal_breed') is-invalid @enderror"
                               value="{{ old('animal_breed') }}"
                               placeholder="Opcional"
                               maxlength="255">
                        @error('animal_breed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label for="animal_sex" class="form-label">
                            Sexo <span class="text-danger">*</span>
                        </label>
                        <select name="animal_sex"
                                id="animal_sex"
                                class="form-select @error('animal_sex') is-invalid @enderror"
                                required>
                            <option value="" disabled {{ old('animal_sex') ? '' : 'selected' }}>Selecciona</option>
                            <option value="male"   {{ old('animal_sex') === 'male'   ? 'selected' : '' }}>Macho</option>
                            <option value="female" {{ old('animal_sex') === 'female' ? 'selected' : '' }}>Hembra</option>
                        </select>
                        @error('animal_sex')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="animal_approximate_age" class="form-label">
                            Edad aproximada <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="animal_approximate_age"
                               id="animal_approximate_age"
                               class="form-control @error('animal_approximate_age') is-invalid @enderror"
                               value="{{ old('animal_approximate_age') }}"
                               placeholder="Ej. 3 años"
                               maxlength="50"
                               required>
                        @error('animal_approximate_age')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label for="animal_weight" class="form-label">Peso aproximado (kg)</label>
                        <input type="number"
                               name="animal_weight"
                               id="animal_weight"
                               class="form-control @error('animal_weight') is-invalid @enderror"
                               value="{{ old('animal_weight') }}"
                               placeholder="Opcional"
                               min="0"
                               max="200"
                               step="0.1">
                        @error('animal_weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="animal_condition" class="form-label">
                            Estado del animal <span class="text-danger">*</span>
                        </label>
                        <select name="animal_condition"
                                id="animal_condition"
                                class="form-select @error('animal_condition') is-invalid @enderror"
                                required>
                            <option value="" disabled {{ old('animal_condition') ? '' : 'selected' }}>Selecciona</option>
                            <option value="good" {{ old('animal_condition') === 'good' ? 'selected' : '' }}>Buena</option>
                            <option value="fair" {{ old('animal_condition') === 'fair' ? 'selected' : '' }}>Regular</option>
                            <option value="poor" {{ old('animal_condition') === 'poor' ? 'selected' : '' }}>Mala</option>
                        </select>
                        @error('animal_condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="animal_description" class="form-label">Descripción del animal</label>
                    <textarea name="animal_description"
                              id="animal_description"
                              rows="3"
                              maxlength="2000"
                              class="form-control @error('animal_description') is-invalid @enderror"
                              placeholder="Describe el comportamiento, personalidad y cualquier información relevante del animal...">{{ old('animal_description') }}</textarea>
                    @error('animal_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Sección: Motivo de la cesión --}}
                <div class="spyc-form-section-label">Motivo de la cesión</div>

                <div class="mb-3">
                    <label for="reason" class="form-label">
                        Motivo <span class="text-danger">*</span>
                    </label>
                    <textarea name="reason"
                              id="reason"
                              rows="4"
                              minlength="20"
                              maxlength="2000"
                              class="form-control @error('reason') is-invalid @enderror"
                              placeholder="Explica por qué necesitas entregar al animal. Esta información nos ayuda a entender la situación."
                              required
                              oninput="document.getElementById('reasonCount').textContent = this.value.length + '/2000 caracteres';">{{ old('reason') }}</textarea>
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        <small class="text-muted">Mínimo 20 caracteres.</small>
                        <small class="text-muted" id="reasonCount">{{ strlen(old('reason', '')) }}/2000 caracteres</small>
                    </div>
                    @error('reason')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">
                        Urgencia <span class="text-danger">*</span>
                    </label>
                    <div class="spyc-role-group">
                        <div class="spyc-role-option">
                            <input type="radio"
                                   name="urgency"
                                   id="urgency_normal"
                                   value="normal"
                                   {{ old('urgency', 'normal') === 'normal' ? 'checked' : '' }}
                                   required>
                            <label for="urgency_normal">
                                <span class="spyc-role-icon"><i class="bi bi-clock"></i></span>
                                <span class="spyc-role-title">Normal</span>
                                <span class="spyc-role-desc">Puedo esperar a que el albergue tenga disponibilidad.</span>
                                <span class="spyc-role-check"><i class="bi bi-check"></i></span>
                            </label>
                        </div>
                        <div class="spyc-role-option">
                            <input type="radio"
                                   name="urgency"
                                   id="urgency_urgent"
                                   value="urgent"
                                   {{ old('urgency') === 'urgent' ? 'checked' : '' }}>
                            <label for="urgency_urgent">
                                <span class="spyc-role-icon"><i class="bi bi-exclamation-triangle"></i></span>
                                <span class="spyc-role-title">Urgente</span>
                                <span class="spyc-role-desc">Necesito entregar al animal lo antes posible.</span>
                                <span class="spyc-role-check"><i class="bi bi-check"></i></span>
                            </label>
                        </div>
                    </div>
                    @error('urgency')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-send me-1"></i> Enviar solicitud
                </button>

                <p class="text-muted small text-center mt-3 mb-0">
                    Al enviar, nuestro equipo revisará tu solicitud. Te contactaremos para coordinar la entrega.
                </p>

            </form>
        </div>
    </div>
</section>

@endsection
