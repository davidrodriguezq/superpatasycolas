@extends('layouts.public')

@section('title', 'Verificar correo — Super Patas y Colas')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5 text-center">

                    <img src="{{ asset('images/logo.png') }}" alt="Super Patas y Colas" height="56" class="mb-3">
                    <h4 class="fw-bold mb-2">Verifica tu correo</h4>
                    <p class="text-muted">
                        Gracias por registrarte. Antes de continuar, haz clic en el enlace de verificación
                        que enviamos a tu correo electrónico.
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success">
                            Se ha enviado un nuevo enlace de verificación a tu correo.
                        </div>
                    @endif

                    <div class="d-grid gap-2 mt-4">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                Reenviar correo de verificación
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
