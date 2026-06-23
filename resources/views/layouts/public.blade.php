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

    {{-- PWA --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#E8531E">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Super Patas y Colas">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg bg-white pub-nav">
        <div class="container">
            <a class="navbar-brand pub-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="{{ $settings['shelter_name'] ?? 'Super Patas y Colas' }}" height="40" class="pub-brand-mark">
                <span class="pub-brand-text">{{ $settings['shelter_name'] ?? 'Super Patas y Colas' }}<span>{{ $settings['shelter_slogan'] ?? 'Albergue · SMP, Lima' }}</span></span>
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
                                {{-- DESACTIVADO: Módulo de cesión deshabilitado por decisión del cliente --}}
                                {{-- @role('surrenderer')
                                    <li><a class="dropdown-item" href="{{ route('cession.my-requests') }}">Mis cesiones</a></li>
                                @endrole --}}
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
            <div class="row g-4 justify-content-between">
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="" height="36"
                             class="bg-white rounded-circle p-1">
                        <span class="ms-2 fw-bold text-white">{{ $settings['shelter_name'] ?? 'Super Patas y Colas' }}</span>
                    </div>
                    <p class="footer-desc">
                        {{ $settings['shelter_description'] ?? 'Damos hogar a perros y gatos rescatados en San Martín de Porres desde 2019. Cada adopción responsable cambia dos vidas.' }}
                    </p>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <h6>Enlaces rápidos</h6>
                    <a href="{{ route('home') }}">Inicio</a>
                    <a href="{{ route('catalog.index') }}">Catálogo</a>
                    <a href="{{ route('about') }}">Sobre nosotros</a>
                    <a href="{{ route('blog.index') }}">Blog</a>
                    <a href="{{ route('contact') }}">Contacto</a>
                    <a href="{{ route('privacy') }}">Política de privacidad</a>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <h6>Contáctanos</h6>
                    <ul class="list-unstyled footer-contact mb-0">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>{{ ($settings['shelter_district'] ?? 'San Martín de Porres') . ', ' . ($settings['shelter_city'] ?? 'Lima, Perú') }}</span>
                        </li>
                        @if(!empty($settings['shelter_phone']))
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <span>{{ $settings['shelter_phone'] }}</span>
                        </li>
                        @endif
                        @if(!empty($settings['shelter_email']))
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <span>{{ $settings['shelter_email'] }}</span>
                        </li>
                        @endif
                        @if(!empty($settings['shelter_schedule']))
                        <li>
                            <i class="bi bi-clock-fill"></i>
                            <span>{{ $settings['shelter_schedule'] }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="pub-footer-bottom">
                © {{ date('Y') }} {{ $settings['shelter_name'] ?? 'Super Patas y Colas' }}. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    {{-- PWA Install Banner --}}
    <div id="pwa-install-banner" style="display: none; position: fixed; bottom: 0; left: 0; right: 0; background-color: #E8531E; color: #fff; padding: 12px 20px; z-index: 9999; box-shadow: 0 -2px 8px rgba(0,0,0,0.2);">
        <div class="d-flex align-items-center justify-content-between" style="max-width: 800px; margin: 0 auto;">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-download fs-4"></i>
                <div>
                    <strong>Instalar Super Patas y Colas</strong>
                    <div style="font-size: 13px; opacity: 0.9;">Accede más rápido desde tu pantalla de inicio</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button id="pwa-install-btn" class="btn btn-light btn-sm" style="color: #E8531E; font-weight: bold;">
                    Instalar
                </button>
                <button id="pwa-dismiss-btn" class="btn btn-outline-light btn-sm">
                    Ahora no
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/auto-search.js') }}"></script>
    @stack('scripts')

    {{-- PWA: Service Worker y banner de instalación --}}
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

        let deferredPrompt;
        const installBanner = document.getElementById('pwa-install-banner');
        const installBtn = document.getElementById('pwa-install-btn');
        const dismissBtn = document.getElementById('pwa-dismiss-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (!sessionStorage.getItem('pwa-dismissed')) {
                installBanner.style.display = 'block';
            }
        });

        if (installBtn) {
            installBtn.addEventListener('click', () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(() => {
                        deferredPrompt = null;
                        installBanner.style.display = 'none';
                    });
                }
            });
        }

        if (dismissBtn) {
            dismissBtn.addEventListener('click', () => {
                installBanner.style.display = 'none';
                sessionStorage.setItem('pwa-dismissed', 'true');
            });
        }

        window.addEventListener('appinstalled', () => {
            installBanner.style.display = 'none';
            deferredPrompt = null;
        });
    </script>
</body>
</html>
