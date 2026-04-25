@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    Panel admin / Dashboard
@endsection

@section('content')
    <div class="row g-4">

        {{-- Widget: alertas críticas de seguimiento --}}
        @if ($criticalCount > 0)
        <div class="col-12">
            <div class="card border-0 shadow-sm border-start border-danger border-4" style="border-radius: 8px;">
                <div class="card-header bg-danger bg-opacity-10 border-0 d-flex justify-content-between align-items-center pt-3 px-4 pb-2"
                     style="border-radius: 8px 8px 0 0;">
                    <span class="fw-semibold text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Alertas críticas de seguimiento
                        <span class="badge bg-danger ms-1">{{ $criticalCount }}</span>
                    </span>
                    <a href="{{ route('admin.followups.index', ['critical' => 1]) }}"
                       class="btn btn-sm btn-danger">
                        Ver todas
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:10px 16px;background:#fff5f5;">Animal</th>
                                <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:10px 16px;background:#fff5f5;">Adoptante</th>
                                <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:10px 16px;background:#fff5f5;">Estado animal</th>
                                <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:10px 16px;background:#fff5f5;">Condición hogar</th>
                                <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:10px 16px;background:#fff5f5;">Fecha visita</th>
                                <th style="font-size:.78rem;text-transform:uppercase;color:#6b6358;padding:10px 16px;background:#fff5f5;width:70px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($criticalFollowups as $followup)
                                <tr>
                                    <td class="small fw-semibold">
                                        {{ $followup->adoptionRequest?->animal?->name ?? '—' }}
                                    </td>
                                    <td class="small">
                                        {{ $followup->adoptionRequest?->user?->name ?? '—' }}
                                    </td>
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
                                        {{ $followup->visit_date?->format('d/m/Y') }}
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
            </div>
        </div>
        @endif

        {{-- Panel principal (Fase 4) --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-speedometer2 display-1 text-muted mb-3 d-block"></i>
                    <h4 class="text-muted mb-2">Panel en construcción — Fase 4</h4>
                    <p class="text-muted mb-0">
                        Las métricas e indicadores se implementarán en la Fase 4 del proyecto.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0 fw-semibold">Información de sesión</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <span class="fw-semibold">Usuario:</span>
                            {{ auth()->user()->name }}
                        </li>
                        <li class="list-group-item px-0">
                            <span class="fw-semibold">Correo:</span>
                            {{ auth()->user()->email }}
                        </li>
                        <li class="list-group-item px-0">
                            <span class="fw-semibold">Rol:</span>
                            @foreach(auth()->user()->getRoleNames() as $role)
                                <span class="badge bg-primary">{{ $role }}</span>
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
