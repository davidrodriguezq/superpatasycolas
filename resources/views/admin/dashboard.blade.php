@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    Panel admin / Dashboard
@endsection

@section('content')

{{-- FILA 1: KPIs principales --}}
<div class="row g-3 mb-3">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-4" style="border-left-color:var(--spyc-naranja)!important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center"
                     style="width:54px;height:54px;background:rgba(232,83,30,.12);">
                    <i class="bi bi-heart-pulse fs-4" style="color:var(--spyc-naranja);"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size:1.75rem;line-height:1;color:#2a2622;">{{ $totalAnimals }}</div>
                    <div class="text-muted small mt-1">Animales en el albergue</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center"
                     style="width:54px;height:54px;background:rgba(40,167,69,.12);">
                    <i class="bi bi-search-heart fs-4 text-success"></i>
                </div>
                <div>
                    <div class="fw-bold text-success" style="font-size:1.75rem;line-height:1;">{{ $availableAnimals }}</div>
                    <div class="text-muted small mt-1">Disponibles para adopción</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-4" style="border-left-color:var(--spyc-dorado)!important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center"
                     style="width:54px;height:54px;background:rgba(245,166,35,.15);">
                    <i class="bi bi-house-heart fs-4" style="color:var(--spyc-dorado);"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size:1.75rem;line-height:1;color:#2a2622;">{{ $adoptionsThisMonth }}</div>
                    <div class="text-muted small mt-1">Adopciones este mes</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center"
                     style="width:54px;height:54px;background:rgba(23,162,184,.12);">
                    <i class="bi bi-clock-history fs-4 text-info"></i>
                </div>
                <div>
                    <div class="fw-bold text-info" style="font-size:1.75rem;line-height:1;">
                        {{ $avgStay !== null ? $avgStay : '—' }}
                    </div>
                    <div class="text-muted small mt-1">Días promedio de permanencia</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FILA 2: métricas secundarias --}}
<div class="row g-3 mb-4">
    <div class="col-xl-4 col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <i class="bi bi-hourglass-split fs-3 text-muted flex-shrink-0"></i>
                <div>
                    <div class="fw-bold"
                         style="font-size:1.4rem;line-height:1;color:{{ $pendingAdoptionRequests > 0 ? 'var(--spyc-naranja)' : '#2a2622' }};">
                        {{ $pendingAdoptionRequests }}
                    </div>
                    <div class="text-muted small">Adopciones pendientes</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <i class="bi bi-people fs-3 text-muted flex-shrink-0"></i>
                <div>
                    <div class="fw-bold" style="font-size:1.4rem;line-height:1;color:#2a2622;">{{ $totalUsers }}</div>
                    <div class="text-muted small">Usuarios registrados</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <i class="bi bi-trophy fs-3 text-muted flex-shrink-0"></i>
                <div>
                    <div class="fw-bold" style="font-size:1.4rem;line-height:1;color:#2a2622;">{{ $totalAdoptions }}</div>
                    <div class="text-muted small">Adopciones en total</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FILA 3: Gráfica de adopciones por mes + Distribución por especie --}}
<div class="row g-3 mb-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h6 class="fw-semibold mb-0">
                    Adopciones por mes
                    <small class="text-muted fw-normal">(últimos 6 meses)</small>
                </h6>
            </div>
            <div class="card-body">
                @if(array_sum(array_column($adoptionsByMonth, 'count')) > 0)
                    <div style="height:280px;position:relative;">
                        <canvas id="adoptionsChart"></canvas>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-bar-chart display-4 d-block mb-3 opacity-25"></i>
                        <span class="small">Sin adopciones en los últimos 6 meses</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h6 class="fw-semibold mb-0">Animales por especie</h6>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                @if($speciesDistribution->isNotEmpty())
                    <div style="height:220px;position:relative;width:100%;max-width:240px;">
                        <canvas id="speciesChart"></canvas>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-pie-chart display-4 d-block mb-3 opacity-25"></i>
                        <span class="small">Sin datos</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- FILA 4: Distribución por estado + Alertas de seguimiento --}}
