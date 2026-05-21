@extends('layouts.admin')

@section('title', $animal->name)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.animals.index') }}">Animales</a>
    <span class="sep">/</span>
    {{ $animal->name }}
@endsection

@section('content')

{{-- Encabezado con acciones --}}
<div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-4">
    <div>
        <h3 class="mb-1 fw-bold d-flex align-items-center gap-2">
            {{ $animal->name }}
            @include('admin.animals._status_badge', ['status' => $animal->status])
        </h3>
        <p class="text-muted small mb-0">
            {{ $animal->species->label() }}{{ $animal->breed ? ' · '.$animal->breed : '' }}
            · {{ $animal->sex === 'male' ? 'Macho' : 'Hembra' }}
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.animals.edit', $animal) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Editar
        </a>
        <a href="{{ route('admin.reports.animal-medical', $animal) }}" class="btn btn-outline-danger btn-sm" target="_blank">
            <i class="bi bi-file-earmark-pdf me-1"></i> Exportar ficha médica
        </a>
        <a href="{{ route('admin.animals.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
        @php
            $canDelete = $animal->status !== \App\Enums\AnimalStatus::Adopted && ! $animal->hasActiveAdoptionRequests();
        @endphp
        @if ($canDelete)
            <form method="POST" action="{{ route('admin.animals.destroy', $animal) }}"
                  onsubmit="return confirm('¿Eliminar a {{ addslashes($animal->name) }}? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash me-1"></i> Eliminar
                </button>
            </form>
        @endif
    </div>
</div>

