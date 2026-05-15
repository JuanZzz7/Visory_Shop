@extends('layouts.dashboard')
@section('title','Nuevo Usuario - Admin')
@section('page-title','Crear Usuario')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}" class="vs-nav-link"><i class="bi bi-grid fs-5"></i> Panel principal</a>
<a href="{{ route('admin.users.index') }}" class="vs-nav-link active"><i class="bi bi-people fs-5"></i> Gestión de usuarios</a>
<a href="{{ route('admin.companies.index') }}" class="vs-nav-link"><i class="bi bi-building fs-5"></i> Gestión de empresas</a>
<a href="{{ route('admin.products.index') }}" class="vs-nav-link"><i class="bi bi-box fs-5"></i> Gestión de productos</a>
<a href="{{ route('admin.reports.index') }}" class="vs-nav-link"><i class="bi bi-bar-chart fs-5"></i> Reportes generales</a>
@endsection

@section('dashboard-content')
<div class="vs-card" style="max-width:600px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger border-0" style="background-color: rgba(220, 38, 38, 0.1); color: #dc2626;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
        @endif
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Teléfono</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <div class="mb-4">
                <label class="form-label text-sm fw-semibold text-dark">Rol</label>
                <select name="role" class="form-select" required>
                    <option value="user" {{ old('role')==='user'?'selected':'' }}>Usuario</option>
                    <option value="business" {{ old('role')==='business'?'selected':'' }}>Empresario</option>
                    <option value="admin" {{ old('role')==='admin'?'selected':'' }}>Administrador</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">Crear usuario</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
