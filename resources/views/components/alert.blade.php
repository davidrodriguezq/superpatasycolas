{{-- Componente de alertas flash reutilizable.
     Renderiza automáticamente los mensajes de sesión (success / error / warning / info).
     Se auto-cierra después de 5 segundos. --}}

@php
    $flash = [
        'success' => ['class' => 'alert-success', 'icon' => 'bi-check-circle-fill'],
        'error'   => ['class' => 'alert-danger',  'icon' => 'bi-x-circle-fill'],
        'warning' => ['class' => 'alert-warning', 'icon' => 'bi-exclamation-triangle-fill'],
        'info'    => ['class' => 'alert-info',    'icon' => 'bi-info-circle-fill'],
    ];
@endphp

@foreach ($flash as $key => $meta)
    @if (session($key))
        <div class="container pt-3">
            <div class="alert {{ $meta['class'] }} alert-dismissible fade show spyc-alert" role="alert">
                <i class="bi {{ $meta['icon'] }} me-2"></i>
                {{ session($key) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="container pt-3">
        <div class="alert alert-danger alert-dismissible fade show spyc-alert" role="alert">
            <i class="bi bi-exclamation-octagon-fill me-2"></i>
            <strong>Hay errores en el formulario:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    </div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.spyc-alert').forEach(function (el) {
            setTimeout(function () {
                bootstrap.Alert.getOrCreateInstance(el).close();
            }, 5000);
        });
    });
</script>
@endpush
