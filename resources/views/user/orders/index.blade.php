@extends('layouts.dashboard')
@section('title','Mis Compras - Spotlight')
@section('page-title','Mis Compras')

@section('sidebar-menu')
<a href="{{ route('user.dashboard') }}" class="vs-nav-link"><i class="bi bi-shop fs-5"></i> Tienda</a>
<a href="{{ route('user.map') }}" class="vs-nav-link {{ request()->routeIs('user.map') ? 'active' : '' }}"><i class="bi bi-geo-alt fs-5"></i> Mapa de Empresas</a>
<a href="{{ route('user.profile.edit') }}" class="vs-nav-link"><i class="bi bi-person fs-5"></i> Mi perfil</a>
<a href="{{ route('user.orders.index') }}" class="vs-nav-link active"><i class="bi bi-bag-check fs-5"></i> Mis compras</a>
<a href="{{ route('user.cart.index') }}" class="vs-nav-link"><i class="bi bi-cart3 fs-5"></i> Carrito</a>
<a href="{{ route('chat.index') }}" class="vs-nav-link {{ request()->is('chat*') ? 'active' : '' }}">
    <i class="bi bi-chat-dots fs-5"></i> Mensajes
</a>
<a href="{{ route('chatbot.index') }}" class="vs-nav-link {{ request()->routeIs('chatbot.index') ? 'active' : '' }}">
    <i class="bi bi-robot fs-5"></i> Spotlight AI
</a>
@endsection

@section('dashboard-content')
@forelse($orders as $order)
<div class="vs-card mb-4">
    <div class="card-body p-0">
        <div class="p-3 border-bottom border-light d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-semibold text-dark">Orden #{{ $order->id }}</span>
                <span class="text-muted text-sm ms-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-primary">${{ number_format($order->total,0,',','.') }}</span>
                <span class="badge {{ match($order->status) { 'paid'=>'badge-soft-success','shipped'=>'bg-info text-white','delivered'=>'badge-soft-primary',default=>'bg-light text-muted border' } }} rounded-pill px-3 py-1">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Producto</th><th>Empresa</th><th>Cant.</th><th>Precio unit.</th><th>Subtotal</th></tr></thead>
                <tbody>
                @foreach($order->details as $detail)
                <tr>
                    <td class="fw-semibold text-dark">{{ $detail->product->name ?? 'Producto eliminado' }}</td>
                    <td class="text-muted">{{ $detail->product->company->name ?? '-' }}</td>
                    <td class="text-dark">{{ $detail->quantity }}</td>
                    <td class="text-muted">${{ number_format($detail->unit_price,0,',','.') }}</td>
                    <td class="fw-medium text-primary">${{ number_format($detail->subtotal,0,',','.') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@empty
<div class="text-center py-5">
    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 100px; height: 100px;">
        <i class="bi bi-bag-x text-muted" style="font-size: 3rem;"></i>
    </div>
    <h4 class="fw-bold text-dark mt-3">Aún no has realizado compras</h4>
    <p class="text-muted">Explora la tienda y encuentra productos que te gusten.</p>
    <a href="{{ route('user.dashboard') }}" class="btn btn-primary px-4 rounded-pill shadow-sm mt-2">Ir a la tienda</a>
</div>
@endforelse
<div class="mt-4 d-flex justify-content-center">{{ $orders->links() }}</div>
@endsection
