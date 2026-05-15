@php
  $isRegistration = !isset($company) || !$company->id;
  $docsDisabled = !$isRegistration && $company->status === 'active' && $company->document_update_status !== 'granted';
@endphp

    <!-- Selector de Tipo de Negocio -->
    <div class="mb-4">
        <label class="form-label fw-semibold text-dark mb-3">¿Qué tipo de negocio tienes?</label>
        <div class="row g-3">
            <div class="col-md-6">
                <input type="radio" class="btn-check" name="tipo_negocio" id="tipo_formal" value="formal" autocomplete="off" {{ old('tipo_negocio', $company->tipo_negocio ?? 'formal') === 'formal' ? 'checked' : '' }}>
                <label class="btn btn-outline-primary w-100 text-start p-3 h-100" for="tipo_formal">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-building fs-4 me-2"></i>
                        <span class="fw-bold">Empresa Formal</span>
                    </div>
                    <small class="d-block opacity-75">Persona Jurídica o Natural Comerciante registrada ante Cámara de Comercio.</small>
                </label>
            </div>
            <div class="col-md-6">
                <input type="radio" class="btn-check" name="tipo_negocio" id="tipo_informal" value="informal" autocomplete="off" {{ old('tipo_negocio', $company->tipo_negocio ?? '') === 'informal' ? 'checked' : '' }}>
                <label class="btn btn-outline-primary w-100 text-start p-3 h-100 position-relative" for="tipo_informal">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-shop fs-4 me-2"></i>
                        <span class="fw-bold">Emprendimiento / Local</span>
                    </div>
                    <small class="d-block opacity-75">Negocio independiente no registrado formalmente.</small>
                    
                    <!-- Tooltip sugerido -->
                    <span class="position-absolute top-0 end-0 translate-middle-y badge rounded-pill bg-info text-dark shadow-sm px-2 py-1" style="font-size: 0.7rem; right: 10px !important; z-index: 2;" data-bs-toggle="tooltip" data-bs-placement="top" title="¿No tienes Cámara de Comercio? Regístrate como Informal para empezar.">
                        <i class="bi bi-info-circle-fill"></i> Tip
                    </span>
                </label>
            </div>
        </div>
    </div>

    <!-- Campos Comunes -->
    <div class="mb-4">
        <label class="form-label text-sm fw-semibold text-dark mb-2">Dirección Física (Ubaté)</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-geo-alt text-muted"></i></span>
            <input type="text" name="address" class="form-control form-control-lg border-start-0 text-sm" value="{{ old('address', $company->address ?? '') }}" placeholder="Ej. Carrera 7 # 8-20, Ubaté" required>
        </div>
    </div>

    <!-- Contenedor: Empresa Formal -->
    <div id="container-formal" class="business-fields-container animate-fade-in">
        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-file-earmark-text me-1"></i> Datos de Empresa Formal</h6>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-sm fw-medium text-dark mb-1">Razón Social <span class="text-danger">*</span></label>
                <input type="text" name="razon_social" class="form-control text-sm" value="{{ old('razon_social', $company->razon_social ?? '') }}" placeholder="Nombre legal de la empresa">
            </div>
            <div class="col-md-6">
                <label class="form-label text-sm fw-medium text-dark mb-1">NIT <span class="text-danger">*</span></label>
                <input type="text" name="nit" class="form-control text-sm" value="{{ old('nit', $company->nit ?? '') }}" placeholder="Ej. 900123456-1">
            </div>
        </div>

        <h6 class="fw-bold text-primary mb-3 mt-4"><i class="bi bi-person-badge me-1"></i> Representante Legal</h6>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label text-sm fw-medium text-dark mb-1">Nombre Completo <span class="text-danger">*</span></label>
                <input type="text" name="nombre_representante" class="form-control text-sm" value="{{ old('nombre_representante', $company->nombre_representante ?? '') }}" placeholder="Ej. Juan Pérez">
            </div>
            <div class="col-md-4">
                <label class="form-label text-sm fw-medium text-dark mb-1">Cédula <span class="text-danger">*</span></label>
                <input type="text" name="cedula_propietario" class="form-control text-sm" value="{{ old('cedula_propietario', $company->cedula_propietario ?? '') }}" placeholder="Cédula de ciudadanía">
            </div>
            <div class="col-md-4">
                <label class="form-label text-sm fw-medium text-dark mb-1">Correo Electrónico <span class="text-danger">*</span></label>
                <input type="email" name="email_representante" class="form-control text-sm" value="{{ old('email_representante', $company->email_representante ?? '') }}" placeholder="correo@ejemplo.com">
            </div>
        </div>

        <h6 class="fw-bold text-primary mb-3 mt-4"><i class="bi bi-files me-1"></i> Documentos Adjuntos</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label text-sm fw-medium text-dark mb-1">Cámara de Comercio (PDF) <span class="text-danger">*</span></label>
                <input type="file" name="camara_comercio_file" class="form-control text-sm" accept=".pdf" {{ $docsDisabled ? 'disabled data-locked="true"' : '' }}>
                <small class="text-muted" style="font-size: 0.75rem;">Debe ser reciente (Máx. 5MB).</small>
            </div>
            <div class="col-md-6">
                <label class="form-label text-sm fw-medium text-dark mb-1">RUT (PDF) <span class="text-danger">*</span></label>
                <input type="file" name="rut_file" class="form-control text-sm" accept=".pdf" {{ $docsDisabled ? 'disabled data-locked="true"' : '' }}>
                <small class="text-muted" style="font-size: 0.75rem;">Máx. 5MB.</small>
            </div>
        </div>
    </div>

    <!-- Contenedor: Emprendimiento Informal -->
    <div id="container-informal" class="business-fields-container animate-fade-in" style="display: none;">
        <h6 class="fw-bold text-success mb-3"><i class="bi bi-person-badge me-1"></i> Datos del Emprendedor</h6>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-sm fw-medium text-dark mb-1">Nombre Comercial <span class="text-danger">*</span></label>
                <input type="text" name="nombre_comercial" class="form-control text-sm" value="{{ old('nombre_comercial', $company->nombre_comercial ?? '') }}" placeholder="¿Cómo conocen tu negocio?">
            </div>
            <div class="col-md-6">
                <label class="form-label text-sm fw-medium text-dark mb-1">Cédula del Propietario <span class="text-danger">*</span></label>
                <input type="text" name="cedula_propietario" class="form-control text-sm" value="{{ old('cedula_propietario', $company->cedula_propietario ?? '') }}" placeholder="Número de identificación">
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label text-sm fw-medium text-dark mb-1">RUT Personal (Opcional pero recomendado)</label>
            <input type="file" name="rut_personal_file" class="form-control text-sm" accept=".pdf" {{ $docsDisabled ? 'disabled data-locked="true"' : '' }}>
            <small class="text-muted" style="font-size: 0.75rem;">Si posees RUT personal, adjúntalo (Máx. 5MB).</small>
        </div>
    </div>

    @if(!$isRegistration && $company->status === 'active')
        <div class="alert {{ $company->document_update_status === 'granted' ? 'alert-success' : 'alert-info' }} mb-4 border-0 shadow-sm d-flex align-items-center">
            @if($company->document_update_status === 'granted')
                <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                <div>
                    <h6 class="mb-1 fw-bold">Permiso concedido</h6>
                    <p class="mb-0 text-sm">Ya puedes subir los nuevos documentos. Al guardar, tu cuenta volverá a estar en revisión.</p>
                </div>
            @elseif($company->document_update_status === 'requested')
                <i class="bi bi-hourglass-split fs-4 me-3 text-info"></i>
                <div>
                    <h6 class="mb-1 fw-bold">Solicitud enviada</h6>
                    <p class="mb-0 text-sm">Has solicitado cambiar tus documentos. Espera a que el administrador habilite la edición.</p>
                </div>
            @else
                <i class="bi bi-shield-lock-fill fs-4 me-3 text-info"></i>
                <div>
                    <h6 class="mb-1 fw-bold">Documentos bloqueados</h6>
                    <p class="mb-0 text-sm">Tus documentos actuales ya fueron aprobados. <button type="button" class="btn btn-sm btn-outline-primary ms-2 mt-1 mt-md-0" data-bs-toggle="modal" data-bs-target="#requestUpdateModal">Solicitar modificación</button></p>
                </div>
            @endif
        </div>
    @endif

    <!-- Checkbox Habeas Data (Obligatorio para ambos) -->
    <div class="form-check mb-4 bg-light p-3 rounded border">
        <input class="form-check-input ms-1 me-2 mt-1" type="checkbox" name="habeas_data_accepted" id="habeasDataCheck" value="1" {{ old('habeas_data_accepted', $company->habeas_data_accepted ?? false) ? 'checked' : '' }} required>
        <label class="form-check-label text-sm text-dark" for="habeasDataCheck">
            He leído y acepto la <a href="#" class="text-primary text-decoration-none fw-medium">Política de Tratamiento de Datos Personales</a> (Ley 1581 de 2012 - Habeas Data). Autorizo el uso de mi información para fines del servicio.
        </label>
    </div>

