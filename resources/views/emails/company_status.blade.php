<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body { margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; color: #1e293b; }
    .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    .header { background: linear-gradient(135deg, #00236f 0%, #0d9488 100%); padding: 40px 30px; text-align: center; }
    .header h1 { color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; }
    .content { padding: 40px 30px; }
    .content h2 { margin-top: 0; color: #0f172a; font-size: 20px; }
    .content p { line-height: 1.6; color: #475569; margin-bottom: 20px; }
    .status-box { padding: 20px; border-radius: 8px; margin: 25px 0; text-align: center; }
    .status-active { background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
    .status-inactive { background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
    .status-pending { background-color: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
    .btn { display: inline-block; padding: 12px 24px; background-color: #00236f; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; text-align: center; }
    .footer { text-align: center; padding: 30px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; }
    .footer p { margin: 0; color: #64748b; font-size: 13px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Spotlight</h1>
    </div>
    <div class="content">
      <h2>Hola, {{ $company->user->name }}</h2>
      
      @if($status === 'active')
        <p>¡Buenas noticias! Los documentos de tu empresa <strong>{{ $company->name }}</strong> han sido verificados y aprobados exitosamente.</p>
        <div class="status-box status-active">
          <h3 style="margin:0; font-size: 18px;">Empresa Aprobada</h3>
          <p style="margin: 8px 0 0 0; color: inherit;">Tu perfil público y tus productos ya están visibles para toda la comunidad.</p>
        </div>
        <div style="text-align: center; margin-top: 30px;">
          <a href="{{ route('business.dashboard') }}" class="btn">Ir a mi Panel</a>
        </div>
      @elseif($status === 'inactive')
        <p>Hemos revisado los documentos de tu empresa <strong>{{ $company->name }}</strong>, pero hemos encontrado un problema con la validación.</p>
        <div class="status-box status-inactive">
          <h3 style="margin:0; font-size: 18px;">Empresa No Aprobada</h3>
          <p style="margin: 8px 0 0 0; color: inherit;">
            @if($reason)
              {{ $reason }}
            @else
              Los documentos subidos no son válidos o no cumplen con los requisitos. Por favor, ingresa a tu panel para actualizarlos.
            @endif
          </p>
        </div>
        <div style="text-align: center; margin-top: 30px;">
          <a href="{{ route('business.dashboard') }}" class="btn">Revisar mis documentos</a>
        </div>
      @endif

      <p style="margin-top: 30px; font-size: 14px;">Si tienes alguna pregunta, no dudes en contactarnos respondiendo a este correo.</p>
    </div>
    <div class="footer">
      <p>Este correo fue enviado automáticamente por <strong>Spotlight</strong>.<br>Por favor, no respondas a este mensaje.</p>
    </div>
  </div>
</body>
</html>
