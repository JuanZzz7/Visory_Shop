@extends('layouts.dashboard')
@section('title','Mis Productos - Spotlight')
@section('page-title','Gestión de Productos')

@section('sidebar-menu')
<a href="{{ route('business.dashboard') }}" class="vs-nav-link"><i class="bi bi-grid fs-5"></i> Inicio</a>
<a href="{{ route('business.company.edit') }}" class="vs-nav-link"><i class="bi bi-building fs-5"></i> Mi empresa</a>
<a href="{{ route('business.products.index') }}" class="vs-nav-link active"><i class="bi bi-box fs-5"></i> Mis productos</a>
<a href="{{ route('business.expenses.index') }}" class="vs-nav-link"><i class="bi bi-cash-stack fs-5"></i> Ventas y egresos</a>
@endsection

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <span class="text-muted text-sm fw-medium">{{ $products->total() ?? 0 }} productos registrados</span>
    <a href="{{ route('business.products.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus me-1"></i>Nuevo producto</a>
</div>

@if(!$company)
    <div class="alert alert-warning border-0" style="background-color: rgba(217, 119, 6, 0.1); color: #d97706;">
        <i class="bi bi-exclamation-triangle me-2"></i>Debes <a href="{{ route('business.company.edit') }}" class="fw-semibold text-decoration-underline" style="color: #d97706;">configurar tu empresa</a> antes de agregar productos.
    </div>
@endif

<div class="row g-4">
@forelse($products as $product)
<div class="col-md-6 col-lg-4">
    <div class="vs-card h-100 overflow-hidden d-flex flex-column">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" style="height:180px;object-fit:cover" alt="{{ $product->name }}">
        @else
            <div class="d-flex align-items-center justify-content-center bg-light" style="height:180px;">
                <i class="bi bi-image text-muted" style="font-size:3rem; opacity: 0.4;"></i>
            </div>
        @endif
        <div class="card-body flex-fill">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="fw-semibold mb-0 text-dark text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                <span class="badge {{ $product->active?'badge-soft-success':'bg-light text-muted border' }} rounded-pill px-2 py-1 ms-2 flex-shrink-0">{{ $product->active?'Activo':'Inactivo' }}</span>
            </div>
            <div class="fw-bold fs-5 mb-2 text-primary">${{ number_format($product->price,0,',','.') }}</div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-soft-primary rounded-pill px-3 py-1"><i class="bi bi-box-seam me-1"></i>Stock: {{ $product->stock }}</span>
                @if($product->featured)
                    <span class="badge badge-soft-warning rounded-pill px-3 py-1"><i class="bi bi-star-fill me-1"></i>Destacado</span>
                @endif
            </div>
        </div>
        <div class="card-footer bg-white border-top d-flex gap-2 p-3">
            <a href="{{ route('business.products.edit', $product) }}" class="btn btn-sm btn-outline-primary flex-fill"><i class="bi bi-pencil me-1"></i>Editar</a>
            <form action="{{ route('business.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar producto?')" class="flex-fill">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-trash me-1"></i>Eliminar</button>
            </form>
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="text-center py-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 80px; height: 80px;">
            <i class="bi bi-box text-muted fs-1"></i>
        </div>
        <h5 class="fw-semibold text-dark">No tienes productos aún</h5>
        <p class="text-muted">Empieza agregando tu primer producto. <a href="{{ route('business.products.create') }}" class="text-primary fw-semibold text-decoration-none">Crear producto</a>.</p>
    </div>
</div>
@endforelse
</div>
<div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
@endsection
