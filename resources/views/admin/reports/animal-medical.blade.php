<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha médica — {{ $animal->name }}</title>
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
        .info-label { font-weight: bold; color: #6c757d; display: inline-block; width: 160px; }
        .info-value { color: #343A40; }
        .info-row { margin-bottom: 6px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; color: #ffffff; }
        .badge-success { background-color: #28A745; }
        .badge-warning { background-color: #F5A623; color: #343A40; }
        .badge-danger { background-color: #DC3545; }
        .badge-info { background-color: #17A2B8; }
        .badge-secondary { background-color: #6c757d; }
        .badge-naranja { background-color: #E8531E; }
        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px solid #dee2e6; text-align: center; font-size: 10px; color: #a1a1aa; }
        .photo-section { margin-bottom: 10px; }
        .data-block { padding: 14px; border: 1px solid #dee2e6; border-radius: 6px; margin-bottom: 16px; }
        .total-row { font-weight: bold; background-color: #FCEAE0; }
        .total-row td { padding: 6px 10px; font-size: 11px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $settings['shelter_name'] ?? 'Super Patas y Colas' }}</h1>
        <p>Ficha médica del animal &mdash; Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    {{-- Sección: Datos del animal --}}
    <div class="section-title">Datos del animal</div>

    <table style="width:100%; margin-bottom: 16px;">
        <tr>
            <td style="width: 75%; vertical-align: top;">
                <div class="data-block">
                    <div class="info-row">
                        <span class="info-label">Nombre:</span>
                        <span class="info-value">{{ $animal->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Especie:</span>
                        <span class="info-value">{{ $animal->species->label() }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Raza:</span>
                        <span class="info-value">{{ $animal->breed ?? 'Mestizo/a' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Sexo:</span>
                        <span class="info-value">{{ $animal->sex === 'male' ? 'Macho' : 'Hembra' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Edad aproximada:</span>
                        <span class="info-value">{{ $animal->age_formatted }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Peso:</span>
                        <span class="info-value">
                            {{ $animal->weight ? number_format((float) $animal->weight, 2) . ' kg' : '—' }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Estado actual:</span>
                        <span class="info-value">
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
                            <span class="badge {{ $badgeClass }}">{{ $animal->status->label() }}</span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Estado de salud:</span>
                        <span class="info-value">{{ $animal->health_status ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tipo de ingreso:</span>
                        <span class="info-value">{{ $animal->entry_type->label() }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fecha de ingreso:</span>
                        <span class="info-value">{{ $animal->entry_date?->format('d/m/Y') ?? '—' }}</span>
                    </div>
                    @if ($animal->cedente)
                        <div class="info-row">
                            <span class="info-label">Cedido por:</span>
                            <span class="info-value">{{ $animal->cedente->name }}</span>
                        </div>
                    @endif
                    @if ($animal->description)
                        <div class="info-row" style="margin-top: 8px;">
                            <span class="info-label" style="vertical-align: top;">Descripción:</span>
                            <span class="info-value">{{ $animal->description }}</span>
                        </div>
                    @endif
                </div>
            </td>
            <td style="width: 25%; vertical-align: top; padding-left: 12px;">
                @php
                    $primaryPhoto = $animal->photos->firstWhere('is_primary', true) ?? $animal->photos->first();
                @endphp
                @if ($primaryPhoto)
                    @php $photoPath = storage_path('app/public/' . $primaryPhoto->path); @endphp
                    @if (file_exists($photoPath))
                        <img src="{{ $photoPath }}"
                             style="width: 100%; height: auto; border-radius: 6px; border: 1px solid #dee2e6;"
                             alt="Foto de {{ $animal->name }}">
                    @endif
                @endif
            </td>
        </tr>
    </table>

    {{-- Sección: Historial clínico --}}
    <div class="section-title">Historial clínico</div>

    @if ($animal->medicalRecords->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 12%;">Fecha</th>
                    <th style="width: 18%;">Tipo</th>
                    <th style="width: 52%;">Descripción</th>
                    <th style="width: 18%;">Veterinario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($animal->medicalRecords as $record)
                    <tr>
                        <td>{{ $record->date?->format('d/m/Y') ?? '—' }}</td>
                        <td><strong>{{ $record->type }}</strong></td>
                        <td>{{ $record->description }}</td>
                        <td>{{ $record->veterinarian ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p style="font-size: 10px; color: #6c757d; margin-top: -8px; margin-bottom: 16px;">
            Total: {{ $animal->medicalRecords->count() }} registro(s) clínico(s)
        </p>
    @else
        <p style="color: #6c757d; font-style: italic; margin-bottom: 16px;">
            No se han registrado consultas médicas para este animal.
        </p>
    @endif

    <div class="footer">
        <p>Documento generado por el sistema {{ $settings['shelter_name'] ?? 'Super Patas y Colas' }} &mdash; {{ now()->format('d/m/Y H:i') }}</p>
        <p>Albergue {{ $settings['shelter_name'] ?? 'Super Patas y Colas' }} &middot; {{ ($settings['shelter_district'] ?? 'San Martín de Porres') . ', ' . ($settings['shelter_city'] ?? 'Lima, Perú') }}</p>
    </div>

</body>
</html>
