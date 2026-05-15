@extends('layouts.dashboard')
@section('title','Ventas y Egresos')
@section('page-title','Ventas e Información Financiera')

@section('sidebar-menu')
<a href="{{ route('business.dashboard') }}" class="vs-nav-link"><i class="bi bi-grid fs-5"></i> Inicio</a>
<a href="{{ route('business.company.edit') }}" class="vs-nav-link"><i class="bi bi-building fs-5"></i> Mi empresa</a>
<a href="{{ route('business.products.index') }}" class="vs-nav-link"><i class="bi bi-box fs-5"></i> Mis productos</a>
<a href="{{ route('business.expenses.index') }}" class="vs-nav-link active"><i class="bi bi-cash-stack fs-5"></i> Ventas y egresos</a>
@endsection

@section('dashboard-content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('business.expenses.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus me-1"></i>Registrar egreso</a>
</div>

<div class="vs-card">
    <div class="card-body p-0">
        <div class="p-3 border-bottom border-light">
            <h6 class="fw-semibold text-dark mb-0"><i class="bi bi-arrow-down-circle me-2 text-danger"></i>Egresos registrados</h6>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr><th>Concepto</th><th>Monto</th><th>Fecha</th><th>Descripción</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                @forelse($expenses as $expense)
                <tr>
                    <td class="fw-semibold text-dark">{{ $expense->concept }}</td>
                    <td class="text-danger fw-semibold">${{ number_format($expense->amount,0,',','.') }}</td>
                    <td class="text-muted">{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                    <td class="text-muted">{{ $expense->description ?? '-' }}</td>
                    <td>
                        <form action="{{ route('business.expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('¿Eliminar egreso?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-5">No hay egresos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">{{ $expenses->links() }}</div>
@endsection
