<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu correo — Spotlight</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #00236f 0%, #00369e 40%, #0d9488 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* Círculos decorativos de fondo */
        body::before {
            content: '';
            position: fixed;
            top: -120px; right: -120px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -80px; left: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(13,148,136,0.15);
            pointer-events: none;
        }

        .card-verify {
            background: #fff;
            border-radius: 24px;
            padding: 48px 44px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 32px 80px rgba(0,0,0,0.25);
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* Logo */
        .logo-wrap {
            margin-bottom: 28px;
        }
        .logo-wrap img {
            height: 56px;
            width: auto;
        }

        /* Icono animado de correo */
        .mail-icon-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 96px;
            height: 96px;
            margin-bottom: 24px;
        }
        .mail-icon-wrap .ring {
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(0,35,111,0.15);
            animation: ring-pulse 2.5s ease-out infinite;
        }
        .mail-icon-wrap .ring-1 { width: 96px; height: 96px; animation-delay: 0s; }
        .mail-icon-wrap .ring-2 { width: 120px; height: 120px; animation-delay: 0.6s; }
        .mail-icon-wrap .ring-3 { width: 144px; height: 144px; animation-delay: 1.2s; }
        .mail-icon-wrap .icon-inner {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #00236f, #0d9488);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            z-index: 2;
        }
        .mail-icon-wrap .icon-inner i {
            color: #fff;
            font-size: 1.7rem;
            animation: bounce-icon 2s ease-in-out infinite;
        }
        @keyframes ring-pulse {
            0%   { transform: scale(0.85); opacity: 0.7; }
            50%  { transform: scale(1);    opacity: 0.3; }
            100% { transform: scale(1.15); opacity: 0; }
        }
        @keyframes bounce-icon {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-5px); }
        }

        .title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #00236f;
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }
        .subtitle {
            font-size: 0.92rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .subtitle strong { color: #0d9488; }

        /* Info box email */
        .email-box {
            background: linear-gradient(135deg, #f0f4ff, #e8fdf7);
            border: 1.5px solid rgba(0,35,111,0.12);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-align: left;
        }
        .email-box .icon {
            width: 40px; height: 40px; flex-shrink: 0;
            background: #00236f;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1rem;
        }
        .email-box .label { font-size: 0.72rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 2px; }
        .email-box .value { font-size: 0.9rem; font-weight: 600; color: #00236f; word-break: break-all; }

        /* Expiración */
        .expiry-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 28px;
        }
        .expiry-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #0d9488;
            animation: blink 1.5s ease-in-out infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.3; }
        }

        /* Botones */
        .btn-primary-vs {
            background: linear-gradient(135deg, #00236f, #0d4fc4);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-size: 0.95rem;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
        }
        .btn-primary-vs:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,35,111,0.3);
            color: #fff;
        }
        .btn-ghost {
            background: transparent;
            color: #94a3b8;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 13px 28px;
            font-size: 0.88rem;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            display: block;
        }
        .btn-ghost:hover {
            border-color: #0d9488;
            color: #0d9488;
        }

        /* Alert flash */
        .alert-vs {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            text-align: left;
        }

        /* Divider */
        .divider-text {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 16px 0;
            color: #cbd5e1;
            font-size: 0.78rem;
        }
        .divider-text::before, .divider-text::after {
            content: ''; flex: 1;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

<div class="card-verify">
    {{-- Logo Spotlight --}}
    <div class="logo-wrap">
        <img src="{{ asset('images/logo.png') }}" alt="Spotlight">
    </div>

    {{-- Alerta de éxito (reenvío) --}}
    @if(session('success'))
        <div class="alert-vs alert alert-success">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($errors->has('code'))
        <div class="alert-vs alert alert-danger">
            <i class="bi bi-x-circle-fill me-2"></i>{{ $errors->first('code') }}
        </div>
    @endif

    {{-- Icono de correo animado --}}
    <div class="d-flex justify-content-center mb-2">
        <div class="mail-icon-wrap">
            <div class="ring ring-1"></div>
            <div class="ring ring-2"></div>
            <div class="ring ring-3"></div>
            <div class="icon-inner">
                <i class="bi bi-envelope-paper-fill"></i>
            </div>
        </div>
    </div>

    <h1 class="title">¡Revisa tu correo!</h1>
    <p class="subtitle">
        Enviamos un <strong>código de verificación de 6 dígitos</strong><br>
        a la siguiente dirección:
    </p>

    {{-- Email box --}}
    <div class="email-box">
        <div class="icon"><i class="bi bi-at"></i></div>
        <div>
            <div class="label">Correo de verificación</div>
            <div class="value">{{ $email }}</div>
        </div>
    </div>

    {{-- Nota de expiración --}}
    <div class="expiry-note">
        <span class="expiry-dot"></span>
        El código expira en <strong style="color:#00236f;">10 minutos</strong>
    </div>

    {{-- Botón principal --}}
    <a href="{{ route('verify.form') }}" class="btn-primary-vs">
        <i class="bi bi-keyboard me-2"></i>Ingresar mi código
    </a>

    <div class="divider-text">¿No recibiste el correo?</div>

    {{-- Reenviar --}}
    <form action="{{ route('verify.resend') }}" method="POST">
        @csrf
        <button type="submit" class="btn-ghost">
            <i class="bi bi-arrow-clockwise me-2"></i>Reenviar código
        </button>
    </form>
</div>

</body>
</html>
