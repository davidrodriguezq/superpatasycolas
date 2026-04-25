<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta-description', 'Super Patas y Colas — Albergue de animales en San Martín de Porres, Lima. Adopción responsable de perros y gatos.')">
    <title>@yield('title', 'Super Patas y Colas')</title>

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'Super Patas y Colas')">
    <meta property="og:description" content="@yield('meta-description', 'Albergue de animales en San Martín de Porres, Lima.')">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_PE">
    <meta property="og:site_name" content="Super Patas y Colas">
    @stack('og-image')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg bg-white pub-nav">
        <div class="container">
            <a class="navbar-brand pub-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Super Patas y Colas" height="40" class="pub-brand-mark">
                <span class="pub-brand-text">Super Patas y Colas<span>Albergue · SMP, Lima</span></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navPublic" aria-controls="navPublic"
                    aria-expanded="false" aria-label="Abrir navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navPublic">
                <ul class="navbar-nav mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                           href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}"
                           href="{{ route('catalog.index') }}">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                           href="{{ route('about') }}">Sobre nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                           href="{{ route('blog.index') }}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                           href="{{ route('contact') }}">Contacto</a>
                    </li>
                </ul>

                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3">Registrarse</a>
                    @endguest
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm px-3 dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">Mi perfil</a></li>
                                @role('adopter')
                                    <li><a class="dropdown-item" href="{{ route('adoption.my-requests') }}">Mis solicitudes</a></li>
                                @endrole
                                @role('surrenderer')
                                    <li><a class="dropdown-item" href="{{ route('cession.my-requests') }}">Mis cesiones</a></li>
                                @endrole
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @include('components.alert')
        @yield('content')
    </main>

    <footer class="pub-footer mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="" height="36"
                             class="bg-white rounded-circle p-1">
                        <span class="ms-2 fw-bold text-white">Super Patas y Colas</span>
                    </div>
                    <p class="footer-desc">
                        Damos hogar a perros y gatos rescatados en San Martín de Porres desde 2019.
                        Cada adopción responsable cambia dos vidas.
                    </p>
                </div>
                <div class="col-6 col-md-3">
                    <h6>Enlaces rápidos</h6>
                    <a href="{{ route('home') }}">Inicio</a>
                    <a href="{{ route('catalog.index') }}">Catálogo</a>
                    <a href="{{ route('about') }}">Sobre nosotros</a>
                    <a href="{{ route('blog.index') }}">Blog</a>
                    <a href="{{ route('contact') }}">Contacto</a>
                </div>
                <div class="col-6 col-md-5">
                    <h6>Contáctanos</h6>
                    <ul class="list-unstyled footer-contact mb-0">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Av. Los Rescatados 1234, San Martín de Porres, Lima</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <span>+51 999 000 000</span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <span>contacto@superpatasycolas.pe</span>
                        </li>
                        <li>
                            <i class="bi bi-clock-fill"></i>
                            <span>Visitas: sáb y dom · 10:00 – 17:00</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pub-footer-bottom">
                © {{ date('Y') }} Super Patas y Colas. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
