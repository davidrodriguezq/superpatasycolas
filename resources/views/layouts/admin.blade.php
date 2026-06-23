<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | @yield('title', 'Super Patas y Colas')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- PWA --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#E8531E">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Super Patas y Colas">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">

    @stack('styles')
</head>
<body>

    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar-head">
            <img src="{{ asset('images/logo.png') }}" alt="" height="34">
            <div class="txt">Super Patas y Colas<small>Panel Admin</small></div>
        </div>

        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="#subAnimals" data-bs-toggle="collapse" role="button"
               class="admin-nav-item {{ request()->routeIs('admin.animals.*') ? 'active' : '' }}"
               aria-expanded="{{ request()->routeIs('admin.animals.*') ? 'true' : 'false' }}">
                <i class="bi bi-heart-pulse"></i> Animales
                <i class="bi bi-chevron-right chev"></i>
            </a>
            <ul class="admin-nav-sub collapse {{ request()->routeIs('admin.animals.*') ? 'show' : '' }}"
                id="subAnimals">
                <li><a href="{{ route('admin.animals.index') }}"
                       class="{{ request()->routeIs('admin.animals.index') ? 'active' : '' }}">Listado</a></li>
                <li><a href="{{ route('admin.animals.create') }}"
                       class="{{ request()->routeIs('admin.animals.create') ? 'active' : '' }}">Registrar nuevo</a></li>
            </ul>

            <a href="#subAdoptions" data-bs-toggle="collapse" role="button"
               class="admin-nav-item {{ request()->routeIs('admin.adoption-requests.*') ? 'active' : '' }}"
               aria-expanded="{{ request()->routeIs('admin.adoption-requests.*') ? 'true' : 'false' }}">
                <i class="bi bi-house-heart"></i> Adopciones
                <i class="bi bi-chevron-right chev"></i>
            </a>
            <ul class="admin-nav-sub collapse {{ request()->routeIs('admin.adoption-requests.*') ? 'show' : '' }}"
                id="subAdoptions">
                <li><a href="{{ route('admin.adoption-requests.index') }}"
                       class="{{ request()->routeIs('admin.adoption-requests.*') ? 'active' : '' }}">Solicitudes</a></li>
            </ul>

            {{-- DESACTIVADO: Módulo de cesión deshabilitado por decisión del cliente --}}
            {{-- <a href="#subCessions" data-bs-toggle="collapse" role="button"
               class="admin-nav-item {{ request()->routeIs('admin.cession-requests.*') ? 'active' : '' }}"
               aria-expanded="{{ request()->routeIs('admin.cession-requests.*') ? 'true' : 'false' }}">
                <i class="bi bi-box-arrow-in-right"></i> Cesiones
                <i class="bi bi-chevron-right chev"></i>
            </a>
            <ul class="admin-nav-sub collapse {{ request()->routeIs('admin.cession-requests.*') ? 'show' : '' }}"
                id="subCessions">
                <li><a href="{{ route('admin.cession-requests.index') }}"
                       class="{{ request()->routeIs('admin.cession-requests.*') ? 'active' : '' }}">Solicitudes</a></li>
            </ul> --}}

            <a href="#subFollowup" data-bs-toggle="collapse" role="button"
               class="admin-nav-item {{ request()->routeIs('admin.followups.*') ? 'active' : '' }}"
               aria-expanded="{{ request()->routeIs('admin.followups.*') ? 'true' : 'false' }}">
                <i class="bi bi-clipboard-check"></i> Seguimiento
                <i class="bi bi-chevron-right chev"></i>
            </a>
            <ul class="admin-nav-sub collapse {{ request()->routeIs('admin.followups.*') ? 'show' : '' }}"
                id="subFollowup">
                <li><a href="{{ route('admin.followups.index') }}"
                       class="{{ request()->routeIs('admin.followups.index') && !request()->filled('critical') ? 'active' : '' }}">Registros</a></li>
                <li><a href="{{ route('admin.followups.index', ['critical' => 1]) }}"
                       class="{{ request()->routeIs('admin.followups.index') && request()->filled('critical') ? 'active' : '' }}">Alertas críticas</a></li>
            </ul>

            <a href="{{ route('admin.blog-posts.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.blog-posts.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> Blog
            </a>

            @php $sidebarUnread = auth()->user()->unreadNotifications()->count(); @endphp
            <a href="{{ route('admin.notifications.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                <i class="bi bi-bell"></i> Notificaciones
                @if($sidebarUnread > 0)
                    <span class="badge rounded-pill bg-danger ms-auto" style="font-size: .68rem;">
                        {{ $sidebarUnread > 99 ? '99+' : $sidebarUnread }}
                    </span>
                @endif
            </a>

            @role('admin')
                <div class="admin-nav-group-label">Administración</div>
                <a href="{{ route('admin.users.index') }}"
                   class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Usuarios
                </a>
                <div class="admin-sidebar-sep"></div>
                <a href="{{ route('admin.settings.edit') }}"
                   class="admin-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> Configuración
                </a>
            @endrole
        </nav>
    </aside>
    <div class="admin-sidebar-backdrop" id="adminBackdrop"></div>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="hamburger" id="adminToggle" aria-label="Abrir menú">
                <i class="bi bi-list"></i>
            </button>
            <div class="spacer"></div>

            @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
            <a href="{{ route('admin.notifications.index') }}"
               class="topbar-btn position-relative text-decoration-none"
               aria-label="Notificaciones">
                <i class="bi bi-bell"></i>
                @if($unreadCount > 0)
                    <span id="notification-badge"
                          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                          style="font-size: 10px; min-width: 18px;">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @else
                    <span id="notification-badge"
                          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                          style="font-size: 10px; min-width: 18px; display: none;">0</span>
                @endif
            </a>

            <div class="dropdown">
                <button class="user-chip" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</span>
                    <span>{{ auth()->user()->name ?? 'Usuario' }}</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">Mi perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <div class="admin-content">
            @include('components.alert')

            @hasSection('page-title')
                <div class="admin-page-title">
                    <div>
                        @hasSection('breadcrumb')
                            <div class="admin-breadcrumb">@yield('breadcrumb')</div>
                        @endif
                        <h1>@yield('page-title')</h1>
                    </div>
                    @yield('page-actions')
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const sb = document.getElementById('adminSidebar');
            const bd = document.getElementById('adminBackdrop');
            const tg = document.getElementById('adminToggle');
            if (!sb || !tg) return;
            const open  = () => { sb.classList.add('open');    bd.classList.add('show'); };
            const close = () => { sb.classList.remove('open'); bd.classList.remove('show'); };
            tg.addEventListener('click', open);
            bd.addEventListener('click', close);
        })();

        (function () {
            function updateNotificationBadge() {
                fetch('{{ route("admin.notifications.unread-count") }}')
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        var badge = document.getElementById('notification-badge');
                        if (!badge) return;
                        if (data.count > 0) {
                            badge.textContent = data.count > 99 ? '99+' : data.count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    })
                    .catch(function () {});
            }
            setInterval(updateNotificationBadge, 60000);
        })();
    </script>
    @stack('scripts')

    {{-- PWA: Service Worker --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('SW registrado:', registration.scope);
                    })
                    .catch((error) => {
                        console.log('SW error:', error);
                    });
            });
        }
    </script>
</body>
</html>
