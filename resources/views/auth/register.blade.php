@extends('layouts.app')
@section('title','Registrarse - Spotlight')
@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background-color: var(--vs-bg-color);">
    <div class="vs-card border-0" style="width: 100%; max-width: 900px; border-radius: var(--vs-radius-xl); overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);">
        <div class="row g-0">
            <!-- Left Side: Branding -->
            <div class="col-md-5 d-none d-md-block position-relative overflow-hidden" style="background: radial-gradient(circle, #2934ff, #111566);">
                <div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-25 z-1"></div>
                <!-- Animated SVG Background -->
                <div class="position-absolute top-0 start-0 w-100 h-100 z-0 login-bg-svg" style="opacity: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 1080" preserveAspectRatio="none" style="width: 100%; height: 100%; display: block;">
                      <defs />
                      <linearGradient id="SVGID_1_" x1="2880" x2="2880" y1="909.66" y2="170.6" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#1742ff" />
                        <stop offset="1" stop-color="#22dd8a" />
                      </linearGradient>

                      <g>
                        <g class="g">
                          <path class="path" fill="url(#SVGID_1_)" d="m1920 538.5 8.6-.4h8.6l8.6.3 4.3.3 4.3.4c11.4 1.1 22.8 2.9 34 5.4 22.5 5 44.3 12.4 65.6 21a730.8 730.8 0 0 1 62.3 28.7c20.3 10.3 40.3 21 60.2 31.7l29.8 15.9c9.9 5.2 19.9 10.3 29.9 15.3a727 727 0 0 0 60.7 27.2 360.6 360.6 0 0 0 62.6 18.3c10.6 2 21.2 3.4 31.8 4l8 .3 7.7-.1c2.6-.2 5.1-.2 7.7-.5l3.9-.4 1.9-.2 1.9-.3a177 177 0 0 0 30.8-7.4c10.2-3.3 20.2-7.5 30.1-12.1a448 448 0 0 0 57.5-33.2c37.2-24.9 72.1-53.7 106.7-82.8 34.6-29.1 68.7-59.1 105.7-85.8 9.3-6.6 18.7-13.1 28.5-19.1 9.8-6.1 19.8-11.7 30.3-16.7s21.3-9.4 32.7-12.6c11.4-3.2 23-6.2 34.9-8.4 11.9-2.2 24.1-3.6 36.3-4l6.1-.1 6.1.1 12.3.5c16.3 1.2 32.7 3.4 48.7 6.6 16 3.2 31.7 7.5 46.8 12.6a451.6 451.6 0 0 1 80 36.6c24.6 14.8 47.7 32 68.4 51.5 10.4 9.8 20.1 20.2 29.3 31.2a472 472 0 0 1 45.4 68c12.2 24.2 21.5 50.1 27.2 76.9 2.9 13.4 4.8 27.2 5.6 41l.2 5.2.1 5.2c.1 6.9-.2 13.9-.9 20.9-1.3 14-3.8 27.9-7.4 41.6a386 386 0 0 1-27.2 76 387 387 0 0 1-45.7 68.5c-9.3 10.8-19.2 21.1-29.7 30.8-21 19.4-44.4 36.2-69.4 49.9a489.1 489.1 0 0 1-82.5 34c-14.4 4.2-29.2 7.3-44 9.6-14.8 2.3-29.8 3.5-44.8 3.5h-11.4l-11.4-.6c-15.1-1.3-30.2-3.8-44.8-7.5-14.6-3.7-29-8.4-42.6-14a511.6 511.6 0 0 1-72.3-38.6c-22-15-41.8-32.9-59-53-17.2-20.1-31.5-42.4-42.4-66.2a405.5 405.5 0 0 1-21-65.4c-4.8-22.9-7-46.7-6.2-70.5.4-11.9 1.5-23.7 3.3-35.4 1.8-11.7 4.2-23.2 7.3-34.5a350 350 0 0 1 20-56.6 348.6 348.6 0 0 1 31.8-51.4c12-15.7 25.5-30.2 40.2-43.2a343.3 343.3 0 0 1 50-36.4c18-10.4 37.1-18.7 57.1-24.8 10-3 20.3-5.5 30.7-7.2 10.4-1.7 21-2.6 31.6-2.6h7.9l7.9.4c10.5.8 21 2.3 31.2 4.4 10.2 2.1 20.2 5 30 8.3a258.8 258.8 0 0 1 53 25.6c16 10.3 30.8 22.5 44.1 36l19.2 21.2 17.1 22.9c10.8 15.6 20 32.5 27 50.3a277.6 277.6 0 0 1 14 56c1.6 10 2.2 20.2 2.1 30.3 0 5-.3 10-.7 15l-1.3 14.8c-.8 9.8-2.6 19.5-5 29a288.6 288.6 0 0 1-13.8 41 292 292 0 0 1-22.4 41c-8.7 12.9-18.7 24.8-29.8 35.6-22.2 21.6-48.4 38.6-77.2 49a341.6 341.6 0 0 1-42.5 11c-14.6 2.3-29.4 3.3-44.1 3.1h-11l-11-.6-10.9-1-21.7-3c-14.4-2.7-28.5-6.5-42-11.3s-26.6-10.6-38.9-17.5a435 435 0 0 1-65.7-46c-19.5-17.4-36.4-37.4-50.5-59a430.7 430.7 0 0 1-36.7-73.4c-8.9-25.5-14.3-52.2-16.1-79.3-.9-13.6-1-27.2-.3-40.8.7-13.6 2-27 4.1-40.4s5-26.4 8.7-39.2a488.2 488.2 0 0 1 45.4-100c19-30.8 42-59.1 68.3-84 26.3-24.9 55.8-46 87.7-62.8 16-8.4 32.4-15.8 49.3-21.8 16.9-6 34.3-11 51.9-14.6 17.6-3.6 35.5-6 53.6-7 9.1-.5 18.2-.7 27.3-.6h13.6l13.6.4 13.5.7c17.9 1.4 35.8 4.2 53.3 8.3 17.5 4.1 34.7 9.4 51.1 16 16.4 6.6 32.3 14.5 47.4 23.4l22.1 13.8 21.3 14.8c13.8 10 27.1 20.6 39.7 31.8 12.6 11.2 24.5 23 35.7 35.2a759.5 759.5 0 0 1 59.8 77.8c18 27.5 33.6 56.6 46.5 86.8 6.4 15.1 12.1 30.5 17.1 46 5 15.5 9.1 31.2 12.5 47 6.8 31.6 11.2 64 12.9 96.6 1.7 32.6.8 65.5-2.8 98l-2 16.1-2.4 16c-1.8 10.6-4.1 21-6.7 31.4-5.2 20.8-12.1 41-20.4 60.7-16.6 39.4-38.6 76.4-65 109.8a760.6 760.6 0 0 1-96 99.4c-35 29.3-73.6 54-114.7 73.5-20.5 9.7-41.7 18.2-63.3 25-21.6 6.8-43.7 12-66 15.5l-33.8 4.2h-34l-34-1.2-16.9-1.1c-11.2-1.1-22.4-2.6-33.5-4.5-22.2-3.8-44-9.5-65.1-16.7l-30.8-11.8c-10.1-4.2-20.1-8.7-29.8-13.7a740.3 740.3 0 0 1-54.8-31l-25.5-17.1c-8.3-5.9-16.4-12-24.2-18.4l-11.5-9.6-11.1-10c-14.5-13.6-28.3-27.9-41-43-25.4-30.2-47.5-63-65.7-98-18.2-35-32.3-71.9-42-110-4.8-19.1-8.6-38.4-11.1-58-.5-4.9-.9-9.8-1.2-14.7l-.4-14.8c-.3-19.7 1.1-39.6 4-59.2 5.8-39.2 16.9-77.5 32.7-113.8 15.8-36.3 36.2-70.5 60.5-101.8a719.5 719.5 0 0 1 82.2-85c30.2-25.4 63.3-47.1 98.4-64 35.1-16.9 71.8-29.4 109.4-37a760.3 760.3 0 0 1 113.9-8.4c37.9 1 75.3 7.8 111.4 19.9 36.1 12.1 70.5 29.5 102.3 51 15.9 10.8 31.1 22.5 45.4 35 14.3 12.5 28 25.8 40.8 40l18.4 21.8 17.2 22.8c11 15.4 21.3 31.4 30.6 47.9a785.4 785.4 0 0 1 48 107.5 798 798 0 0 1 25.5 119.5l2 20.3 1.3 20.4c1.3 27.2.5 54.6-2.5 81.7-6 54.2-20.1 107.2-41.2 157.4a841.5 841.5 0 0 1-73.1 138.3c-28.3 42-61.9 80-99.7 113.2a853.4 853.4 0 0 1-125 89c-44 24.3-90.8 43-139 55.4a867.7 867.7 0 0 1-146.5 20.1l-18.4.5h-18.5l-37-1.1c-24.6-1.5-49-4.5-73-8.8-48-8.6-94.6-23.7-138.8-44.5a862.6 862.6 0 0 1-123-74c-38.6-28.3-74-60.8-105-96.8s-58.4-75.7-81-118c-22.6-42.3-40.4-86.8-52.6-132.8-6.1-23-11.1-46.3-14.8-69.8l-4.5-35.3c-.3-5.9-.6-11.8-.8-17.7a877.8 877.8 0 0 1 4.7-142.6c9.8-47 25-92.6 44.9-136.1s44.6-84.6 73-122.9c28.4-38.3 60.5-73.4 95.5-104.7s73.3-59 113.5-82.6a855 855 0 0 1 129-57.5c22.3-7.5 45.1-13.8 68.3-18.8 23.2-5 46.7-8.8 70.4-11.2l35.8-2.6 36-.8c24-.2 48.2 1 72 3.5 47.6 5 94.3 15.6 139 30.7 44.7 15.1 87.5 35 127 59.1s76.3 52.8 109.8 85.5 63.3 69.2 89.6 107.5l23.5 36.3 21 37.8c12.7 25.6 23.6 52.1 32.5 79.1a880.8 880.8 0 0 1 20.3 84c5.1 28.5 8.6 57.3 10.3 86.4.8 14.5 1.2 29.1 1.2 43.6l-.6 21.8-.8 21.8c-1.7 29-5.4 58-10.9 86.6-11 57.2-29.3 112.5-54 164.2a893.3 893.3 0 0 1-90 142.1c-34.9 44-74.9 83.5-119 117.2s-92.4 62-142.6 83.8c-25.1 10.9-51.1 20.1-77.5 27.5l-39.9 10.1-20.1 4.5-20.2 3.8c-27.1 4.8-54.4 7.9-81.9 9.3-55 2.8-109.9-1-163.2-11-53.3-10-104.8-26.6-153-49.2-48.2-22.6-93.1-51.2-133.4-84.5-40.3-33.3-76.3-71.5-106.6-113.3-30.3-41.8-55.5-87-74.4-134.4s-31.5-96.6-36.6-146.9c-2.5-25.1-3.8-50.5-3.6-75.8.1-12.6.4-25.3 1.1-37.9l1.7-37.7c1.7-25 4.7-50 9-74.7 8.6-49.4 22.8-97.4 41.9-143.1 19.1-45.7 42.8-88.8 70.5-128.5A952.1 952.1 0 0 1 316.5 142c35-36 73.5-68.3 114.7-96A911 911 0 0 1 564.3 2l34.8-14.7c11.7-4.6 23.5-8.9 35.5-13l35.8-11.4c24.1-7.1 48.6-13 73.4-17.7a935.9 935.9 0 0 1 150.3-15c50.3 1.6 100.2 8.3 148.8 19.8 48.6 11.5 95.8 27.5 140.4 47.6 44.6 20.1 86.8 44 125.4 71.3 38.6 27.3 74 58.1 105 91.6A928.7 928.7 0 0 1 1461.6 195c32 40.8 59.8 84.7 82.6 130.6a958 958 0 0 1 65.5 190.5c15.2 65.4 23.6 132.3 24.8 199.7.6 33.7.1 67.4-1.6 101-.8 16.8-2 33.6-3.4 50.3l-2.4 25.1-2.9 25c-5 41.5-12.6 82.5-22.9 122.9a944.5 944.5 0 0 1-139 285.8c-32.9 44-70 84.5-110.6 120.7s-84.3 68.1-130.7 94.6a968.6 968.6 0 0 1-144.3 64.6l-37.4 12c-12.6 3.8-25.3 7.3-38.1 10.4-25.6 6.3-51.5 11.5-77.5 15.6a959.9 959.9 0 0 1-157.3 12c-52.6-3.1-104.7-12-155-26a978.7 978.7 0 0 1-146.4-56.5c-47.3-24.1-92-53.5-133-87s-77.8-71.7-110.8-113.6c-33-41.9-60.8-87.3-82.5-134.8A962.3 962.3 0 0 1 106 701c-13.6-50.6-22-102.5-25-154.6-1.5-26.1-1.9-52.3-1.1-78.4.4-13 .9-26.1 1.7-39.1.8-13 1.9-26 3.2-38.9l4.5-38.6c4.6-25.6 10.7-50.8 18.2-75.7C122.6 226 151.7 178 186.8 133A1020 1020 0 0 1 292.1 40c19-19.3 39-37.7 59.8-55" />
                        </g>
                      </g>
                    </svg>
                </div>

                <div class="position-relative z-2 d-flex flex-column justify-content-between h-100 p-5 text-white">
                    <div>
                        <a href="{{ route('home') }}" class="text-white text-decoration-none d-inline-block">
                            <img src="{{ asset('images/logo.png') }}" alt="Spotlight" class="vs-brand-logo-lg">
                        </a>
                    </div>
                    <div class="mt-auto">
                        <h2 class="fw-bold mb-3 text-white">Únete a la comunidad.</h2>
                        <p class="text-white opacity-75">Crea tu cuenta y empieza a comprar o vender en la plataforma más confiable.</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Register Form -->
            <div class="col-md-7 p-4 p-md-5 bg-white">
                <div class="text-center d-md-none mb-4">
                    <a href="{{ route('home') }}" class="text-decoration-none d-inline-block">
                        <img src="{{ asset('images/logo.png') }}" alt="Spotlight" class="vs-brand-logo-lg">
                    </a>
                </div>

                <div class="mb-4">
                    <h3 class="fw-bold text-dark">Crea tu cuenta</h3>
                    <p class="text-muted">Completa los campos para registrarte en la plataforma.</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger border-0 d-flex align-items-center" style="background-color: rgba(220, 38, 38, 0.1); color: #dc2626;">
                        <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" id="mainRegisterForm" enctype="multipart/form-data">
                    @csrf
                    <div id="step-1">
                        <div class="mb-3">
                        <label class="form-label text-sm fw-semibold text-dark mb-2">Nombre completo</label>
                        <input type="text" name="name" class="form-control form-control-lg text-sm" placeholder="Tu nombre completo" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-sm fw-semibold text-dark mb-2">Correo electrónico</label>
                        <input type="email" name="email" class="form-control form-control-lg text-sm" placeholder="ejemplo@correo.com" value="{{ old('email') }}" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label text-sm fw-semibold text-dark mb-2">Contraseña</label>
                            <input type="password" name="password" class="form-control form-control-lg text-sm" placeholder="••••••••" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-sm fw-semibold text-dark mb-2">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg text-sm" placeholder="••••••••" required>
                        </div>
                    </div>
                    <input type="hidden" name="role" id="role_input" value="{{ old('role', 'user') }}">

                    <div id="action-buttons-step1">
                        <button type="submit" id="btn-submit-user" class="btn btn-primary btn-lg w-100 fw-semibold shadow-sm mb-3">Registrarse como Usuario</button>
                        <button type="button" id="btn-next-step" class="btn btn-outline-dark btn-lg w-100 fw-semibold mb-4">Soy Empresario (Completar perfil) <i class="bi bi-arrow-right ms-2"></i></button>
                    </div>

                        <div id="google-registration-section">
                            <div class="position-relative mb-4 text-center">
                                <hr class="text-muted opacity-25">
                                <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted text-sm fw-medium">O registrarse con</span>
                            </div>

                            <a href="{{ route('google.redirect') }}" class="btn btn-outline-dark btn-lg w-100 fw-semibold mb-4 d-flex align-items-center justify-content-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                                Google
                            </a>
                        </div>
                        <div class="text-center">
                            <p class="text-muted text-sm mb-0">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Inicia sesión</a></p>
                        </div>
                    </div>

                    <!-- Step 2: Business Fields Container -->
                    <div id="step-2" style="display: none;">
                        <div class="d-flex align-items-center mb-4">
                            <button type="button" id="btn-prev-step" class="btn btn-light rounded-circle p-2 me-3 shadow-sm border" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-arrow-left"></i></button>
                            <h4 class="fw-bold text-dark mb-0 fs-5">Información de tu Negocio</h4>
                        </div>
                        <div id="business-registration-fields" class="mb-4">
                            @include('business.partials.register-form')
                        </div>
                        <button type="submit" id="btn-submit-business" class="btn btn-primary btn-lg w-100 fw-semibold shadow-sm mb-4">Finalizar y Crear cuenta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- GSAP Animation ---
    const tl = gsap.timeline();

    const Line = ($el) => {
      const $paths = $el.querySelectorAll(".path");
      const tl = gsap.timeline();
      const duration = gsap.utils.random(40, 80);
      const y = gsap.utils.random(-250, 250);
      const rotate = gsap.utils.random(-20, 20);
      const scaleXFrom = gsap.utils.random(2, 2.5);
      const scaleXTo = gsap.utils.random(1.5, 1.75);
      const scaleYFrom = gsap.utils.random(1.5, 2);
      const scaleYTo = gsap.utils.random(0.6, 0.7);
      const opacityFrom = gsap.utils.random(0.75, 0.8);
      const opacityTo = gsap.utils.random(0.85, 1);
      const ease = gsap.utils.random([
        "power2.inOut",
        "power3.inOut",
        "power4.inOut",
        "sine.inOut"
      ]);
      tl.to($paths, {
        xPercent: -100,
        duration: duration,
        ease: "none",
        repeat: -1
      });

      tl.fromTo(
        $el,
        {
          y,
          opacity: opacityFrom,
          rotate,
          scaleY: scaleYFrom,
          scaleX: scaleXFrom,
          transformOrigin: "50% 50%"
        },
        {
          y: y * -1,
          opacity: opacityTo,
          rotate: rotate * -1,
          scaleY: scaleYTo,
          scaleX: scaleXTo,
          repeat: -1,
          yoyo: true,
          yoyoEase: ease,
          duration: duration * 0.25,
          ease: ease,
          transformOrigin: "50% 50%"
        },
        0
      );

      tl.seek(gsap.utils.random(10, 20));
    };

    gsap.utils.toArray(".login-bg-svg .g").forEach(($el) => Line($el));
    gsap.to(".login-bg-svg", { opacity: 1, duration: 1 });

    // --- Stepper Logic ---
    const roleInput = document.getElementById('role_input');
    const btnNextStep = document.getElementById('btn-next-step');
    const btnSubmitUser = document.getElementById('btn-submit-user');
    const btnPrevStep = document.getElementById('btn-prev-step');
    
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const businessFieldsContainer = document.getElementById('business-registration-fields');

    function goToStep2() {
        const nameInput = document.querySelector('#step-1 input[name="name"]');
        const emailInput = document.querySelector('#step-1 input[name="email"]');
        const pwdInput = document.querySelector('#step-1 input[name="password"]');
        const pwdConfInput = document.querySelector('#step-1 input[name="password_confirmation"]');
        
        // Validation before proceeding
        if (!nameInput.value || !emailInput.value || !pwdInput.value || !pwdConfInput.value) {
            alert('Por favor, completa todos los campos de tu cuenta antes de continuar.');
            return;
        }
        
        if (pwdInput.value.length < 8) {
            alert('La contraseña debe tener al menos 8 caracteres.');
            return;
        }

        if (pwdInput.value !== pwdConfInput.value) {
            alert('Las contraseñas no coinciden.');
            return;
        }

        // Remove required attributes so browser doesn't block submission when these are hidden
        nameInput.removeAttribute('required');
        emailInput.removeAttribute('required');
        pwdInput.removeAttribute('required');
        pwdConfInput.removeAttribute('required');

        roleInput.value = 'business';
        // Hide Step 1, Show Step 2
        gsap.to(step1, { opacity: 0, x: -20, duration: 0.3, onComplete: () => {
            step1.style.display = 'none';
            step2.style.display = 'block';
            gsap.fromTo(step2, { opacity: 0, x: 20 }, { opacity: 1, x: 0, duration: 0.3, ease: "power2.out" });
        }});

        // Enable business fields
        const allInputs = businessFieldsContainer.querySelectorAll('input');
        allInputs.forEach(input => {
            if (input.hasAttribute('data-globally-disabled')) {
                input.removeAttribute('disabled');
                input.removeAttribute('data-globally-disabled');
            }
        });
        
        // Trigger formal/informal logic
        const formalRadio = document.getElementById('tipo_formal');
        if (formalRadio) {
            formalRadio.dispatchEvent(new Event('change'));
        }
    }

    function goToStep1() {
        roleInput.value = 'user';
        
        // Add required attributes back
        document.querySelector('#step-1 input[name="name"]').setAttribute('required', 'required');
        document.querySelector('#step-1 input[name="email"]').setAttribute('required', 'required');
        document.querySelector('#step-1 input[name="password"]').setAttribute('required', 'required');
        document.querySelector('#step-1 input[name="password_confirmation"]').setAttribute('required', 'required');

        // Hide Step 2, Show Step 1
        gsap.to(step2, { opacity: 0, x: 20, duration: 0.3, onComplete: () => {
            step2.style.display = 'none';
            step1.style.display = 'block';
            gsap.fromTo(step1, { opacity: 0, x: -20 }, { opacity: 1, x: 0, duration: 0.3, ease: "power2.out" });
        }});

        // Disable business fields
        const allInputs = businessFieldsContainer.querySelectorAll('input');
        allInputs.forEach(input => {
            if (!input.disabled) {
                input.disabled = true;
                input.setAttribute('data-globally-disabled', 'true');
            }
        });
    }

    // Initialize state
    if (roleInput.value === 'business') {
        step1.style.display = 'none';
        step2.style.display = 'block';
        // Enable business fields
        const allInputs = businessFieldsContainer.querySelectorAll('input');
        allInputs.forEach(input => {
            if (input.hasAttribute('data-globally-disabled')) {
                input.removeAttribute('disabled');
                input.removeAttribute('data-globally-disabled');
            }
        });
    } else {
        // Disable business fields initially
        const allInputs = businessFieldsContainer.querySelectorAll('input');
        allInputs.forEach(input => {
            if (!input.disabled) {
                input.disabled = true;
                input.setAttribute('data-globally-disabled', 'true');
            }
        });
    }

    // Listeners
    btnNextStep.addEventListener('click', goToStep2);
    btnPrevStep.addEventListener('click', goToStep1);
});
</script>
@endpush
@endsection
