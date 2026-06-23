@extends('layouts.admin')

@section('title', 'Usuarios')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    Usuarios
@endsection

@section('page-title', 'Gestión de usuarios')

@section('content')

{{-- Filtros --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 d-flex align-items-center" style="border-radius: 8px 8px 0 0; padding: 14px 20px;">
        <button class="btn btn-sm btn-outline-secondary" type="button"
                data-bs-toggle="collapse" data-bs-target="#filterCollapse"
                aria-expanded="{{ request()->hasAny(['role','status','search']) ? 'true' : 'false' }}">
            <i class="bi bi-funnel me-1"></i> Filtros
        </button>
        @if (request()->hasAny(['role', 'status', 'search']))
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-link text-muted ms-2 p-0">
                <i class="bi bi-x-circle me-1"></i>Limpiar filtros
            </a>
        @endif
    </div>
    <div class="collapse {{ request()->hasAny(['role','status','search']) ? 'show' : '' }}" id="filterCollapse">
        <div class="card-body pt-0 pb-3 px-4">
            <form method="GET" action="{{ route('admin.users.index') }}" data-auto-search>
                <div class="row g-3 align-items-end">
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label small fw-semibold text-muted">Rol</label>
                        <select name="role" class="form-select form-select-sm">
                            <option value="">Todos los roles</option>
                            <option value="admin"        {{ request('role') === 'admin'        ? 'selected' : '' }}>Administrador</option>
                            <option value="collaborator" {{ request('role') === 'collaborator' ? 'selected' : '' }}>Colaborador</option>
                            <option value="adopter"      {{ request('role') === 'adopter'      ? 'selected' : '' }}>Adoptante</option>
                            <option value="surrenderer"  {{ request('role') === 'surrenderer'  ? 'selected' : '' }}>Cedente</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label small fw-semibold text-muted">Estado</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Activo</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-sm-8 col-md-4">
                        <label class="form-label small fw-semibold text-muted">Buscar</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="Escribe para buscar por nombre o email..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-sm-4 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary flex-grow-1">Buscar</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tabla --}}
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $i => $user)
                    <tr>
                        <td class="text-muted">{{ $users->firstItem() + $i }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td>
                            @php $role = $user->getRoleNames()->first() @endphp
                            @if ($role === 'admin')
                                <span class="badge bg-danger">Administrador</span>
                            @elseif ($role === 'collaborator')
                                <span class="badge bg-info">Colaborador</span>
                            @elseif ($role === 'adopter')
                                <span class="badge bg-success">Adoptante</span>
                            @elseif ($role === 'surrenderer')
                                <span class="badge bg-warning text-dark">Cedente</span>
                            @else
                                <span class="badge bg-secondary">Sin rol</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-nowrap">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.users.toggle-status', $user) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('{{ $user->is_active ? '¿Desactivar a ' . addslashes($user->name) . '? Su cuenta quedará inhabilitada.' : '¿Activar a ' . addslashes($user->name) . '?' }}')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-sm {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                            title="{{ $user->is_active ? 'Desactivar' : 'Activar' }}">
                                        <i class="bi {{ $user->is_active ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-people fs-2 d-block mb-2 opacity-25"></i>
                            No se encontraron usuarios con los filtros aplicados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
@if ($users->hasPages())
    <div class="mt-4 d-flex justify-content-between align-items-center">
        <p class="text-muted small mb-0">
            Mostrando {{ $users->firstItem() }}–{{ $users->lastItem() }} de {{ $users->total() }} usuarios
        </p>
        {{ $users->withQueryString()->links() }}
    </div>
@endif

@endsection
