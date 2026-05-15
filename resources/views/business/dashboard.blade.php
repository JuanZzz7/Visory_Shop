@extends('layouts.dashboard')
@section('title','Empresario - Spotlight')
@section('page-title','Panel Empresario')

@section('sidebar-menu')
<a href="{{ route('business.dashboard') }}" class="vs-nav-link {{ request()->routeIs('business.dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid fs-5"></i> Inicio
</a>
<a href="{{ route('business.company.edit') }}" class="vs-nav-link {{ request()->routeIs('business.company*') ? 'active' : '' }}">
    <i class="bi bi-building fs-5"></i> Mi empresa
</a>
<a href="{{ route('business.products.index') }}" class="vs-nav-link {{ request()->routeIs('business.products*') ? 'active' : '' }}">
    <i class="bi bi-box fs-5"></i> Mis productos
</a>
<a href="{{ route('business.expenses.index') }}" class="vs-nav-link {{ request()->routeIs('business.expenses*') ? 'active' : '' }}">
    <i class="bi bi-cash-stack fs-5"></i> Ventas y egresos
</a>
<a href="{{ route('chat.index') }}" class="vs-nav-link {{ request()->is('chat*') ? 'active' : '' }}">
    <i class="bi bi-chat-dots fs-5"></i> Mensajes
</a>
@endsection

@section('dashboard-content')
@if(!$company)
    <div class="alert alert-warning border-0" style="background-color: rgba(217, 119, 6, 0.1); color: #d97706;">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Aún no has configurado tu empresa. <a href="{{ route('business.company.edit') }}" class="fw-semibold text-decoration-underline" style="color: #d97706;">Completa tu perfil empresarial</a> para empezar a vender.
    </div>
@else
    @if($company->status === 'pending')
    <div class="alert alert-warning border-0 d-flex align-items-center mb-4 shadow-sm" style="background-color: #fffbeb; color: #92400e;">
        <i class="bi bi-clock-history fs-4 me-3 text-warning"></i>
        <div>
            <h6 class="mb-1 fw-bold">Cuenta pendiente de validación</h6>
            <p class="mb-0 text-sm">Tus documentos están siendo revisados por nuestro equipo. Durante este tiempo, tus productos y tu perfil de empresa no serán visibles al público.</p>
        </div>
    </div>
    @elseif($company->status === 'inactive')
    <div class="alert alert-danger border-0 d-flex align-items-center mb-4 shadow-sm" style="background-color: #fef2f2; color: #991b1b;">
        <i class="bi bi-x-circle fs-4 me-3 text-danger"></i>
        <div>
            <h6 class="mb-1 fw-bold">Cuenta no aprobada o suspendida</h6>
            <p class="mb-0 text-sm">Hubo un problema con la validación de tus documentos. Por favor, revisa tu correo electrónico para más detalles o actualiza tus datos en "Mi empresa".</p>
        </div>
    </div>
    @endif
    {{-- Branding Header --}}
    <div class="vs-card overflow-hidden mb-4 p-0">
        <div style="height: 160px; position: relative; background: linear-gradient(to right, #f8fafc, #e2e8f0);">
            @if($company->banner)
                <img src="{{ asset('storage/'.$company->banner) }}" class="w-100 h-100" style="object-fit: cover;">
            @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-image text-muted opacity-25" style="font-size: 4rem;"></i>
                </div>
            @endif
            
            <div class="position-absolute" style="bottom: -30px; left: 30px;">
                <div class="vs-card p-1 rounded-circle bg-white shadow" style="width: 80px; height: 80px;">
                    <div class="w-100 h-100 rounded-circle bg-light overflow-hidden d-flex align-items-center justify-content-center">
                        @if($company->logo)
                            <img src="{{ asset('storage/'.$company->logo) }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <i class="bi bi-building text-muted fs-3"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4 pt-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-0">{{ $company->name }}</h4>
                    <p class="text-muted mb-0"><i class="bi bi-tag-fill me-1 text-primary"></i>{{ $company->category }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('business.company.edit') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                        <i class="bi bi-pencil me-1"></i> Personalizar Perfil
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-semibold border">
                        <i class="bi bi-eye me-1"></i> Ver Tienda
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row g-4 mb-4">
    @php
    $cards = [
        ['label'=>'Ingresos totales','value'=>'$'.number_format($income,0,',','.'),'icon'=>'bi-arrow-up-circle','color'=>'#00236f'],
        ['label'=>'Egresos totales','value'=>'$'.number_format($expenses,0,',','.'),'icon'=>'bi-arrow-down-circle','color'=>'#0d9488'],
        ['label'=>'Ganancia neta','value'=>'$'.number_format($net,0,',','.'),'icon'=>'bi-graph-up-arrow','color'=>'#1e3a8a'],
        ['label'=>'Productos','value'=>$company?$company->products->count():0,'icon'=>'bi-box','color'=>'#0f766e'],
    ];
    @endphp
    @foreach($cards as $c)
    <div class="col-sm-6 col-xl-3">
        <div class="vs-card h-100 p-2" style="border-left: 4px solid {{ $c['color'] }};">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:{{ $c['color'] }}15">
                    <i class="bi {{ $c['icon'] }} fs-5" style="color:{{ $c['color'] }}"></i>
                </div>
                <div>
                    <div class="text-muted text-sm fw-medium">{{ $c['label'] }}</div>
                    <div class="fw-bold fs-5 text-dark">{{ $c['value'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="vs-card">
    <div class="card-body p-0">
        <div class="p-3 border-bottom border-light">
            <h6 class="fw-semibold text-dark mb-0"><i class="bi bi-clock-history me-2"></i>Últimas ventas</h6>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr><th>Producto</th><th>Comprador</th><th>Cant.</th><th>Total</th><th>Fecha</th></tr>
                </thead>
                <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td class="fw-semibold text-dark">{{ $sale->product->name ?? '-' }}</td>
                    <td class="text-muted">{{ $sale->order->user->name ?? '-' }}</td>
                    <td class="text-dark">{{ $sale->quantity }}</td>
                    <td class="fw-medium text-primary">${{ number_format($sale->subtotal,0,',','.') }}</td>
                    <td class="text-muted">{{ $sale->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-5">No hay ventas registradas aún.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