{{-- SECCIÓN 2 — Galería + Datos --}}
<div class="row g-3 mb-4">

    {{-- Galería --}}
    <div class="col-12 col-md-5">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 8px;">
            <div class="card-body">
                @if ($animal->photos->count() > 0)
                    @php $primary = $animal->primaryPhoto ?? $animal->photos->first(); @endphp
                    <img id="mainPhoto"
                         src="{{ asset('storage/' . $primary->path) }}"
                         alt="Foto de {{ $animal->name }}"
                         class="w-100 rounded mb-3"
                         style="height: 320px; object-fit: cover; background:#faf6f2;">

                    @if ($animal->photos->count() > 1)
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach ($animal->photos as $photo)
                                <img src="{{ asset('storage/' . $photo->path) }}"
                                     class="rounded"
                                     style="width:64px;height:64px;object-fit:cover;cursor:pointer;border:2px solid {{ $photo->is_primary ? 'var(--spyc-naranja)' : 'transparent' }}"
                                     onclick="document.getElementById('mainPhoto').src=this.src"
                                     alt="Miniatura">
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center text-center"
                         style="height: 320px; background: #faf6f2; color: #c5bcaf; border-radius: 8px;">
                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2 mb-0">Sin fotografías</p>
                    </div>
                @endif

                <a href="{{ route('admin.animals.edit', $animal) }}"
                   class="btn btn-outline-primary btn-sm w-100 mt-3">
                    <i class="bi bi-plus-circle me-1"></i> Gestionar fotografías
                </a>
            </div>
        </div>
    </div>

    {{-- Datos --}}
    <div class="col-12 col-md-7">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 8px;">
            <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
                <i class="bi bi-card-list me-2 spyc-text-naranja"></i> Datos del animal
            </div>
            <div class="card-body px-4 pb-4">
                <dl class="row mb-0 small">
                    <dt class="col-sm-4 text-muted fw-normal py-1">Especie</dt>
                    <dd class="col-sm-8 fw-semibold py-1">{{ $animal->species->label() }}</dd>

                    <dt class="col-sm-4 text-muted fw-normal py-1">Raza</dt>
                    <dd class="col-sm-8 fw-semibold py-1">{{ $animal->breed ?: '—' }}</dd>

                    <dt class="col-sm-4 text-muted fw-normal py-1">Sexo</dt>
                    <dd class="col-sm-8 fw-semibold py-1">{{ $animal->sex === 'male' ? 'Macho' : 'Hembra' }}</dd>

                    <dt class="col-sm-4 text-muted fw-normal py-1">Edad aproximada</dt>
                    <dd class="col-sm-8 fw-semibold py-1">{{ $animal->age_formatted }}</dd>

                    <dt class="col-sm-4 text-muted fw-normal py-1">Peso</dt>
                    <dd class="col-sm-8 fw-semibold py-1">
                        {{ $animal->weight ? number_format((float) $animal->weight, 2) . ' kg' : '—' }}
                    </dd>

                    <dt class="col-sm-4 text-muted fw-normal py-1">Estado de salud</dt>
                    <dd class="col-sm-8 fw-semibold py-1">{{ $animal->health_status ?: '—' }}</dd>

                    <dt class="col-sm-4 text-muted fw-normal py-1">Tipo de ingreso</dt>
                    <dd class="col-sm-8 fw-semibold py-1">{{ $animal->entry_type->label() }}</dd>

                    <dt class="col-sm-4 text-muted fw-normal py-1">Fecha de ingreso</dt>
                    <dd class="col-sm-8 fw-semibold py-1">{{ $animal->entry_date?->format('d/m/Y') }}</dd>

                    @if ($animal->cedente)
                        <dt class="col-sm-4 text-muted fw-normal py-1">Cedido por</dt>
                        <dd class="col-sm-8 fw-semibold py-1">
                            <a href="{{ route('admin.users.show', $animal->cedente) }}">
                                {{ $animal->cedente->name }}
                            </a>
                        </dd>
                    @endif

                    @if ($animal->description)
                        <dt class="col-sm-4 text-muted fw-normal py-1">Descripción</dt>
                        <dd class="col-sm-8 py-1">{{ $animal->description }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>

{{-- SECCIÓN 3 — Historial clínico --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
        <span class="fw-semibold">
            <i class="bi bi-clipboard2-pulse me-2 spyc-text-naranja"></i> Historial clínico
        </span>
        <button class="btn btn-sm btn-primary" type="button"
                data-bs-toggle="collapse" data-bs-target="#medicalForm">
            <i class="bi bi-plus-circle me-1"></i> Agregar registro
        </button>
    </div>

    <div class="collapse {{ $errors->any() && old('type') ? 'show' : '' }}" id="medicalForm">
        <div class="card-body px-4 pt-3 pb-2 bg-light" style="border-bottom:1px solid #f3ece1">
            <form method="POST" action="{{ route('admin.animals.medical-records.store', $animal) }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Fecha</label>
                        <input type="date" name="date"
                               class="form-control form-control-sm @error('date') is-invalid @enderror"
                               value="{{ old('date', now()->toDateString()) }}"
                               max="{{ now()->toDateString() }}" required>
                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Tipo</label>
                        <input type="text" name="type" list="medicalTypes"
                               class="form-control form-control-sm @error('type') is-invalid @enderror"
                               value="{{ old('type') }}"
                               placeholder="Vacunación" required>
                        <datalist id="medicalTypes">
                            <option value="Vacunación">
                            <option value="Desparasitación">
                            <option value="Esterilización">
                            <option value="Control general">
                            <option value="Tratamiento">
                        </datalist>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Veterinario</label>
                        <input type="text" name="veterinarian"
                               class="form-control form-control-sm @error('veterinarian') is-invalid @enderror"
                               value="{{ old('veterinarian') }}"
                               placeholder="Dr. / Dra. ...">
                        @error('veterinarian')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Descripción</label>
                        <textarea name="description" rows="2"
                                  class="form-control form-control-sm @error('description') is-invalid @enderror"
                                  required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-check2 me-1"></i> Guardar registro
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                data-bs-toggle="collapse" data-bs-target="#medicalForm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 admin-table-inner">
            <thead>
                <tr>
                    <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;">Fecha</th>
                    <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;">Tipo</th>
                    <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;">Descripción</th>
                    <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;">Veterinario</th>
                    <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;width:80px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($animal->medicalRecords as $record)
                    <tr>
                        <td class="small">{{ $record->date?->format('d/m/Y') }}</td>
                        <td class="fw-semibold small">{{ $record->type }}</td>
                        <td class="small">{{ \Illuminate\Support\Str::limit($record->description, 100) }}</td>
                        <td class="small">{{ $record->veterinarian ?: '—' }}</td>
                        <td>
                            <form method="POST"
                                  action="{{ route('admin.animals.medical-records.destroy', [$animal, $record]) }}"
                                  onsubmit="return confirm('¿Eliminar este registro clínico?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4 small">
                            No hay registros clínicos. Agrega el primer registro.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SECCIÓN 4 — Solicitudes de adopción --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
        <i class="bi bi-house-heart me-2 spyc-text-naranja"></i> Solicitudes de adopción
    </div>
    <div class="card-body px-4 pb-4">
        @if ($animal->adoptionRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="small text-muted">
                            <th>Código</th>
                            <th>Solicitante</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($animal->adoptionRequests as $req)
                            <tr>
                                <td class="small fw-semibold">{{ $req->tracking_code ?? '—' }}</td>
                                <td class="small">{{ $req->user?->name ?? '—' }}</td>
                                <td class="small">
                                    @php
                                        $statusVal = is_object($req->status) ? $req->status->value : $req->status;
                                    @endphp
                                    @switch($statusVal)
                                        @case('pending')    <span class="badge bg-warning text-dark">Pendiente</span> @break
                                        @case('approved')   <span class="badge bg-success">Aprobada</span> @break
                                        @case('rejected')   <span class="badge bg-danger">Rechazada</span> @break
                                        @case('cancelled')  <span class="badge bg-secondary">Cancelada</span> @break
                                        @default            <span class="badge bg-secondary">{{ $statusVal }}</span>
                                    @endswitch
                                </td>
                                <td class="small text-muted">{{ $req->created_at?->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-muted small mt-3 mb-0">
                <i class="bi bi-info-circle me-1"></i>
                Las solicitudes se gestionan desde el módulo de adopciones (Fase 2).
            </p>
        @else
            <p class="text-muted small mb-0">
                <i class="bi bi-info-circle me-1"></i>
                Las solicitudes se gestionarán desde el módulo de adopciones (Fase 2).
            </p>
        @endif
    </div>
</div>

{{-- SECCIÓN 5 — Seguimientos post-adopción --}}
@php
    $approvedRequest = $animal->adoptionRequests->firstWhere(
        'status', \App\Enums\AdoptionRequestStatus::Approved
    );
    $allFollowups = $approvedRequest?->followups ?? collect();
@endphp
@if ($animal->status === \App\Enums\AnimalStatus::Adopted || $allFollowups->count() > 0)
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3 px-4 pb-2"
         style="border-radius: 8px 8px 0 0;">
        <span class="fw-semibold">
            <i class="bi bi-clipboard-check me-2 spyc-text-naranja"></i>
            Seguimiento post-adopción
            @if ($allFollowups->count() > 0)
                <span class="badge bg-secondary ms-1">{{ $allFollowups->count() }}</span>
            @endif
        </span>
        @if ($approvedRequest)
            <a href="{{ route('admin.followups.create', $approvedRequest) }}"
               class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Nuevo seguimiento
            </a>
        @endif
    </div>

    @if ($allFollowups->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0 admin-table-inner">
                <thead>
                    <tr>
                        <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;">Fecha</th>
                        <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;">Estado animal</th>
                        <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;">Condición hogar</th>
                        <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;">Observaciones</th>
                        <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:12px 16px;background:#FAF6F2;width:70px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allFollowups as $followup)
                        <tr>
                            <td class="small fw-semibold">{{ $followup->visit_date?->format('d/m/Y') }}</td>
                            <td class="small">
                                <span class="badge {{ $followup->animal_condition_badge_class }}">
                                    {{ $followup->animal_condition_label }}
                                </span>
                            </td>
                            <td class="small">
                                <span class="badge {{ $followup->home_condition_badge_class }}">
                                    {{ $followup->home_condition_label }}
                                </span>
                            </td>
                            <td class="small text-muted">
                                {{ \Illuminate\Support\Str::limit($followup->observations, 80) }}
                            </td>
                            <td>
                                <a href="{{ route('admin.followups.show', $followup) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card-body px-4 pb-4">
            <p class="text-muted small mb-0">
                <i class="bi bi-info-circle me-1"></i>
                Aún no hay seguimientos registrados para esta adopción.
            </p>
        </div>
    @endif
</div>
@endif

{{-- SECCIÓN 6 — Cambio rápido de estado --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-0 fw-semibold pt-3 px-4 pb-2" style="border-radius: 8px 8px 0 0;">
        <i class="bi bi-arrow-left-right me-2 spyc-text-naranja"></i> Cambiar estado
    </div>
    <div class="card-body px-4 pb-4">
        @php $allowed = $animal->allowedStatusTransitions(); @endphp
        @if (count($allowed) <= 1)
            <p class="text-muted small mb-0">
                El animal está en estado "{{ $animal->status->label() }}" y no admite transiciones adicionales.
            </p>
        @else
            <form method="POST" action="{{ route('admin.animals.update', $animal) }}" class="row g-2 align-items-end">
                @csrf
                @method('PUT')
                {{-- Campos ocultos requeridos por update (mantener datos actuales) --}}
                <input type="hidden" name="name" value="{{ $animal->name }}">
                <input type="hidden" name="species" value="{{ $animal->species->value }}">
                <input type="hidden" name="breed" value="{{ $animal->breed }}">
                <input type="hidden" name="sex" value="{{ $animal->sex }}">
                <input type="hidden" name="approximate_age" value="{{ $animal->approximate_age }}">
                <input type="hidden" name="weight" value="{{ $animal->weight }}">
                <input type="hidden" name="health_status" value="{{ $animal->health_status }}">
                <input type="hidden" name="description" value="{{ $animal->description }}">
                <input type="hidden" name="entry_type" value="{{ $animal->entry_type->value }}">
                <input type="hidden" name="entry_date" value="{{ $animal->entry_date?->toDateString() }}">

                <div class="col-sm-8 col-md-6">
                    <label for="status_quick" class="form-label small fw-semibold">Nuevo estado</label>
                    <select id="status_quick" name="status" class="form-select form-select-sm">
                        @foreach ($allowed as $allowedStatus)
                            <option value="{{ $allowedStatus->value }}" {{ $allowedStatus === $animal->status ? 'selected' : '' }}>
                                {{ $allowedStatus->label() }}{{ $allowedStatus === $animal->status ? ' (actual)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 col-md-3">
                    <button type="submit" class="btn btn-warning btn-sm w-100">
                        <i class="bi bi-check2 me-1"></i> Actualizar estado
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

@endsection