<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h6 class="fw-semibold mb-0">Animales por estado</h6>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                @if($statusDistribution->isNotEmpty())
                    <div style="height:220px;position:relative;width:100%;max-width:240px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-pie-chart display-4 d-block mb-3 opacity-25"></i>
                        <span class="small">Sin datos</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-0">
                    Seguimientos con alerta
                    <span class="badge ms-1 {{ $criticalCount > 0 ? 'bg-danger' : 'bg-success' }}">
                        {{ $criticalCount }}
                    </span>
                </h6>
                @if($criticalCount > 0)
                    <a href="{{ route('admin.followups.index', ['critical' => 1]) }}"
                       class="btn btn-sm btn-outline-danger">Ver todas</a>
                @endif
            </div>
            <div class="card-body p-0">
                @if($criticalCount > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead style="background:#fff5f5;">
                                <tr>
                                    <th class="px-3" style="font-size:.73rem;color:#6b6358;text-transform:uppercase;font-weight:600;">Animal</th>
                                    <th class="px-3" style="font-size:.73rem;color:#6b6358;text-transform:uppercase;font-weight:600;">Adoptante</th>
                                    <th class="px-3" style="font-size:.73rem;color:#6b6358;text-transform:uppercase;font-weight:600;">Estado</th>
                                    <th class="px-3" style="font-size:.73rem;color:#6b6358;text-transform:uppercase;font-weight:600;">Hogar</th>
                                    <th class="px-3" style="font-size:.73rem;color:#6b6358;text-transform:uppercase;font-weight:600;">Fecha</th>
                                    <th class="px-3" style="width:56px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($criticalFollowups as $followup)
                                    <tr>
                                        <td class="px-3 small fw-semibold">
                                            @if($followup->adoptionRequest?->animal)
                                                <a href="{{ route('admin.animals.show', $followup->adoptionRequest->animal) }}"
                                                   class="text-decoration-none">
                                                    {{ $followup->adoptionRequest->animal->name }}
                                                </a>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="px-3 small">{{ $followup->adoptionRequest?->user?->name ?? '—' }}</td>
                                        <td class="px-3 small">
                                            <span class="badge {{ $followup->animal_condition_badge_class }}">
                                                {{ $followup->animal_condition_label }}
                                            </span>
                                        </td>
                                        <td class="px-3 small">
                                            <span class="badge {{ $followup->home_condition_badge_class }}">
                                                {{ $followup->home_condition_label }}
                                            </span>
                                        </td>
                                        <td class="px-3 small text-muted">{{ $followup->visit_date?->format('d/m/Y') }}</td>
                                        <td class="px-3">
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
                    <div class="text-center py-5 px-3" style="background:rgba(40,167,69,.04);">
                        <i class="bi bi-check-circle display-4 text-success d-block mb-2" style="opacity:.7;"></i>
                        <p class="text-success mb-0 small fw-semibold">Todos los seguimientos están en buen estado</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- FILA 5: Actividad reciente --}}
<div class="row g-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-0">Últimas solicitudes de adopción</h6>
                <a href="{{ route('admin.adoption-requests.index') }}"
                   class="btn btn-sm btn-outline-secondary">Ver todas</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead style="background:#FAF6F2;">
                        <tr>
                            <th class="px-3" style="font-size:.73rem;color:#6b6358;text-transform:uppercase;font-weight:600;">Solicitante</th>
                            <th class="px-3" style="font-size:.73rem;color:#6b6358;text-transform:uppercase;font-weight:600;">Animal</th>
                            <th class="px-3" style="font-size:.73rem;color:#6b6358;text-transform:uppercase;font-weight:600;">Estado</th>
                            <th class="px-3" style="font-size:.73rem;color:#6b6358;text-transform:uppercase;font-weight:600;">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAdoptionRequests as $req)
                            <tr>
                                <td class="px-3 small fw-semibold">{{ $req->user?->name ?? '—' }}</td>
                                <td class="px-3 small">{{ $req->animal?->name ?? '—' }}</td>
                                <td class="px-3 small">
                                    <span class="badge {{ $req->status_badge_class }}">{{ $req->status_label }}</span>
                                </td>
                                <td class="px-3 small text-muted">{{ $req->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3 small">Sin solicitudes registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
(function () {
    const adoptionsByMonth     = @json($adoptionsByMonth);
    const speciesDistribution  = @json($speciesDistribution);
    const statusDistribution   = @json($statusDistribution);

    Chart.defaults.font.family   = 'system-ui, -apple-system, "Segoe UI", sans-serif';
    Chart.defaults.animation.duration = 500;

    // Gráfica: adopciones por mes (barras)
    const adoptionsCanvas = document.getElementById('adoptionsChart');
    if (adoptionsCanvas) {
        new Chart(adoptionsCanvas, {
            type: 'bar',
            data: {
                labels: adoptionsByMonth.map(d => d.month),
                datasets: [{
                    label: 'Adopciones',
                    data: adoptionsByMonth.map(d => d.count),
                    backgroundColor: 'rgba(232,83,30,.85)',
                    borderColor: '#E8531E',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { color: 'rgba(0,0,0,.05)' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Gráfica: distribución por especie (doughnut)
    const speciesCanvas = document.getElementById('speciesChart');
    if (speciesCanvas) {
        const speciesLabels = Object.keys(speciesDistribution);
        const speciesValues = Object.values(speciesDistribution);
        const speciesColors = ['#E8531E', '#F5A623', '#28A745', '#17A2B8', '#6c757d'];
        new Chart(speciesCanvas, {
            type: 'doughnut',
            data: {
                labels: speciesLabels,
                datasets: [{
                    data: speciesValues,
                    backgroundColor: speciesColors.slice(0, speciesLabels.length),
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 16, boxWidth: 12 }
                    },
                    tooltip: { enabled: true }
                }
            }
        });
    }

    // Gráfica: distribución por estado (doughnut)
    const statusCanvas = document.getElementById('statusChart');
    if (statusCanvas) {
        const statusColorMap = {
            'Disponible':    '#28A745',
            'En proceso':    '#17A2B8',
            'Adoptado':      '#F5A623',
            'En cuarentena': '#E8531E',
            'Fallecido':     '#6c757d',
        };
        const statusLabels = Object.keys(statusDistribution);
        const statusColors = statusLabels.map(l => statusColorMap[l] || '#adb5bd');
        new Chart(statusCanvas, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: Object.values(statusDistribution),
                    backgroundColor: statusColors,
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 16, boxWidth: 12 }
                    },
                    tooltip: { enabled: true }
                }
            }
        });
    }
})();
</script>
@endpush
