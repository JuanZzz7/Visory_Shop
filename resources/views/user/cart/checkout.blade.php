@extends('layouts.app')
@section('title', 'Finalizar Compra - Spotlight')
@section('content')
<div class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h2 class="fw-bold text-dark mb-0"><i class="bi bi-shield-check text-primary me-2"></i>Finalizar Compra</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Tienda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.cart.index') }}">Carrito</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pago</li>
                </ol>
            </nav>
        </div>
        
        <form action="{{ route('user.cart.payment.process') }}" method="POST">
            @csrf
            <div class="row g-4">
                <!-- Left: Shipping & Payment -->
                <div class="col-lg-8">
                    {{-- Envío --}}
                    <div class="vs-card p-4 mb-4 border-0 shadow-sm">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">1</div>
                            <h5 class="fw-bold mb-0">Información de envío</h5>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Dirección de entrega completa</label>
                            <textarea name="address" class="form-control border-light-subtle bg-light bg-opacity-50" rows="3" placeholder="Calle, número, barrio, ciudad, departamento..." required>{{ old('address') }}</textarea>
                            <div class="form-text mt-2 text-muted">
                                <i class="bi bi-info-circle me-1"></i> Asegúrate de que la dirección sea correcta para evitar retrasos.
                            </div>
                        </div>
                    </div>

                    {{-- Pago --}}
                    <div class="vs-card p-4 border-0 shadow-sm">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">2</div>
                            <h5 class="fw-bold mb-0">Pasarela de Pago Segura</h5>
                        </div>

                        {{-- Tarjeta Visual Interactiva --}}
                        <div class="mb-5 d-flex justify-content-center">
                            <div id="visual-card" class="credit-card-visual shadow-lg rounded-4 p-4 text-white position-relative overflow-hidden" style="width: 100%; max-width: 400px; height: 230px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); transition: all 0.5s ease;">
                                <!-- Brillo decorativo -->
                                <div class="position-absolute rounded-circle" style="width: 300px; height: 300px; background: rgba(255,255,255,0.1); top: -150px; right: -100px;"></div>
                                
                                <div class="d-flex justify-content-between align-items-start mb-4 position-relative z-1">
                                    <div class="card-chip bg-warning bg-opacity-75 rounded-2" style="width: 45px; height: 35px; border: 1px solid rgba(0,0,0,0.1);"></div>
                                    <i class="bi bi-wifi fs-4 opacity-50" style="transform: rotate(90deg);"></i>
                                </div>

                                <div class="card-number-display mb-4 position-relative z-1" style="font-family: 'Courier New', Courier, monospace; font-size: 1.5rem; letter-spacing: 2px;">
                                    <span id="display-number">#### #### #### ####</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-end position-relative z-1">
                                    <div class="card-holder-group">
                                        <div class="text-xs text-white-50 text-uppercase mb-1" style="font-size: 0.65rem;">Titular</div>
                                        <div id="display-name" class="fw-medium text-truncate" style="max-width: 200px; font-size: 0.9rem;">NOMBRE DEL TITULAR</div>
                                    </div>
                                    <div class="card-expiry-group">
                                        <div class="text-xs text-white-50 text-uppercase mb-1" style="font-size: 0.65rem;">Vence</div>
                                        <div id="display-expiry" class="fw-medium" style="font-size: 0.9rem;">MM/AA</div>
                                    </div>
                                    <div class="card-brand">
                                        <i id="display-brand-icon" class="bi bi-credit-card-2-front fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Nombre completo en la tarjeta</label>
                                <input type="text" name="card_name" id="card_name" class="form-control border-light-subtle bg-light bg-opacity-50" placeholder="Ej. Juan Manuel Pérez" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Número de tarjeta</label>
                                <div class="input-group">
                                    <span class="input-group-text border-light-subtle bg-light"><i class="bi bi-credit-card"></i></span>
                                    <input type="text" name="card_number" id="card_number" class="form-control border-light-subtle bg-light bg-opacity-50" placeholder="0000 0000 0000 0000" maxlength="19" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Fecha de vencimiento</label>
                                <input type="text" name="exp_date" id="exp_date" class="form-control border-light-subtle bg-light bg-opacity-50" placeholder="MM/AA" maxlength="5" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Código de seguridad (CVV)</label>
                                <div class="input-group">
                                    <input type="password" name="cvv" id="cvv" class="form-control border-light-subtle bg-light bg-opacity-50" placeholder="123" maxlength="4" required>
                                    <span class="input-group-text border-light-subtle bg-light"><i class="bi bi-lock"></i></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-light rounded-4 text-muted text-sm d-flex gap-2 align-items-center">
                            <i class="bi bi-shield-lock-fill text-success fs-5"></i>
                            <div><strong>Seguridad Garantizada:</strong> No almacenamos los datos de tu tarjeta. La transacción se realiza de forma directa y cifrada.</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary -->
                <div class="col-lg-4">
                    {{-- ... (Resumen igual) ... --}}
                    <div class="vs-card p-4 sticky-top border-0 shadow-sm" style="top: 2rem;">
                        <h5 class="fw-bold mb-4 border-bottom pb-3">Resumen del pedido</h5>
                        <div class="mb-4">
                            @foreach($items as $item)
                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                <div class="pe-2">
                                    <span class="text-dark fw-medium d-block text-sm">{{ $item['product']->name }}</span>
                                    <span class="text-muted text-xs">Cantidad: {{ $item['quantity'] }}</span>
                                </div>
                                <span class="fw-semibold text-dark">${{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                            
                            <div class="bg-light p-3 rounded-4 mt-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span class="text-dark">${{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Envío:</span>
                                    <span class="text-success fw-medium">¡Gratis!</span>
                                </div>
                                <hr class="my-3 opacity-10">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark fs-5">Total:</span>
                                    <span class="fw-bold fs-3 text-primary">${{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 rounded-pill fw-bold shadow-sm mb-3">
                            <i class="bi bi-lock-fill me-2"></i> Pagar ${{ number_format($total, 0, ',', '.') }}
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ route('user.cart.index') }}" class="btn btn-link btn-sm text-decoration-none text-muted hover-text-primary">
                                <i class="bi bi-arrow-left me-1"></i> Editar mi carrito
                            </a>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top text-center">
                            <img src="https://vladmihalcea.com/wp-content/uploads/2020/02/stripe-logo.png" height="25" class="opacity-50" style="filter: grayscale(100%)">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardName = document.getElementById('card_name');
    const cardNumber = document.getElementById('card_number');
    const expDate = document.getElementById('exp_date');
    const cvv = document.getElementById('cvv');

    const displayName = document.getElementById('display-name');
    const displayNumber = document.getElementById('display-number');
    const displayExpiry = document.getElementById('display-expiry');
    const visualCard = document.getElementById('visual-card');
    const brandIcon = document.getElementById('display-brand-icon');

    // Sincronizar Nombre
    cardName.addEventListener('input', (e) => {
        displayName.textContent = e.target.value.toUpperCase() || 'NOMBRE DEL TITULAR';
    });

    // Sincronizar Número (con formato)
    cardNumber.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        let formatted = '';
        for(let i = 0; i < value.length; i++) {
            if(i > 0 && i % 4 === 0) formatted += ' ';
            formatted += value[i];
        }
        e.target.value = formatted;
        displayNumber.textContent = formatted || '#### #### #### ####';

        // Cambio de color/icono según la marca (simulado)
        if (value.startsWith('4')) {
            visualCard.style.background = 'linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%)';
            brandIcon.className = 'bi bi-credit-card-2-front fs-2'; // Visa
        } else if (value.startsWith('5')) {
            visualCard.style.background = 'linear-gradient(135deg, #441010 0%, #dc2626 100%)';
            brandIcon.className = 'bi bi-credit-card fs-2'; // Mastercard
        } else {
            visualCard.style.background = 'linear-gradient(135deg, #1e293b 0%, #64748b 100%)';
            brandIcon.className = 'bi bi-credit-card-2-front fs-2';
        }
    });

    // Sincronizar Fecha
    expDate.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
        displayExpiry.textContent = value || 'MM/AA';
    });

    // Efecto CVV (Volteo opcional o solo resalte)
    cvv.addEventListener('focus', () => {
        visualCard.style.transform = 'scale(1.02) rotateY(10deg)';
    });
    cvv.addEventListener('blur', () => {
        visualCard.style.transform = 'scale(1) rotateY(0deg)';
    });
});
</script>
@endsection
