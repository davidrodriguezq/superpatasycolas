@extends('layouts.public')

@section('title', 'Verificar correo — Super Patas y Colas')

@section('content')
<section class="spyc-auth-wrap">
    <div class="container">
        <div class="spyc-auth-card">

            <div class="text-center mb-3">
                <i class="bi bi-envelope-check" style="font-size:48px; color:var(--spyc-orange, #f97316);"></i>
            </div>

            <h4 class="spyc-auth-title">Verifica tu correo electrónico</h4>
            <p class="spyc-auth-subtitle">
                Te hemos enviado un enlace de verificación a tu correo electrónico.
                Revisa tu bandeja de entrada (y la carpeta de spam) y haz clic en el enlace para activar tu cuenta.
            </p>

            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success py-2 mb-3" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    Se ha enviado un nuevo enlace de verificación a tu correo.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-outline-primary w-100 mb-3">
                    <i class="bi bi-send me-1"></i> Reenviar enlace de verificación
                </button>
            </form>

            <div class="spyc-auth-sep">o</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm w-100">
                    Cerrar sesión
                </button>
            </form>

        </div>
    </div>
</section>
@endsection