<style>
.animate-fade-in {
    animation: fadeIn 0.4s ease-out forwards;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
/* Estilo para que el botón seleccionado se vea más destacado */
.btn-check:checked + .btn-outline-primary {
    background-color: rgba(13, 110, 253, 0.05) !important;
    border-color: #0d6efd !important;
    border-width: 2px;
    color: #0d6efd !important;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Inicializar Tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Lógica para alternar vistas
    const radioFormal = document.getElementById('tipo_formal');
    const radioInformal = document.getElementById('tipo_informal');
    const containerFormal = document.getElementById('container-formal');
    const containerInformal = document.getElementById('container-informal');

    function toggleForms() {
        if (radioFormal.checked) {
            containerFormal.style.display = 'block';
            containerInformal.style.display = 'none';
            // Disable informal fields so they don't validate/submit empty
            toggleFieldsDisabled(containerInformal, true);
            toggleFieldsDisabled(containerFormal, false);
        } else {
            containerFormal.style.display = 'none';
            containerInformal.style.display = 'block';
            toggleFieldsDisabled(containerFormal, true);
            toggleFieldsDisabled(containerInformal, false);
        }
    }

    function toggleFieldsDisabled(container, disabledState) {
        const inputs = container.querySelectorAll('input');
        inputs.forEach(input => {
            if (input.hasAttribute('data-locked')) {
                input.disabled = true; // Always keep disabled if locked
            } else {
                input.disabled = disabledState;
            }
        });
    }

    // Inicializar estado
    toggleForms();

    // Listeners
    radioFormal.addEventListener('change', toggleForms);
    radioInformal.addEventListener('change', toggleForms);
});
</script>

@if(!$isRegistration && $company->status === 'active' && $company->document_update_status !== 'granted' && $company->document_update_status !== 'requested')
<!-- Modal para solicitar actualización de documentos -->
<div class="modal fade" id="requestUpdateModal" tabindex="-1" aria-labelledby="requestUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('business.company.request_document_update') }}" method="POST">
        @csrf
        <div class="modal-header bg-light border-0">
          <h5 class="modal-title fw-bold" id="requestUpdateModalLabel">Solicitar Cambio de Documentos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-medium">Motivo del cambio <span class="text-danger">*</span></label>
            <textarea name="document_update_reason" class="form-control" rows="3" required placeholder="Explica brevemente por qué necesitas actualizar tus documentos legales..."></textarea>
          </div>
          <div class="alert alert-warning border-0 p-3 mb-0 text-sm" style="background-color: #fffbeb; color: #92400e;">
            <i class="bi bi-exclamation-triangle me-2"></i> Al enviar esta solicitud, el administrador revisará tu caso y habilitará temporalmente la carga de nuevos archivos. Una vez los subas, tu tienda volverá a revisión.
          </div>
        </div>
        <div class="modal-footer border-0 bg-light">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary fw-semibold">Enviar Solicitud</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
