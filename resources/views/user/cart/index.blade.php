@extends('layouts.dashboard')
@section('title','Carrito - Spotlight')
@section('page-title','Carrito de Compras')

@section('sidebar-menu')
<a href="{{ route('user.dashboard') }}" class="vs-nav-link"><i class="bi bi-shop fs-5"></i> Tienda</a>
<a href="{{ route('user.profile.edit') }}" class="vs-nav-link"><i class="bi bi-person fs-5"></i> Mi perfil</a>
<a href="{{ route('user.orders.index') }}" class="vs-nav-link"><i class="bi bi-bag-check fs-5"></i> Mis compras</a>
<a href="{{ route('user.map') }}" class="vs-nav-link {{ request()->routeIs('user.map') ? 'active' : '' }}"><i class="bi bi-geo-alt fs-5"></i> Mapa de Empresas</a>
<a href="{{ route('user.cart.index') }}" class="vs-nav-link active"><i class="bi bi-cart3 fs-5"></i> Carrito</a>
<a href="{{ route('chat.index') }}" class="vs-nav-link {{ request()->is('chat*') ? 'active' : '' }}">
    <i class="bi bi-chat-dots fs-5"></i> Mensajes
</a>
<a href="{{ route('chatbot.index') }}" class="vs-nav-link {{ request()->routeIs('chatbot.index') ? 'active' : '' }}">
    <i class="bi bi-robot fs-5"></i> Spotlight AI
</a>
@endsection

@section('dashboard-content')
@if(empty($items))
    <div class="text-center py-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 100px; height: 100px;">
            <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
        </div>
        <h4 class="fw-bold text-dark mt-3">Tu carrito está vacío</h4>
        <p class="text-muted">Explora la tienda y agrega productos a tu carrito.</p>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary px-4 rounded-pill shadow-sm mt-2">Ir a la tienda</a>
    </div>
@else
<div class="row g-4">
    <div class="col-lg-8">
        <div class="vs-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th></th></tr></thead>
                        <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($item['product']->image)
                                        <img src="{{ asset('storage/'.$item['product']->image) }}" width="48" height="48" class="rounded border" style="object-fit:cover">
                                    @endif
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $item['product']->name }}</div>
                                        <span class="text-muted text-sm">{{ $item['product']->company->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted">${{ number_format($item['product']->price,0,',','.') }}</td>
                            <td>
                                <form action="{{ route('user.cart.update', $item['product']) }}" method="POST" class="d-flex align-items-center gap-1">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}" class="form-control text-center" style="width:65px" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="fw-bold text-primary">${{ number_format($item['subtotal'],0,',','.') }}</td>
                            <td>
                                <form action="{{ route('user.cart.remove', $item['product']) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="vs-card" style="position: sticky; top: 1rem;">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-4">Resumen del pedido</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="text-dark fw-medium">${{ number_format($total,0,',','.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Envío</span>
                    <span class="badge badge-soft-success rounded-pill px-3 py-1">Gratis</span>
                </div>
                <hr class="border-light">
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-5 text-dark">Total</span>
                    <span class="fw-bold fs-5 text-primary">${{ number_format($total,0,',','.') }}</span>
                </div>
                <a href="{{ route('user.cart.checkout') }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">
                    Continuar al pago <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary w-100 mt-2">Seguir comprando</a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
