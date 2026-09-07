@extends('layouts.dashboard')
@section('title','Tienda - Spotlight')
@section('page-title','Explorar Productos')

@section('dashboard-content')
{{-- Filtros --}}
<div class="vs-card mb-4">
    <div class="card-body py-3">
        <form action="{{ route('user.dashboard') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-xs text-muted mb-1 text-uppercase fw-semibold">Buscar producto</label>
                <input type="text" name="q" class="form-control" placeholder="Ej: Laptop..." value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-xs text-muted mb-1 text-uppercase fw-semibold">Categoría</label>
                <select name="category" class="form-select">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category')===$cat?'selected':'' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-xs text-muted mb-1 text-uppercase fw-semibold">Empresa</label>
                <select name="company_id" class="form-select">
                    <option value="">Todas las empresas</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id')==$company->id?'selected':'' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"><i class="bi bi-search me-2"></i>Filtrar</button>
            </div>
        </form>
    </div>
</div>

{{-- Productos --}}
<div class="row g-4">
@forelse($products as $product)
<div class="col-sm-6 col-lg-4 col-xl-3">
    <div class="vs-card h-100 overflow-hidden d-flex flex-column">
        <img src="{{ $product->image_url }}" class="card-img-top" style="height:180px;object-fit:cover" alt="{{ $product->name }}">
        <div class="card-body d-flex flex-column flex-fill">
            <h6 class="fw-semibold mb-1 text-dark text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
            <div class="d-flex align-items-center text-muted text-sm mb-2">
                <i class="bi bi-shop me-1"></i> <span class="text-truncate">{{ $product->company->name }}</span>
            </div>
            <div class="fw-bold fs-4 mb-3 text-primary mt-2">${{ number_format($product->price,0,',','.') }}</div>
            
            <div class="d-flex justify-content-between align-items-center mt-auto mb-3">
                <span class="badge badge-soft-success rounded-pill px-3 py-2">
                    <i class="bi bi-box-seam me-1"></i> Stock: {{ $product->stock }}
                </span>
            </div>
            
            <div class="mt-2">
                @if($product->stock > 0)
                <form action="{{ route('user.cart.add', $product) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center" style="width:70px">
                    <button class="btn btn-secondary flex-fill fw-semibold"><i class="bi bi-cart-plus me-1"></i>Añadir</button>
                </form>
                @else
                    <button class="btn btn-light w-100 text-muted fw-medium" disabled><i class="bi bi-x-circle me-1"></i>Agotado</button>
                @endif
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 py-5 text-center">
    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 80px; height: 80px;">
        <i class="bi bi-search text-muted fs-1"></i>
    </div>
    <h5 class="fw-semibold text-dark">No se encontraron productos</h5>
    <p class="text-muted">Intenta cambiar los filtros de búsqueda o categoría.</p>
</div>
@endforelse
</div>
<div class="mt-4 d-flex justify-content-center">{{ $products->appends(request()->query())->links() }}</div>
@endsection
