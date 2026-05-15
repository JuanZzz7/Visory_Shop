@extends('layouts.dashboard')
@section('title','Admin - Spotlight')
@section('page-title','Panel Administrador')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}" class="vs-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid fs-5"></i> Panel principal
</a>
<a href="{{ route('admin.users.index') }}" class="vs-nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
    <i class="bi bi-people fs-5"></i> Gestión de usuarios
</a>
<a href="{{ route('admin.companies.index') }}" class="vs-nav-link {{ request()->routeIs('admin.companies*') ? 'active' : '' }}">
    <i class="bi bi-building fs-5"></i> Gestión de empresas
</a>
<a href="{{ route('admin.products.index') }}" class="vs-nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
    <i class="bi bi-box fs-5"></i> Gestión de productos
</a>
<a href="{{ route('admin.reports.index') }}" class="vs-nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
    <i class="bi bi-bar-chart fs-5"></i> Reportes generales
</a>
<a href="{{ route('chat.index') }}" class="vs-nav-link {{ request()->is('chat*') ? 'active' : '' }}">
    <i class="bi bi-chat-dots fs-5"></i> Mensajes
</a>
@endsection

@section('dashboard-content')
<div class="row g-4 mb-4">
    @php
    $cards = [
        ['icon'=>'bi-people','label'=>'Usuarios','value'=>$stats['users'],'color'=>'#00236f'],
        ['icon'=>'bi-briefcase','label'=>'Empresarios','value'=>$stats['businesses'],'color'=>'#0d9488'],
        ['icon'=>'bi-building','label'=>'Empresas','value'=>$stats['companies'],'color'=>'#1e3a8a'],
        ['icon'=>'bi-box','label'=>'Productos','value'=>$stats['products'],'color'=>'#0f766e'],
        ['icon'=>'bi-cart-check','label'=>'Ventas','value'=>$stats['orders'],'color'=>'#00236f'],
        ['icon'=>'bi-currency-dollar','label'=>'Ingresos Totales','value'=>'$'.number_format($stats['revenue'],0,',','.'),'color'=>'#0d9488'],
    ];
    @endphp
    @foreach($cards as $card)
    <div class="col-sm-6 col-xl-4">
        <div class="vs-card h-100 p-2" style="border-left: 4px solid {{ $card['color'] }};">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:52px;height:52px;background:{{ $card['color'] }}15">
                    <i class="bi {{ $card['icon'] }} fs-4" style="color:{{ $card['color'] }}"></i>
                </div>
                <div>
                    <div class="text-muted text-sm fw-medium">{{ $card['label'] }}</div>
                    <div class="fw-bold fs-4 text-dark">{{ $card['value'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="vs-card p-2">
    <div class="card-body">
        <h6 class="fw-semibold text-dark mb-3">Acceso rápido</h6>
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-plus me-1"></i>Gestionar usuarios</a>
            <a href="{{ route('admin.companies.index') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-building me-1"></i>Ver empresas</a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-box me-1"></i>Ver productos</a>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-bar-chart me-1"></i>Ver reportes</a>
        </div>
    </div>
</div>
@endsection
