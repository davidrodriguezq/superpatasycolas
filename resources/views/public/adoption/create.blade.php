@extends('layouts.public')

@section('title', 'Solicitar adopción de ' . $animal->name . ' — Super Patas y Colas')

@section('content')

<section class="spyc-auth-wrap">
    <div class="container" style="max-width: 900px;">

        <div class="mb-4 text-center">
            <h1 class="fw-bold mb-1" style="color: #2a2622; font-size: 1.5rem;">
                Formulario de solicitud de adopción
            </h1>
            <p class="text-muted mb-0 small">
                Completa la siguiente información para que podamos evaluar tu solicitud.
            </p>
        </div>

        <div class="row g-4">

            {{-- Columna izquierda: resumen del animal --}}
            <div class="col-12 col-md-4">
                <div class="spyc-auth-card p-3">
                    @php $primary = $animal->photos->firstWhere('is_primary', true) ?? $animal->photos->first(); @endphp
                    @if ($primary)
                        <img src="{{ asset('storage/' . $primary->path) }}"
                             alt="{{ $animal->name }}"
                             class="w-100 rounded mb-3"
                             style="height: 200px; object-fit: cover; background:#faf6f2;">
                    @else
                        <div class="w-100 rounded mb-3 d-flex align-items-center justify-content-center"
                             style="height: 200px; background:#faf6f2; color:#c5bcaf;">
                            <i class="bi bi-image" style="font-size: 2.5rem;"></i>
                        </div>
                    @endif

                    <h5 class="fw-bold mb-1" style="color: #2a2622;">{{ $animal->name }}</h5>
                    <div class="small text-muted mb-2">
                        {{ $animal->species->label() }}{{ $animal->breed ? ' · ' . $animal->breed : '' }}
                    </div>

                    <dl class="row mb-3 small" style="row-gap: 4px;">
                        <dt class="col-5 text-muted fw-normal">Edad</dt>
                        <dd class="col-7 fw-semibold mb-0">{{ $animal->age_formatted }}</dd>

                        <dt class="col-5 text-muted fw-normal">Sexo</dt>
                        <dd class="col-7 fw-semibold mb-0">{{ $animal->sex === 'male' ? 'Macho' : 'Hembra' }}</dd>

                        @if ($animal->weight)
                            <dt class="col-5 text-muted fw-normal">Peso</dt>
                            <dd class="col-7 fw-semibold mb-0">{{ number_format((float) $animal->weight, 1) }} kg</dd>
                        @endif
                    </dl>

                    <span class="status-pill status-available">Disponible</span>

                    <p class="text-muted small mt-3 mb-0">
                        <i class="bi bi-info-circle me-1 spyc-text-naranja"></i>
                        Estás solicitando la adopción de este animal.
                    </p>
                </div>
            </div>

            {{-- Columna derecha: formulario --}}
            <div class="col-12 col-md-8">
                <div class="spyc-auth-card is-wide">

                    @if ($errors->any() && $errors->has('animal'))
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('animal') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('adoption.store', $animal) }}" novalidate>
                        @csrf

                        {{-- Sección: Sobre tu hogar --}}
                        <div class="spyc-form-section-label">Sobre tu hogar</div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <label for="housing_type" class="form-label">
                                    Tipo de vivienda <span class="text-danger">*</span>
                                </label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                                    <select name="housing_type"
                                            id="housing_type"
                                            class="form-select @error('housing_type') is-invalid @enderror"
                                            required>
                                        <option value="" disabled {{ old('housing_type') ? '' : 'selected' }}>Selecciona una opción</option>
                                        <option value="casa_propia"     {{ old('housing_type') === 'casa_propia'     ? 'selected' : '' }}>Casa propia</option>
                                        <option value="departamento"    {{ old('housing_type') === 'departamento'    ? 'selected' : '' }}>Departamento</option>
                                        <option value="casa_alquilada"  {{ old('housing_type') === 'casa_alquilada'  ? 'selected' : '' }}>Casa alquilada</option>
                                        <option value="otro"            {{ old('housing_type') === 'otro'            ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('housing_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label for="household_members" class="form-label">
                                    Personas en el hogar <span class="text-danger">*</span>
                                </label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-people"></i></span>
                                    <input type="number"
                                           name="household_members"
                                           id="household_members"
                                           class="form-control @error('household_members') is-invalid @enderror"
                                           value="{{ old('household_members', 1) }}"
                                           min="1"
                                           max="20"
                                           required>
                                    @error('household_members')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">
                                ¿Tienes otras mascotas? <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('has_other_pets') is-invalid @enderror"
                                           type="radio"
                                           name="has_other_pets"
                                           id="has_other_pets_yes"
                                           value="1"
                                           {{ old('has_other_pets') === '1' ? 'checked' : '' }}
                                           onchange="document.getElementById('otherPetsDescBlock').classList.remove('d-none');">
                                    <label class="form-check-label" for="has_other_pets_yes">Sí</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('has_other_pets') is-invalid @enderror"
                                           type="radio"
                                           name="has_other_pets"
                                           id="has_other_pets_no"
                                           value="0"
                                           {{ old('has_other_pets') === '0' ? 'checked' : '' }}
                                           onchange="document.getElementById('otherPetsDescBlock').classList.add('d-none');">
                                    <label class="form-check-label" for="has_other_pets_no">No</label>
                                </div>
                            </div>
                            @error('has_other_pets')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="otherPetsDescBlock" class="mb-3 {{ old('has_other_pets') === '1' ? '' : 'd-none' }}">
                            <label for="other_pets_description" class="form-label">
                                Describe tus mascotas actuales
                            </label>
                            <textarea name="other_pets_description"
                                      id="other_pets_description"
                                      rows="2"
                                      maxlength="500"
                                      class="form-control @error('other_pets_description') is-invalid @enderror"
                                      placeholder="Ej. Tengo una perra labradora de 5 años, vacunada y esterilizada.">{{ old('other_pets_description') }}</textarea>
                            @error('other_pets_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">
                                ¿Cuentas con espacio al aire libre? <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('has_outdoor_space') is-invalid @enderror"
                                           type="radio"
                                           name="has_outdoor_space"
                                           id="has_outdoor_yes"
                                           value="1"
                                           {{ old('has_outdoor_space') === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_outdoor_yes">Sí</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('has_outdoor_space') is-invalid @enderror"
                                           type="radio"
                                           name="has_outdoor_space"
                                           id="has_outdoor_no"
                                           value="0"
                                           {{ old('has_outdoor_space') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_outdoor_no">No</label>
                                </div>
                            </div>
                            @error('has_outdoor_space')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Sección: Motivación --}}
                        <div class="spyc-form-section-label">Motivación</div>

                        <div class="mb-3">
                            <label for="motivation" class="form-label">
                                ¿Por qué deseas adoptar a {{ $animal->name }}? <span class="text-danger">*</span>
                            </label>
                            <textarea name="motivation"
                                      id="motivation"
                                      rows="5"
                                      minlength="50"
                                      maxlength="2000"
                                      class="form-control @error('motivation') is-invalid @enderror"
                                      placeholder="Cuéntanos sobre tu familia, tu experiencia con mascotas y por qué quieres darle un hogar a {{ $animal->name }}..."
                                      required
                                      oninput="document.getElementById('motivationCount').textContent = this.value.length + '/2000 caracteres';">{{ old('motivation') }}</textarea>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="text-muted">Mínimo 50 caracteres.</small>
                                <small class="text-muted" id="motivationCount">{{ strlen(old('motivation', '')) }}/2000 caracteres</small>
                            </div>
                            @error('motivation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-2">
                            <i class="bi bi-send me-1"></i> Enviar solicitud
                        </button>

                        <p class="text-muted small text-center mt-3 mb-0">
                            Al enviar esta solicitud, el equipo del albergue revisará tu información y te contactará.
                        </p>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
