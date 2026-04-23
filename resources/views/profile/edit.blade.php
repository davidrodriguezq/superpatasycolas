@extends('layouts.public')

@section('title', 'Editar perfil - Super Patas y Colas')

@section('content')

<div class="spyc-auth-wrap py-5">
    <div class="container" style="max-width: 600px;">

        <div class="spyc-auth-card">

            {{-- Encabezado --}}
            <div class="spyc-auth-brand mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="Super Patas y Colas">
                <div class="spyc-auth-brand-text">
                    Super Patas y Colas
                    <small>Albergue · SMP, Lima</small>
                </div>
            </div>

            <h1 class="spyc-auth-title">Editar perfil</h1>
            <p class="spyc-auth-subtitle">Actualiza tu información personal</p>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                {{-- Sección: datos personales --}}
                <div class="spyc-form-section-label mb-3">Datos personales</div>

                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre completo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}"
                               required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Teléfono --}}
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono <span class="text-muted small">(opcional)</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" id="phone" name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="Ej. 987 654 321">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Dirección --}}
                <div class="mb-4">
                    <label for="address" class="form-label">Dirección <span class="text-muted small">(opcional)</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" id="address" name="address"
                               class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address', $user->address) }}"
                               placeholder="Ej. Av. Los Olivos 123, Lima">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Sección: cambiar contraseña --}}
                <div class="spyc-form-section-label mb-3">Cambiar contraseña</div>
                <p class="text-muted small mb-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Deja estos campos vacíos si no deseas cambiar tu contraseña.
                </p>

                {{-- Contraseña actual --}}
                <div class="mb-3">
                    <label for="current_password" class="form-label">Contraseña actual</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="current_password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               autocomplete="current-password">
                        <button type="button" class="btn-password-toggle"
                                onclick="togglePwd('current_password', this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Nueva contraseña --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               autocomplete="new-password">
                        <button type="button" class="btn-password-toggle"
                                onclick="togglePwd('password', this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control"
                               autocomplete="new-password">
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-check2 me-1"></i> Guardar cambios
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePwd(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    }
}
</script>
@endpush

@endsection
