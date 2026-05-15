<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresa tu código — Spotlight</title>
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
        body::before {
            content: '';
            position: fixed;
            top: -100px; right: -100px;
            width: 350px; height: 350px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -60px; left: -60px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(13,148,136,0.12);
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
        .logo-wrap { margin-bottom: 24px; }
        .logo-wrap img { height: 52px; width: auto; }

        /* Badge de paso */
        .step-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, rgba(0,35,111,0.08), rgba(13,148,136,0.08));
            border: 1px solid rgba(0,35,111,0.12);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #00236f;
            margin-bottom: 20px;
        }

        .title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #00236f;
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }
        .subtitle {
            font-size: 0.88rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .subtitle strong { color: #0d9488; }

        /* ── 6 inputs OTP ── */
        .otp-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 10px;
        }
        .otp-input {
            width: 56px;
            height: 66px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            text-align: center;
            font-size: 1.6rem;
            font-weight: 800;
            color: #00236f;
            background: #f8fafc;
            transition: border-color 0.2s, background 0.2s, transform 0.15s, box-shadow 0.2s;
            outline: none;
            caret-color: #0d9488;
        }
        .otp-input:focus {
            border-color: #00236f;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0,35,111,0.1);
            transform: translateY(-2px);
        }
        .otp-input.filled {
            border-color: #0d9488;
            background: linear-gradient(135deg, #f0fdf9, #e8fdf7);
            color: #0d9488;
        }
        .otp-input.error {
            border-color: #ef4444;
            background: #fef2f2;
            animation: shake 0.4s ease;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-6px); }
            40%       { transform: translateX(6px); }
            60%       { transform: translateX(-4px); }
            80%       { transform: translateX(4px); }
        }

        /* Separador entre dígitos 3 y 4 */
        .otp-sep {
            display: flex;
            align-items: center;
            color: #cbd5e1;
            font-size: 1.2rem;
            font-weight: 300;
            user-select: none;
        }

        /* Mensajes de error */
        .error-msg {
            font-size: 0.82rem;
            color: #ef4444;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* Hint de email */
        .email-hint {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-bottom: 28px;
        }
        .email-hint strong { color: #00236f; }

        /* Botón verificar */
        .btn-verify {
            background: linear-gradient(135deg, #00236f, #0d4fc4);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 15px 28px;
            font-size: 0.95rem;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.2s;
            margin-bottom: 14px;
            letter-spacing: 0.01em;
        }
        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(0,35,111,0.3);
        }
        .btn-verify:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-back {
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
        .btn-back:hover { border-color: #0d9488; color: #0d9488; }

        /* Progress dots */
        .progress-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 28px;
        }
        .progress-dots .dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #e2e8f0;
        }
        .progress-dots .dot.active {
            background: linear-gradient(135deg, #00236f, #0d9488);
            width: 24px;
            border-radius: 4px;
        }

        /* Alert error global */
        .alert-vs {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            text-align: left;
        }

        /* Countdown */
        .countdown {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-top: 16px;
        }
        .countdown span { color: #00236f; font-weight: 700; }
    </style>
</head>
<body>

<div class="card-verify">
    {{-- Logo --}}
    <div class="logo-wrap">
        <img src="{{ asset('images/logo.png') }}" alt="Spotlight">
    </div>

    {{-- Indicador de paso --}}
    <div class="step-badge">
        <i class="bi bi-shield-lock-fill"></i> Paso 2 de 2 — Ingresa tu código
    </div>

    {{-- Progress --}}
    <div class="progress-dots">
        <div class="dot"></div>
        <div class="dot active"></div>
    </div>

    <h1 class="title">Código de verificación</h1>
    <p class="subtitle">
        Ingresa los <strong>6 dígitos</strong> que enviamos a tu correo.<br>
        No compartas este código con nadie.
    </p>

    {{-- Error global --}}
    @if($errors->has('code'))
        <div class="alert-vs alert alert-danger">
            <i class="bi bi-x-circle-fill me-2"></i>{{ $errors->first('code') }}
        </div>
    @endif

    {{-- Formulario OTP --}}
    <form action="{{ route('verify.submit') }}" method="POST" id="otp-form">
        @csrf

        <div class="otp-container" id="otp-container">
            <input class="otp-input {{ $errors->has('code') ? 'error' : '' }}" type="text" name="d1" id="d1" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code" autofocus>
            <input class="otp-input {{ $errors->has('code') ? 'error' : '' }}" type="text" name="d2" id="d2" maxlength="1" inputmode="numeric" pattern="[0-9]">
            <input class="otp-input {{ $errors->has('code') ? 'error' : '' }}" type="text" name="d3" id="d3" maxlength="1" inputmode="numeric" pattern="[0-9]">
            <span class="otp-sep">—</span>
            <input class="otp-input {{ $errors->has('code') ? 'error' : '' }}" type="text" name="d4" id="d4" maxlength="1" inputmode="numeric" pattern="[0-9]">
            <input class="otp-input {{ $errors->has('code') ? 'error' : '' }}" type="text" name="d5" id="d5" maxlength="1" inputmode="numeric" pattern="[0-9]">
            <input class="otp-input {{ $errors->has('code') ? 'error' : '' }}" type="text" name="d6" id="d6" maxlength="1" inputmode="numeric" pattern="[0-9]">
        </div>

        <p class="email-hint">
            Código enviado a: <strong>{{ $email }}</strong>
        </p>

        <button type="submit" class="btn-verify" id="btn-verify" disabled>
            <i class="bi bi-patch-check-fill me-2"></i>Verificar y continuar
        </button>
    </form>

    <a href="{{ route('verify.notice') }}" class="btn-back">
        <i class="bi bi-arrow-left me-2"></i>Volver · Reenviar código
    </a>

    {{-- Countdown --}}
    <p class="countdown">
        Código expira en: <span id="timer">10:00</span>
    </p>
</div>

<script>
(function () {
    const inputs   = Array.from(document.querySelectorAll('.otp-input'));
    const btnVerify = document.getElementById('btn-verify');

    // ── Auto-focus y navegación entre inputs ──
    inputs.forEach((inp, idx) => {
        inp.addEventListener('input', (e) => {
            // Filtrar solo dígitos
            inp.value = inp.value.replace(/\D/g, '').slice(-1);
            inp.classList.toggle('filled', inp.value !== '');
            inp.classList.remove('error');

            if (inp.value && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
            checkAllFilled();
        });

        inp.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !inp.value && idx > 0) {
                inputs[idx - 1].value = '';
                inputs[idx - 1].classList.remove('filled');
                inputs[idx - 1].focus();
                checkAllFilled();
            }
            // Permitir pegar
            if (e.key === 'ArrowLeft' && idx > 0) inputs[idx - 1].focus();
            if (e.key === 'ArrowRight' && idx < inputs.length - 1) inputs[idx + 1].focus();
        });

        // Soporte para pegar código completo (ej. desde el correo)
        inp.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData)
                .getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach((char, i) => {
                if (inputs[i]) {
                    inputs[i].value = char;
                    inputs[i].classList.add('filled');
                    inputs[i].classList.remove('error');
                }
            });
            const next = inputs[Math.min(pasted.length, 5)];
            if (next) next.focus();
            checkAllFilled();
        });
    });

    function checkAllFilled() {
        const allFilled = inputs.every(i => i.value.length === 1);
        btnVerify.disabled = !allFilled;
    }

    // ── Countdown de 10 minutos ──
    const timerEl = document.getElementById('timer');
    let totalSeconds = 10 * 60;

    const ticker = setInterval(() => {
        totalSeconds--;
        if (totalSeconds <= 0) {
            clearInterval(ticker);
            timerEl.textContent = '00:00';
            timerEl.style.color = '#ef4444';
            inputs.forEach(i => {
                i.disabled = true;
                i.classList.add('error');
            });
            btnVerify.disabled = true;
            btnVerify.textContent = '⏱ Código expirado — Reenvía el correo';
            return;
        }
        const m = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
        const s = (totalSeconds % 60).toString().padStart(2, '0');
        timerEl.textContent = `${m}:${s}`;
        if (totalSeconds < 60) timerEl.style.color = '#ef4444';
    }, 1000);

    // Submit con loading
    document.getElementById('otp-form').addEventListener('submit', () => {
        btnVerify.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verificando...';
        btnVerify.disabled = true;
    });
})();
</script>

</body>
</html>
