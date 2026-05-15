@extends('layouts.dashboard')
@section('title','Productos - Admin')
@section('page-title','Gestión de Productos')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}" class="vs-nav-link"><i class="bi bi-grid fs-5"></i> Panel principal</a>
<a href="{{ route('admin.users.index') }}" class="vs-nav-link"><i class="bi bi-people fs-5"></i> Gestión de usuarios</a>
<a href="{{ route('admin.companies.index') }}" class="vs-nav-link"><i class="bi bi-building fs-5"></i> Gestión de empresas</a>
<a href="{{ route('admin.products.index') }}" class="vs-nav-link active"><i class="bi bi-box fs-5"></i> Gestión de productos</a>
<a href="{{ route('admin.reports.index') }}" class="vs-nav-link"><i class="bi bi-bar-chart fs-5"></i> Reportes generales</a>
@endsection

@section('dashboard-content')
<div class="vs-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr><th>Producto</th><th>Empresa</th><th>Precio</th><th>Stock</th><th>Estado</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" width="36" height="36" class="rounded border" style="object-fit:cover">
                            @else
                                <div class="rounded d-flex align-items-center justify-content-center bg-light border" style="width:36px;height:36px">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                            <span class="fw-semibold text-dark">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $product->company->name ?? '-' }}</td>
                    <td class="fw-semibold text-primary">${{ number_format($product->price,0,',','.') }}</td>
                    <td>
                        <span class="badge {{ $product->stock > 0 ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill px-3 py-1">{{ $product->stock }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $product->active ? 'badge-soft-success' : 'bg-light text-muted border' }} rounded-pill px-3 py-1">
                            {{ $product->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <form action="{{ route('admin.products.toggle', $product) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm {{ $product->active?'btn-outline-warning':'btn-outline-success' }}">
                                    <i class="bi {{ $product->active?'bi-pause':'bi-play' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar producto?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">No hay productos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
@endsection
