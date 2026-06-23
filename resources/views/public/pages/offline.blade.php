@extends('layouts.public')

@section('title', 'Sin conexión — Super Patas y Colas')
@section('meta-description', 'No hay conexión a internet disponible.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center py-5">
            <i class="bi bi-wifi-off" style="font-size: 64px; color: var(--spyc-naranja);"></i>
            <h2 class="mt-4 mb-3">Sin conexión a internet</h2>
            <p class="text-muted mb-4">
                Parece que no tienes conexión a internet. Verifica tu conexión y vuelve a intentarlo.
            </p>
            <button class="btn btn-primary px-4" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise me-2"></i>Reintentar
            </button>
        </div>
    </div>
</div>
@endsection
