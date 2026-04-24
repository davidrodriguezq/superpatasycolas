@php
    /** @var \App\Enums\AnimalStatus $status */
    $cls = match ($status) {
        \App\Enums\AnimalStatus::Available  => 'status-available',
        \App\Enums\AnimalStatus::InProcess  => 'status-process',
        \App\Enums\AnimalStatus::Adopted    => 'status-adopted',
        \App\Enums\AnimalStatus::Quarantine => 'status-quarantine',
        \App\Enums\AnimalStatus::Deceased   => 'status-deceased',
    };
@endphp
<span class="status-pill {{ $cls }}">{{ $status->label() }}</span>
