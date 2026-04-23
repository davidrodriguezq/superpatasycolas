@extends('layouts.public')

@section('title', 'Restablecer contraseña — Super Patas y Colas')

@section('content')
<section class="spyc-auth-wrap">
    <div class="container">
        <div class="spyc-auth-card">

            <div class="spyc-auth-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Super Patas y Colas" width="52" height="52">
                <div class="spyc-auth-brand-text">
                    Super Patas y Colas
                    <small>Albergue · SMP, Lima</small>
                </div>
            </div>

            <h1 class="spyc-auth-title">Restablecer contraseña</h1>
            <p class="spyc-auth-subtitle">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>

            @if (session('status'))
                <div class="alert d-flex align-items-start gap-2 mb-3"
                     style="border:0; border-left:4px solid #28A745; background:#E6F4EA; color:#1b7a33; border-radius:10px; font-size:.9rem;">
                    <i class="bi bi-check-circle-fill mt-1"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" novalidate>
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

                @if (session('status'))
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reenviar enlace
                    </button>
                @else
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send me-1"></i> Enviar enlace
                    </button>
                @endif

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" style="font-size:.9rem; font-weight:500;">
                        <i class="bi bi-arrow-left me-1"></i> Volver a iniciar sesión
                    </a>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection
