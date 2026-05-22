@extends('layouts.admin')

@section('title', 'Notificaciones')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="sep">›</span> Notificaciones
@endsection

@section('page-title', 'Notificaciones')

@section('page-actions')
    @if(auth()->user()->unreadNotifications()->count() > 0)
        <form method="POST" action="{{ route('admin.notifications.mark-all-read') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-check2-all me-1"></i> Marcar todas como leídas
            </button>
        </form>
    @endif
@endsection

@section('content')

@if($notifications->isEmpty())
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body py-5">
            <i class="bi bi-bell-slash" style="font-size: 3rem; color: #c5bcaf;"></i>
            <p class="mt-3 mb-0 text-muted fs-5">No tienes notificaciones</p>
        </div>
    </div>
@else
    <div class="list-group shadow-sm" style="border-radius: 12px; overflow: hidden;">
        @foreach($notifications as $notification)
            @php
                $data  = $notification->data;
                $read  = $notification->read_at !== null;
                $color = $data['color'] ?? 'secondary';
                $icon  = $data['icon'] ?? 'bi-bell';
                $colorMap = [
                    'primary' => ['bg' => '#E8531E', 'light' => '#FCEAE0'],
                    'danger'  => ['bg' => '#DC3545', 'light' => '#FCEAEA'],
                    'info'    => ['bg' => '#17A2B8', 'light' => '#D9F1F5'],
                    'success' => ['bg' => '#28A745', 'light' => '#E6F4EA'],
                    'warning' => ['bg' => '#F5A623', 'light' => '#FFF3CD'],
                ];
                $colors = $colorMap[$color] ?? ['bg' => '#8a7f72', 'light' => '#F8F9FA'];
            @endphp
            <a href="{{ route('admin.notifications.mark-read', $notification->id) }}"
               class="list-group-item list-group-item-action d-flex align-items-start gap-3 py-3 px-4 text-decoration-none"
               style="background: {{ $read ? '#fff' : '#FFF5EE' }}; border-color: #f3ece1;">
                {{-- Ícono --}}
                <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle"
                     style="width: 42px; height: 42px; background: {{ $colors['light'] }}; color: {{ $colors['bg'] }};">
                    <i class="bi {{ $icon }}" style="font-size: 1.1rem;"></i>
                </div>

                {{-- Contenido --}}
                <div class="flex-grow-1 min-width-0">
                    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                        <strong class="text-dark" style="font-size: .92rem;">
                            {{ $data['title'] ?? 'Notificación' }}
                            @if(! $read)
                                <span class="badge rounded-pill bg-primary ms-1" style="font-size: .65rem; vertical-align: middle;">Nueva</span>
                            @endif
                        </strong>
                        <span class="text-muted flex-shrink-0" style="font-size: .78rem;">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="mb-0 mt-1 text-secondary" style="font-size: .88rem; line-height: 1.45;">
                        {{ $data['message'] ?? '' }}
                    </p>
                </div>

                {{-- Indicador no leída --}}
                @if(! $read)
                    <div class="flex-shrink-0 d-flex align-items-center">
                        <span class="rounded-circle"
                              style="width: 9px; height: 9px; background: #E8531E; display: block;"></span>
                    </div>
                @endif
            </a>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
@endif

@endsection
