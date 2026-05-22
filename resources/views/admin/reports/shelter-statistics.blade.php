<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas — Super Patas y Colas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 12px; color: #343A40; line-height: 1.4; }
        .header { background-color: #E8531E; color: #ffffff; padding: 20px; text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin: 0; }
        .header p { font-size: 11px; margin: 4px 0 0 0; opacity: 0.9; }
        .section-title { font-size: 14px; font-weight: bold; color: #E8531E; border-bottom: 2px solid #E8531E; padding-bottom: 4px; margin: 20px 0 10px 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.data-table th { background-color: #E8531E; color: #ffffff; padding: 8px 10px; text-align: left; font-size: 11px; }
        table.data-table td { padding: 6px 10px; border-bottom: 1px solid #dee2e6; font-size: 11px; }
        table.data-table tr:nth-child(even) td { background-color: #FCEAE0; }
        .total-row td { background-color: #FCEAE0 !important; font-weight: bold; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; color: #ffffff; }
        .badge-success { background-color: #28A745; }
        .badge-warning { background-color: #F5A623; color: #343A40; }
        .badge-danger { background-color: #DC3545; }
        .badge-info { background-color: #17A2B8; }
        .badge-secondary { background-color: #6c757d; }
        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px solid #dee2e6; text-align: center; font-size: 10px; color: #a1a1aa; }
        .kpi-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .kpi-table td { padding: 8px 14px; border-bottom: 1px solid #dee2e6; font-size: 12px; }
        .kpi-table tr:nth-child(even) td { background-color: #FCEAE0; }
        .kpi-label { color: #6c757d; width: 65%; }
        .kpi-value { font-weight: bold; color: #E8531E; font-size: 14px; text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $settings['shelter_name'] ?? 'Super Patas y Colas' }}</h1>
        <p>Reporte de estadísticas del albergue</p>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    {{-- Resumen general --}}
    <div class="section-title">Resumen general</div>

    <table class="kpi-table">
        <tbody>
            <tr>
                <td class="kpi-label">Total de animales en el albergue</td>
                <td class="kpi-value">{{ $totalAnimals }}</td>
            </tr>
            <tr>
                <td class="kpi-label">Animales disponibles para adopción</td>
                <td class="kpi-value">{{ $availableAnimals }}</td>
            </tr>
            <tr>
                <td class="kpi-label">Adopciones realizadas (total histórico)</td>
                <td class="kpi-value">{{ $totalAdoptions }}</td>
            </tr>
            <tr>
                <td class="kpi-label">Adopciones del mes actual</td>
                <td class="kpi-value">{{ $adoptionsThisMonth }}</td>
            </tr>
            <tr>
                <td class="kpi-label">Tiempo promedio de permanencia</td>
                <td class="kpi-value">
                    {{ $avgStay !== null ? $avgStay . ' días' : 'Sin datos' }}
                </td>
            </tr>
            <tr>
                <td class="kpi-label">Usuarios registrados en el sistema</td>
                <td class="kpi-value">{{ $totalUsers }}</td>
            </tr>
            <tr>
                <td class="kpi-label">Solicitudes de adopción pendientes</td>
                <td class="kpi-value">{{ $pendingAdoptionRequests }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Distribución por especie --}}
    <div class="section-title">Distribución por especie</div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Especie</th>
                <th style="text-align: center;">Cantidad</th>
                <th style="text-align: center;">Porcentaje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($speciesDistribution as $item)
                <tr>
                    <td>{{ $item->species->label() }}</td>
                    <td style="text-align: center;">{{ $item->total }}</td>
                    <td style="text-align: center;">
                        {{ $speciesTotal > 0 ? number_format(($item->total / $speciesTotal) * 100, 1) . '%' : '—' }}
                    </td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td style="text-align: center;">{{ $speciesTotal }}</td>
                <td style="text-align: center;">100%</td>
            </tr>
        </tbody>
    </table>

    {{-- Distribución por estado --}}
    <div class="section-title">Distribución por estado</div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Estado</th>
                <th style="text-align: center;">Cantidad</th>
                <th style="text-align: center;">Porcentaje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statusDistribution as $item)
                @php
                    $badgeClass = match($item->status) {
                        \App\Enums\AnimalStatus::Available  => 'badge-success',
                        \App\Enums\AnimalStatus::InProcess  => 'badge-warning',
                        \App\Enums\AnimalStatus::Adopted    => 'badge-info',
                        \App\Enums\AnimalStatus::Quarantine => 'badge-danger',
                        \App\Enums\AnimalStatus::Deceased   => 'badge-secondary',
                        default                             => 'badge-secondary',
                    };
                @endphp
                <tr>
                    <td>
                        <span class="badge {{ $badgeClass }}">{{ $item->status->label() }}</span>
                    </td>
                    <td style="text-align: center;">{{ $item->total }}</td>
                    <td style="text-align: center;">
                        {{ $statusTotal > 0 ? number_format(($item->total / $statusTotal) * 100, 1) . '%' : '—' }}
                    </td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td style="text-align: center;">{{ $statusTotal }}</td>
                <td style="text-align: center;">100%</td>
            </tr>
        </tbody>
    </table>

    {{-- Adopciones por mes --}}
    <div class="section-title">Adopciones por mes (últimos 6 meses)</div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Mes</th>
                <th style="text-align: center;">Cantidad de adopciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adoptionsByMonth as $monthData)
                <tr>
                    <td>{{ $monthData['month'] }}</td>
                    <td style="text-align: center;">{{ $monthData['count'] }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td style="text-align: center;">{{ $adoptionsMonthTotal }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Documento generado por el sistema {{ $settings['shelter_name'] ?? 'Super Patas y Colas' }} &mdash; {{ now()->format('d/m/Y H:i') }}</p>
        <p>Albergue {{ $settings['shelter_name'] ?? 'Super Patas y Colas' }} &middot; {{ ($settings['shelter_district'] ?? 'San Martín de Porres') . ', ' . ($settings['shelter_city'] ?? 'Lima, Perú') }}</p>
    </div>

</body>
</html>
