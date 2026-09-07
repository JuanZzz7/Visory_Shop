@extends('layouts.dashboard')
@section('title','Registrar Egreso')
@section('page-title','Registrar Egreso')

@section('dashboard-content')
<div class="vs-card" style="max-width:500px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger border-0" style="background-color: rgba(220, 38, 38, 0.1); color: #dc2626;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
        @endif
        <form action="{{ route('business.expenses.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Concepto *</label>
                <input type="text" name="concept" class="form-control" value="{{ old('concept') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Monto (COP) *</label>
                <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" min="0" step="100" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Fecha *</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-sm fw-semibold text-dark">Descripción</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">Registrar egreso</button>
                <a href="{{ route('business.expenses.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
