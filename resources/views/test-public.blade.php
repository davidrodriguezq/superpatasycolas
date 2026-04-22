@extends('layouts.public')

@section('title', 'Página de prueba · Super Patas y Colas')

@section('content')
    <div class="container py-5">
        <h1 class="display-5 fw-bold" style="color:#2a2622;">Página de prueba del portal público</h1>
        <p class="lead text-secondary">
            Este contenido se renderiza a través de <code>layouts.public</code>.
            Se eliminará cuando se implementen las vistas reales en Fase 1 y Fase 3.
        </p>
        <div class="d-flex gap-2 flex-wrap mt-4">
            <a href="#" class="btn btn-primary px-4">Botón primario</a>
            <a href="#" class="btn btn-outline-primary px-4">Botón outline</a>
        </div>
    </div>
@endsection
