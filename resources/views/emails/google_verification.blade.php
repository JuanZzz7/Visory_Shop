<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Código de verificación — Spotlight</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { background: #F0F4FF; font-family: 'Segoe UI', Arial, sans-serif; color: #1a1b21; }
  .wrapper { max-width: 560px; margin: 40px auto; padding: 20px; }
  .card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,35,111,0.12);
  }
  /* Header con gradiente corporativo */
  .header {
    background: linear-gradient(135deg, #00236f 0%, #0d4fc4 60%, #0d9488 100%);
    padding: 40px 32px 32px;
    text-align: center;
  }
  .header img {
    height: 52px;
    width: auto;
    margin-bottom: 20px;
    filter: brightness(0) invert(1);
  }
  .header h1 {
    color: #fff;
    font-size: 22px;
    font-weight: 700;
    margin: 0;
    letter-spacing: -0.01em;
  }
  .header p {
    color: rgba(255,255,255,0.75);
    font-size: 14px;
    margin-top: 6px;
  }
  /* Body */
  .body { padding: 36px 32px; }
  .greeting {
    font-size: 17px;
    font-weight: 600;
    color: #00236f;
    margin-bottom: 10px;
  }
  .desc {
    font-size: 14px;
    color: #444651;
    line-height: 1.6;
    margin-bottom: 30px;
  }
  /* Código */
  .code-block {
    background: linear-gradient(135deg, #f0f4ff 0%, #e8fdf7 100%);
    border: 2px solid #00236f;
    border-radius: 16px;
    text-align: center;
    padding: 28px 20px;
    margin-bottom: 28px;
  }
  .code-label {
    font-size: 12px;
    font-weight: 600;
    color: #0d9488;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 12px;
  }
  .code-digits {
    font-size: 46px;
    font-weight: 800;
    letter-spacing: 0.18em;
    color: #00236f;
    line-height: 1;
    font-variant-numeric: tabular-nums;
  }
  .code-expiry {
    font-size: 12px;
    color: #757682;
    margin-top: 12px;
  }
  /* Divider */
  .divider {
    border: none;
    border-top: 1px solid #E2E8F0;
    margin: 24px 0;
  }
  .note {
    background: #fff8ed;
    border-left: 4px solid #f59e0b;
    border-radius: 8px;
    padding: 14px 16px;
    font-size: 13px;
    color: #92400e;
    line-height: 1.5;
  }
  /* Footer */
  .footer {
    background: #f8fafc;
    border-top: 1px solid #E2E8F0;
    padding: 20px 32px;
    text-align: center;
  }
  .footer p {
    font-size: 12px;
    color: #757682;
    line-height: 1.6;
  }
  .footer strong { color: #00236f; }
  /* Decorative circles */
  .deco {
    display: inline-block;
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #0d9488;
    margin: 0 3px;
    vertical-align: middle;
  }
</style>
</head>
<body>
<div class="wrapper">
  <div class="card">
    <!-- Header -->
    <div class="header">
      <img src="{{ asset('images/logo.png') }}" alt="Spotlight">
      <h1>Verifica tu correo electrónico</h1>
      <p>Para completar tu registro en Spotlight</p>
    </div>

    <!-- Body -->
    <div class="body">
      <p class="greeting">¡Hola, {{ $userName }}! 👋</p>
      <p class="desc">
        Gracias por registrarte en <strong>Spotlight</strong> con tu cuenta de Google.
        Para confirmar tu identidad y proteger tu cuenta, usa el siguiente código de verificación:
      </p>

      <!-- Código -->
      <div class="code-block">
        <div class="code-label">🔑 Tu código de verificación</div>
        <div class="code-digits">{{ $code }}</div>
        <div class="code-expiry">⏱ Este código expira en <strong>10 minutos</strong></div>
      </div>

      <hr class="divider">

      <div class="note">
        <strong>⚠ Importante:</strong> Si no solicitaste este código, ignora este mensaje. Tu cuenta de Google permanecerá segura.
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <span class="deco"></span><span class="deco" style="background:#00236f;"></span><span class="deco"></span>
      <p style="margin-top:10px;">
        Este correo fue enviado automáticamente por <strong>Spotlight</strong>.<br>
        Por favor, no respondas a este mensaje.
      </p>
      <p style="margin-top:8px; color:#a0aec0; font-size:11px;">
        © {{ date('Y') }} Spotlight. Todos los derechos reservados.
      </p>
    </div>
  </div>
</div>
</body>
</html>
