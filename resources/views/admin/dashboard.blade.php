@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    Panel admin / Dashboard
@endsection

@section('content')
    <div class="row g-4">
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
