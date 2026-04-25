@extends('layouts.public')

@section('title', 'Contacto — Super Patas y Colas')
@section('meta-description', '¿Tienes dudas o quieres colaborar? Escríbenos. Super Patas y Colas, albergue animal en San Martín de Porres, Lima.')

@section('content')

{{-- Hero --}}
<section class="spyc-bg-rosa py-4 py-md-5">
    <div class="container text-center">
        <h1 class="fw-bold mb-2" style="color:#2a2622; font-size:clamp(1.4rem,4vw,2rem);">
            Contáctanos
        </h1>
        <p class="text-muted mb-0">¿Tienes dudas o quieres colaborar? Escríbenos.</p>
    </div>
</section>

<section class="py-5">
    <div class="container" style="max-width:880px;">

        @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="row g-4">

            {{-- Columna izquierda: info de contacto --}}
            <div class="col-md-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4" style="color:#2a2622;">Información de contacto</h5>

                        <ul class="list-unstyled mb-4" style="line-height:2.2;">
                            <li class="d-flex gap-3 align-items-start">
                                <i class="bi bi-geo-alt-fill spyc-text-naranja mt-1 flex-shrink-0"></i>
                                <span class="text-muted small">Av. Los Rescatados 1234, San Martín de Porres, Lima, Perú</span>
                            </li>
                            <li class="d-flex gap-3 align-items-start">
                                <i class="bi bi-telephone-fill spyc-text-naranja mt-1 flex-shrink-0"></i>
                                <span class="text-muted small">+51 999 000 000</span>
                            </li>
                            <li class="d-flex gap-3 align-items-start">
                                <i class="bi bi-envelope-fill spyc-text-naranja mt-1 flex-shrink-0"></i>
                                <span class="text-muted small">contacto@superpatasycolas.pe</span>
                            </li>
                            <li class="d-flex gap-3 align-items-start">
                                <i class="bi bi-clock-fill spyc-text-naranja mt-1 flex-shrink-0"></i>
                                <span class="text-muted small">Visitas: sáb y dom · 10:00 – 17:00</span>
                            </li>
                        </ul>

                        <hr style="border-color:#f0e8de;">

                        <div class="mt-3">
                            <p class="small text-muted mb-2">Síguenos en redes sociales</p>
                            <div class="d-flex gap-2">
                                <a href="{{ url('#') }}"
                                   class="spyc-social-btn"
                                   title="Facebook"
                                   aria-label="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="{{ url('#') }}"
                                   class="spyc-social-btn"
                                   title="Instagram"
                                   aria-label="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Columna derecha: formulario --}}
            <div class="col-md-7">
                <div class="card border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4" style="color:#2a2622;">Envíanos un mensaje</h5>

                        <form method="POST" action="{{ route('contact.send') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="contact_name" class="form-label small fw-semibold" style="color:#4a4138;">
                                    Nombre completo <span class="text-danger">*</span>
                                </label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text"
                                           id="contact_name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Tu nombre completo"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="contact_email" class="form-label small fw-semibold" style="color:#4a4138;">
                                    Correo electrónico <span class="text-danger">*</span>
                                </label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email"
                                           id="contact_email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="tu@correo.com"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="contact_subject" class="form-label small fw-semibold" style="color:#4a4138;">
                                    Asunto <span class="text-danger">*</span>
                                </label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                                    <input type="text"
                                           id="contact_subject"
                                           name="subject"
                                           value="{{ old('subject') }}"
                                           class="form-control @error('subject') is-invalid @enderror"
                                           placeholder="¿En qué podemos ayudarte?"
                                           required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="contact_message" class="form-label small fw-semibold" style="color:#4a4138;">
                                    Mensaje <span class="text-danger">*</span>
                                </label>
                                <textarea id="contact_message"
                                          name="message"
                                          rows="5"
                                          class="form-control @error('message') is-invalid @enderror"
                                          placeholder="Escríbenos tu consulta, comentario o propuesta..."
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-send me-2"></i>Enviar mensaje
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.spyc-social-btn {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: var(--spyc-rosa);
    color: var(--spyc-naranja);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all .15s ease;
}
.spyc-social-btn:hover {
    background: var(--spyc-naranja);
    color: #fff;
}
</style>
@endpush
