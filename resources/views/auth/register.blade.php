@extends('layouts.public')

@section('title', 'Crear cuenta — Super Patas y Colas')

@section('content')
<section class="spyc-auth-wrap">
    <div class="container">
        <div class="spyc-auth-card is-wide">

            <div class="spyc-auth-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Super Patas y Colas" width="52" height="52">
                <div class="spyc-auth-brand-text">
                    Super Patas y Colas
                    <small>Albergue · SMP, Lima</small>
                </div>
            </div>

            <h1 class="spyc-auth-title">Crear cuenta</h1>
            <p class="spyc-auth-subtitle">Únete a nuestra comunidad de amantes de los animales</p>

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                {{-- Datos personales --}}
                <div class="spyc-form-section-label">Datos personales</div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Ej. María Reyes Quispe"
                            autocomplete="name"
                            autofocus
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="tu@correo.com"
                                autocomplete="username"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Teléfono <span class="text-muted" style="font-weight:400;">(opcional)</span></label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-phone"></i></span>
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}"
                                placeholder="+51 999 000 000"
                                autocomplete="tel"
                            >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="address" class="form-label">Dirección <span class="text-muted" style="font-weight:400;">(opcional)</span></label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                        <input
                            id="address"
                            name="address"
                            type="text"
                            class="form-control @error('address') is-invalid @enderror"
                            value="{{ old('address') }}"
                            placeholder="Av. Los Rescatados 1234, SMP"
                            autocomplete="street-address"
                        >
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tipo de cuenta --}}
                <div class="spyc-form-section-label">¿Qué deseas hacer?</div>
                <p style="font-size:.85rem; color:#8a7f72; margin:-4px 0 14px;">Elige el tipo de cuenta que mejor se ajuste a ti.</p>

                <div class="spyc-role-group @error('role_type') is-invalid @enderror">
                    <div class="spyc-role-option">
                        <input
                            type="radio"
                            name="role_type"
                            id="role-adopter"
                            value="adopter"
                            {{ old('role_type', 'adopter') === 'adopter' ? 'checked' : '' }}
                        >
                        <label for="role-adopter">
                            <div class="spyc-role-icon"><i class="bi bi-heart"></i></div>
                            <div class="spyc-role-title">Quiero adoptar una mascota</div>
                            <div class="spyc-role-desc">Podrás explorar el catálogo y enviar solicitudes de adopción.</div>
                            <div class="spyc-role-check"><i class="bi bi-check-lg"></i></div>
                        </label>
                    </div>
                    <div class="spyc-role-option">
                        <input
                            type="radio"
                            name="role_type"
                            id="role-surrenderer"
                            value="surrenderer"
                            {{ old('role_type') === 'surrenderer' ? 'checked' : '' }}
                        >
                        <label for="role-surrenderer">
                            <div class="spyc-role-icon"><i class="bi bi-box-arrow-in-right"></i></div>
                            <div class="spyc-role-title">Quiero entregar un animal al albergue</div>
                            <div class="spyc-role-desc">Podrás registrar solicitudes de cesión de animales.</div>
                            <div class="spyc-role-check"><i class="bi bi-check-lg"></i></div>
                        </label>
                    </div>
                </div>
                @error('role_type')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror

                {{-- Seguridad --}}
                <div class="spyc-form-section-label" style="margin-top:22px;">Seguridad</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Mínimo 8 caracteres"
                                autocomplete="new-password"
                                required
                            >
                            <button type="button" class="btn-password-toggle" aria-label="Mostrar contraseña">
                                <i class="bi bi-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirmar contraseña <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                class="form-control"
                                placeholder="Repite tu contraseña"
                                autocomplete="new-password"
                                required
                            >
                            <button type="button" class="btn-password-toggle" aria-label="Mostrar contraseña">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="spyc-password-reqs">
                    <i class="bi bi-info-circle"></i>
                    Mínimo 8 caracteres. Te recomendamos combinar letras, números y un símbolo.
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-4">
                    <i class="bi bi-person-check me-1"></i> Crear cuenta
                </button>

                <div class="spyc-auth-sep">o</div>

                <div class="spyc-auth-switch">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-password-toggle');
    if (!btn) return;
    const ig = btn.closest('.input-group');
    if (!ig) return;
    const inp = ig.querySelector('input');
    if (!inp) return;
    const showing = inp.type === 'text';
    inp.type = showing ? 'password' : 'text';
    const icon = btn.querySelector('i');
    if (icon) {
        icon.classList.toggle('bi-eye', showing);
        icon.classList.toggle('bi-eye-slash', !showing);
    }
});
</script>
@endpush
