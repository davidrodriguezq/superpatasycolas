@extends('layouts.public')

@section('title', 'Iniciar sesión — Super Patas y Colas')

@section('content')
<section class="spyc-auth-wrap">
    <div class="container">
        <div class="spyc-auth-card">

            <h1 class="spyc-auth-title">Iniciar sesión</h1>
            <p class="spyc-auth-subtitle">Ingresa a tu cuenta para continuar</p>

            @if (session('status'))
                <div class="alert alert-success d-flex align-items-start gap-2 mb-3">
                    <i class="bi bi-check-circle-fill mt-1"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
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
                            autofocus
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            autocomplete="current-password"
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

                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-size:.9rem; color:#4a4138;">Recordarme</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:.9rem; font-weight:500;">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                </button>

                <div class="spyc-auth-sep">o</div>

                <div class="spyc-auth-switch">
                    ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
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
