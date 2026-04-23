@extends('layouts.admin')

@section('title', 'Editar ' . $user->name)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.users.index') }}">Usuarios</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a>
    <span class="sep">/</span>
    Editar
@endsection

@section('page-title', 'Editar usuario')

@section('page-actions')
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Cancelar
    </a>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm" style="border-radius: 8px;">
            <div class="card-header bg-white border-0 fw-semibold pt-4 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                <i class="bi bi-person-gear me-2 spyc-text-naranja"></i> Datos del usuario
            </div>
            <div class="card-body px-4 pb-4">

                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PATCH')

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small">Nombre completo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small">Correo electrónico</label>
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
                        <label for="phone" class="form-label fw-semibold small">Teléfono</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" id="phone" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold small">Dirección</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" id="address" name="address"
                                   class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address', $user->address) }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Rol --}}
                    <div class="mb-4">
                        <label for="role" class="form-label fw-semibold small">Rol</label>
                        @php $isOwnAccount = auth()->id() === $user->id @endphp
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                            <select id="role" name="role"
                                    class="form-select @error('role') is-invalid @enderror"
                                    @if ($isOwnAccount) disabled @endif>
                                <option value="admin"        {{ old('role', $user->getRoleNames()->first()) === 'admin'        ? 'selected' : '' }}>Administrador</option>
                                <option value="collaborator" {{ old('role', $user->getRoleNames()->first()) === 'collaborator' ? 'selected' : '' }}>Colaborador</option>
                                <option value="adopter"      {{ old('role', $user->getRoleNames()->first()) === 'adopter'      ? 'selected' : '' }}>Adoptante</option>
                                <option value="surrenderer"  {{ old('role', $user->getRoleNames()->first()) === 'surrenderer'  ? 'selected' : '' }}>Cedente</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($isOwnAccount)
                            <div class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i> No puedes cambiar tu propio rol.
                            </div>
                        @endif
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2 me-1"></i> Guardar cambios
                        </button>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
