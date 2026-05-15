@extends('layouts.dashboard')
@section('title','Nuevo Producto')
@section('page-title','Crear Producto')

@section('sidebar-menu')
<a href="{{ route('business.dashboard') }}" class="vs-nav-link"><i class="bi bi-grid fs-5"></i> Inicio</a>
<a href="{{ route('business.company.edit') }}" class="vs-nav-link"><i class="bi bi-building fs-5"></i> Mi empresa</a>
<a href="{{ route('business.products.index') }}" class="vs-nav-link active"><i class="bi bi-box fs-5"></i> Mis productos</a>
<a href="{{ route('business.expenses.index') }}" class="vs-nav-link"><i class="bi bi-cash-stack fs-5"></i> Ventas y egresos</a>
@endsection

@section('dashboard-content')
<div class="vs-card" style="max-width:600px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger border-0" style="background-color: rgba(220, 38, 38, 0.1); color: #dc2626;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
        @endif
        <form action="{{ route('business.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Nombre del producto *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Descripción</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label text-sm fw-semibold text-dark">Precio (COP) *</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" min="0" step="100" required>
                </div>
                <div class="col-6">
                    <label class="form-label text-sm fw-semibold text-dark">Stock *</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Imagen del producto</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-4 d-flex gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active',1)?'checked':'' }}>
                    <label class="form-check-label text-dark" for="active">Activo</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ old('featured')?'checked':'' }}>
                    <label class="form-check-label text-dark" for="featured"><i class="bi bi-star-fill me-1" style="color: var(--vs-secondary);"></i>Destacado</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">Crear producto</button>
                <a href="{{ route('business.products.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
