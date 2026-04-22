<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | @yield('title', 'Super Patas y Colas')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>

    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar-head">
            <img src="{{ asset('images/logo.png') }}" alt="" height="34">
            <div class="txt">Super Patas y Colas<small>Panel Admin</small></div>
        </div>

        <nav class="admin-nav">
            {{-- rutas reales del panel admin — se activan en F1-T04 --}}
            <a href="{{ url('/admin') }}"
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
                <li><a href="{{ url('/admin/animales') }}"
                       class="{{ request()->routeIs('admin.animals.index') ? 'active' : '' }}">Listado</a></li>
                <li><a href="{{ url('/admin/animales/nuevo') }}"
                       class="{{ request()->routeIs('admin.animals.create') ? 'active' : '' }}">Registrar nuevo</a></li>
            </ul>

            <a href="#subAdoptions" data-bs-toggle="collapse" role="button"
               class="admin-nav-item {{ request()->routeIs('admin.adoptions.*') ? 'active' : '' }}"
               aria-expanded="{{ request()->routeIs('admin.adoptions.*') ? 'true' : 'false' }}">
                <i class="bi bi-house-heart"></i> Adopciones
                <i class="bi bi-chevron-right chev"></i>
            </a>
            <ul class="admin-nav-sub collapse {{ request()->routeIs('admin.adoptions.*') ? 'show' : '' }}"
                id="subAdoptions">
                <li><a href="{{ url('/admin/adopciones') }}"
                       class="{{ request()->routeIs('admin.adoptions.index') ? 'active' : '' }}">Solicitudes</a></li>
                <li><a href="{{ url('/admin/adopciones/historial') }}"
                       class="{{ request()->routeIs('admin.adoptions.history') ? 'active' : '' }}">Historial</a></li>
            </ul>

            <a href="{{ url('/admin/cesiones') }}"
               class="admin-nav-item {{ request()->routeIs('admin.cessions.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-right"></i> Cesiones
            </a>

            <a href="#subFollowup" data-bs-toggle="collapse" role="button"
               class="admin-nav-item {{ request()->routeIs('admin.followups.*') ? 'active' : '' }}"
               aria-expanded="{{ request()->routeIs('admin.followups.*') ? 'true' : 'false' }}">
                <i class="bi bi-clipboard-check"></i> Seguimiento
                <i class="bi bi-chevron-right chev"></i>
            </a>
            <ul class="admin-nav-sub collapse {{ request()->routeIs('admin.followups.*') ? 'show' : '' }}"
                id="subFollowup">
                <li><a href="{{ url('/admin/seguimiento') }}"
                       class="{{ request()->routeIs('admin.followups.index') ? 'active' : '' }}">Registros</a></li>
                <li><a href="{{ url('/admin/seguimiento/alertas') }}"
                       class="{{ request()->routeIs('admin.followups.alerts') ? 'active' : '' }}">Alertas</a></li>
            </ul>

            <a href="{{ url('/admin/blog') }}"
               class="admin-nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> Blog
            </a>

            @role('admin')
                <div class="admin-nav-group-label">Administración</div>
                <a href="{{ url('/admin/usuarios') }}"
                   class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Usuarios
                </a>
                <div class="admin-sidebar-sep"></div>
                <a href="{{ url('/admin/configuracion') }}"
                   class="admin-nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
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

            <button class="topbar-btn" aria-label="Notificaciones">
                <i class="bi bi-bell"></i>
                <span class="dot-badge"></span>
            </button>

            <div class="dropdown">
                <button class="user-chip" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</span>
                    <span>{{ auth()->user()->name ?? 'Usuario' }}</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    {{-- ruta real: route('profile') — se activa en F1-T06 --}}
                    <li><a class="dropdown-item" href="{{ url('/perfil') }}">Mi perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        {{-- ruta real: route('logout') — se activa en F1-T02 --}}
                        <form method="POST" action="{{ url('/logout') }}">
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
    </script>
    @stack('scripts')
</body>
</html>
