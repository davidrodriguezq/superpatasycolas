@extends('layouts.public')

@section('title', 'Confirmar contraseña — Super Patas y Colas')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Super Patas y Colas" height="56" class="mb-3">
                        <h4 class="fw-bold mb-0">Confirmar contraseña</h4>
                        <p class="text-muted small">
                            Esta es un área segura. Por favor confirma tu contraseña para continuar.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Contraseña</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="current-password"
                                autofocus
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
