@extends('layouts.dashboard')
@section('title','Reportes - Admin')
@section('page-title','Reportes Generales')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}" class="vs-nav-link"><i class="bi bi-grid fs-5"></i> Panel principal</a>
<a href="{{ route('admin.users.index') }}" class="vs-nav-link"><i class="bi bi-people fs-5"></i> Gestión de usuarios</a>
<a href="{{ route('admin.companies.index') }}" class="vs-nav-link"><i class="bi bi-building fs-5"></i> Gestión de empresas</a>
<a href="{{ route('admin.products.index') }}" class="vs-nav-link"><i class="bi bi-box fs-5"></i> Gestión de productos</a>
<a href="{{ route('admin.reports.index') }}" class="vs-nav-link active"><i class="bi bi-bar-chart fs-5"></i> Reportes generales</a>
@endsection

@section('dashboard-content')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="vs-card h-100 p-2" style="border-left: 4px solid var(--vs-primary);">
            <div class="card-body">
                <div class="text-muted text-sm fw-medium mb-1">Total de ventas</div>
                <h2 class="fw-bold text-primary mb-1">{{ $totalOrders }}</h2>
                <span class="text-muted text-sm">órdenes completadas</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="vs-card h-100 p-2" style="border-left: 4px solid var(--vs-secondary);">
            <div class="card-body">
                <div class="text-muted text-sm fw-medium mb-1">Ingresos totales</div>
                <h2 class="fw-bold mb-1" style="color: var(--vs-secondary);">${{ number_format($totalRevenue,0,',','.') }}</h2>
                <span class="text-muted text-sm">COP acumulados</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="vs-card h-100">
            <div class="card-body p-0">
                <div class="p-3 border-bottom border-light">
                    <h6 class="fw-semibold text-dark mb-0"><i class="bi bi-trophy me-2" style="color: var(--vs-secondary);"></i>Top productos más vendidos</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Producto</th><th>Vendidos</th><th>Ingresos</th></tr></thead>
                        <tbody>
                        @forelse($topProducts as $item)
                        <tr>
                            <td class="fw-semibold text-dark">{{ $item->product->name ?? '-' }}</td>
                            <td><span class="badge badge-soft-success rounded-pill px-3 py-1">{{ $item->total_sold }}</span></td>
                            <td class="fw-medium text-primary">${{ number_format($item->revenue,0,',','.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">Sin datos</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="vs-card h-100">
            <div class="card-body p-0">
                <div class="p-3 border-bottom border-light">
                    <h6 class="fw-semibold text-dark mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Ventas recientes</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Usuario</th><th>Total</th><th>Estado</th><th>Fecha</th></tr></thead>
                        <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="fw-semibold text-dark">{{ $order->user->name ?? '-' }}</td>
                            <td class="fw-medium text-primary">${{ number_format($order->total,0,',','.') }}</td>
                            <td><span class="badge badge-soft-success rounded-pill px-3 py-1">{{ ucfirst($order->status) }}</span></td>
                            <td class="text-muted">{{ $order->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Sin ventas</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
