@extends('layouts.admin')

@section('title', 'Prueba de layout admin')
@section('page-title', 'Página de prueba del admin')
@section('breadcrumb')
    <a href="#">Panel</a> <span class="sep">/</span> <span>Prueba</span>
@endsection

@section('content')
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="mb-3">
                        Este contenido se renderiza a través de <code>layouts.admin</code>.
                        Se eliminará cuando se implementen las vistas reales en Fase 1.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-primary">Botón primario</a>
                        <a href="#" class="btn btn-outline-primary">Outline</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
