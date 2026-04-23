@extends('layouts.public')

@section('title', 'Crear cuenta — Super Patas y Colas')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Super Patas y Colas" height="56" class="mb-3">
                        <h4 class="fw-bold mb-0">Crear cuenta</h4>
                        <p class="text-muted small">Únete a nuestra comunidad de bienestar animal</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        {{-- Tipo de usuario --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">¿Qué te trae aquí?</label>
                            <div class="d-grid gap-2">
                                <div class="form-check border rounded-3 p-3 @error('role_type') border-danger @enderror">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="role_type"
                                        id="roleAdopter"
                                        value="adopter"
                                        {{ old('role_type', 'adopter') === 'adopter' ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label fw-semibold" for="roleAdopter">
                                        <i class="bi bi-heart-fill text-primary me-1"></i>
                                        Quiero adoptar una mascota
                                    </label>
                                </div>
                                <div class="form-check border rounded-3 p-3 @error('role_type') border-danger @enderror">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="role_type"
                                        id="roleSurrenderer"
                                        value="surrenderer"
                                        {{ old('role_type') === 'surrenderer' ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label fw-semibold" for="roleSurrenderer">
                                        <i class="bi bi-box-arrow-in-right text-primary me-1"></i>
                                        Quiero entregar un animal al albergue
                                    </label>
                                </div>
                            </div>
                            @error('role_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre completo</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Ej. María García"
                                autocomplete="name"
                                autofocus
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="correo@ejemplo.com"
                                autocomplete="username"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label for="phone" class="form-label fw-semibold">
                                    Teléfono <span class="text-muted fw-normal">(opcional)</span>
                                </label>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Ej. 987 654 321"
                                    autocomplete="tel"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="address" class="form-label fw-semibold">
                                    Dirección <span class="text-muted fw-normal">(opcional)</span>
                                </label>
                                <input
                                    type="text"
                                    id="address"
                                    name="address"
                                    value="{{ old('address') }}"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Ej. Los Olivos, Lima"
                                    autocomplete="street-address"
                                >
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Contraseña</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="new-password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirmar contraseña</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
                    </form>

                    <hr class="my-4">

                    <p class="text-center text-muted mb-0">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
