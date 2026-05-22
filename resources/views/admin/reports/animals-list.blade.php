<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de animales — Super Patas y Colas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 11px; color: #343A40; line-height: 1.4; }
        .header { background-color: #E8531E; color: #ffffff; padding: 16px 20px; text-align: center; margin-bottom: 16px; }
        .header h1 { font-size: 16px; margin: 0; }
        .header p { font-size: 10px; margin: 3px 0 0 0; opacity: 0.9; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        table.data-table th { background-color: #E8531E; color: #ffffff; padding: 7px 8px; text-align: left; font-size: 10px; white-space: nowrap; }
        table.data-table td { padding: 5px 8px; border-bottom: 1px solid #dee2e6; font-size: 10px; vertical-align: middle; }
        table.data-table tr:nth-child(even) td { background-color: #FCEAE0; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 9px; font-weight: bold; color: #ffffff; white-space: nowrap; }
        .badge-success { background-color: #28A745; }
        .badge-warning { background-color: #F5A623; color: #343A40; }
        .badge-danger { background-color: #DC3545; }
        .badge-info { background-color: #17A2B8; }
        .badge-secondary { background-color: #6c757d; }
        .footer { margin-top: 20px; padding-top: 8px; border-top: 1px solid #dee2e6; text-align: center; font-size: 9px; color: #a1a1aa; }
        .filters-bar { background-color: #FFF5EE; border: 1px solid #FCEAE0; border-radius: 4px; padding: 6px 12px; margin-bottom: 10px; font-size: 10px; color: #6c757d; }
        .summary { margin-bottom: 10px; font-size: 11px; color: #6c757d; }
        .total-row td { background-color: #FCEAE0 !important; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $settings['shelter_name'] ?? 'Super Patas y Colas' }} &mdash; Listado de animales</h1>
        @if (!empty($appliedFilters))
            @php
                $filterLabels = [];
                $speciesMap = ['dog' => 'Perro', 'cat' => 'Gato'];
                $statusMap   = [
                    'available'  => 'Disponible',
                    'in_process' => 'En proceso',
                    'adopted'    => 'Adoptado',
                    'quarantine' => 'En cuarentena',
                    'deceased'   => 'Fallecido',
                ];
                $sexMap       = ['male' => 'Macho', 'female' => 'Hembra'];
                $entryTypeMap = ['rescue' => 'Rescate', 'cession' => 'Cesión'];

                if (!empty($appliedFilters['species']))   $filterLabels[] = 'Especie: ' . ($speciesMap[$appliedFilters['species']] ?? $appliedFilters['species']);
                if (!empty($appliedFilters['status']))    $filterLabels[] = 'Estado: '  . ($statusMap[$appliedFilters['status']]   ?? $appliedFilters['status']);
                if (!empty($appliedFilters['sex']))       $filterLabels[] = 'Sexo: '    . ($sexMap[$appliedFilters['sex']]         ?? $appliedFilters['sex']);
                if (!empty($appliedFilters['entry_type'])) $filterLabels[] = 'Ingreso: ' . ($entryTypeMap[$appliedFilters['entry_type']] ?? $appliedFilters['entry_type']);
                if (!empty($appliedFilters['search']))    $filterLabels[] = 'Búsqueda: "' . $appliedFilters['search'] . '"';
            @endphp
            <p>Filtros: {{ implode(' | ', $filterLabels) }}</p>
        @else
            <p>Todos los animales</p>
        @endif
        <p>Generado el {{ now()->format('d/m/Y H:i') }} &mdash; {{ $animals->count() }} animales encontrados</p>
    </div>

    @if ($animals->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 4%;">#</th>
                    <th style="width: 13%;">Nombre</th>
                    <th style="width: 9%;">Especie</th>
                    <th style="width: 13%;">Raza</th>
                    <th style="width: 7%;">Sexo</th>
                    <th style="width: 11%;">Edad</th>
                    <th style="width: 8%;">Peso (kg)</th>
                    <th style="width: 13%;">Estado</th>
                    <th style="width: 12%;">Ingreso</th>
                    <th style="width: 10%;">Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($animals as $i => $animal)
                    @php
                        $badgeClass = match($animal->status) {
                            \App\Enums\AnimalStatus::Available  => 'badge-success',
                            \App\Enums\AnimalStatus::InProcess  => 'badge-warning',
                            \App\Enums\AnimalStatus::Adopted    => 'badge-info',
                            \App\Enums\AnimalStatus::Quarantine => 'badge-danger',
                            \App\Enums\AnimalStatus::Deceased   => 'badge-secondary',
                            default                             => 'badge-secondary',
                        };
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $animal->name }}</strong></td>
                        <td>{{ $animal->species->label() }}</td>
                        <td>{{ $animal->breed ?? 'Mestizo/a' }}</td>
                        <td>{{ $animal->sex === 'male' ? 'Macho' : 'Hembra' }}</td>
                        <td>{{ $animal->age_formatted }}</td>
                        <td style="text-align: center;">
                            {{ $animal->weight ? number_format((float) $animal->weight, 1) : '—' }}
                        </td>
                        <td>
                            <span class="badge {{ $badgeClass }}">{{ $animal->status->label() }}</span>
                        </td>
                        <td>{{ $animal->entry_date?->format('d/m/Y') ?? '—' }}</td>
                        <td>{{ $animal->entry_type->label() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="font-size: 10px; color: #6c757d; margin-bottom: 8px;">
            <strong>Total: {{ $animals->count() }} animales</strong>
            @if (!empty($appliedFilters))
                &mdash; Filtros aplicados: {{ implode(', ', $filterLabels ?? []) }}
            @endif
        </p>
    @else
        <p style="color: #6c757d; font-style: italic; text-align: center; padding: 24px 0;">
            No se encontraron animales con los filtros aplicados.
        </p>
    @endif

    <div class="footer">
        <p>Documento generado por el sistema {{ $settings['shelter_name'] ?? 'Super Patas y Colas' }} &mdash; {{ now()->format('d/m/Y H:i') }}</p>
        <p>Albergue {{ $settings['shelter_name'] ?? 'Super Patas y Colas' }} &middot; {{ ($settings['shelter_district'] ?? 'San Martín de Porres') . ', ' . ($settings['shelter_city'] ?? 'Lima, Perú') }}</p>
    </div>

</body>
</html>
