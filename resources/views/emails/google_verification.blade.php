<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Código de verificación de seguridad — Spotlight</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    background-color: #f1f5f9;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    color: #1e293b;
    -webkit-font-smoothing: antialiased;
  }
  .wrapper {
    max-width: 580px;
    margin: 40px auto;
    padding: 0 16px;
  }
  .card {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 35, 111, 0.08);
    border: 1px solid #e2e8f0;
  }
  .header {
    background: linear-gradient(135deg, #00236f 0%, #0d4fc4 100%);
    padding: 36px 32px 30px;
    text-align: center;
  }
  .brand-title {
    color: #ffffff;
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.02em;
    margin-bottom: 6px;
  }
  .brand-subtitle {
    color: rgba(255, 255, 255, 0.82);
    font-size: 13px;
    font-weight: 400;
    letter-spacing: 0.02em;
    text-transform: uppercase;
  }
  .body {
    padding: 36px 36px 28px;
  }
  .salutation {
    font-size: 16px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 12px;
  }
  .text {
    font-size: 14px;
    line-height: 1.65;
    color: #334155;
    margin-bottom: 24px;
  }
  .code-container {
    background-color: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    text-align: center;
    padding: 26px 20px;
    margin: 28px 0;
  }
  .code-title {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    margin-bottom: 10px;
  }
  .code-value {
    font-size: 40px;
    font-weight: 800;
    letter-spacing: 0.22em;
    color: #00236f;
    line-height: 1.1;
    font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier, monospace;
  }
  .code-info {
    font-size: 12px;
    color: #64748b;
    margin-top: 10px;
  }
  .security-box {
    background-color: #f8fafc;
    border-left: 3px solid #00236f;
    border-radius: 4px;
    padding: 14px 16px;
    margin-top: 24px;
    margin-bottom: 20px;
  }
  .security-title {
    font-size: 12px;
    font-weight: 700;
    color: #00236f;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 4px;
  }
  .security-text {
    font-size: 13px;
    line-height: 1.55;
    color: #475569;
    margin: 0;
  }
  .divider {
    border: 0;
    border-top: 1px solid #e2e8f0;
    margin: 24px 0;
  }
  .footer {
    background-color: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 24px 32px;
    text-align: center;
  }
  .footer-text {
    font-size: 12px;
    line-height: 1.6;
    color: #64748b;
    margin-bottom: 8px;
  }
  .footer-sub {
    font-size: 11px;
    color: #94a3b8;
  }
</style>
</head>
<body>
<div class="wrapper">
  <div class="card">
    <!-- Header Corporativo -->
    <div class="header">
      <div class="brand-title">Spotlight</div>
      <div class="brand-subtitle">Servicio de Autenticación y Seguridad</div>
    </div>

    <!-- Contenido Principal -->
    <div class="body">
      <div class="salutation">Estimado/a {{ $userName }},</div>
      <p class="text">
        Hemos recibido una solicitud de acceso o registro vinculada a su cuenta en la plataforma. Para verificar su identidad y continuar de manera segura, ingrese el siguiente código de autorización:
      </p>

      <!-- Bloque del Código -->
      <div class="code-container">
        <div class="code-title">Código de verificación</div>
        <div class="code-value">{{ $code }}</div>
        <div class="code-info">Código de un solo uso válido durante los próximos 10 minutos.</div>
      </div>

      <!-- Aviso de Seguridad -->
      <div class="security-box">
        <div class="security-title">Aviso de seguridad</div>
        <p class="security-text">
          Por razones de seguridad, nunca comparta este código con nadie. El equipo de Spotlight jamás solicitará este código por ningún medio. Si usted no ha realizado esta solicitud, puede desestimar este correo con total tranquilidad.
        </p>
      </div>

      <hr class="divider">

      <p class="text" style="margin-bottom: 0; font-size: 13px; color: #64748b;">
        Atentamente,<br>
        <strong style="color: #00236f;">Equipo de Seguridad de Spotlight</strong>
      </p>
    </div>

    <!-- Pie de Correo -->
    <div class="footer">
      <p class="footer-text">
        Este mensaje ha sido generado de forma automática por el sistema de autenticación.<br>
        Por favor, no responda a este correo electrónico ya que la casilla no se encuentra monitoreada.
      </p>
      <p class="footer-sub">
        &copy; {{ date('Y') }} Spotlight. Todos los derechos reservados.
      </p>
    </div>
  </div>
</div>
</body>
</html>
