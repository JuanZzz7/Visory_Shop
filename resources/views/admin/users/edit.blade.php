@extends('layouts.dashboard')
@section('title','Editar Usuario - Admin')
@section('page-title','Editar Usuario')

@section('dashboard-content')
<div class="vs-card" style="max-width:600px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger border-0" style="background-color: rgba(220, 38, 38, 0.1); color: #dc2626;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
        @endif
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Nueva contraseña <span class="text-muted fw-normal">(dejar vacío para no cambiar)</span></label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Teléfono</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="mb-4">
                <label class="form-label text-sm fw-semibold text-dark">Rol</label>
                <select name="role" class="form-select" required>
                    <option value="user" {{ $user->role==='user'?'selected':'' }}>Usuario</option>
                    <option value="business" {{ $user->role==='business'?'selected':'' }}>Empresario</option>
                    <option value="admin" {{ $user->role==='admin'?'selected':'' }}>Administrador</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">Guardar cambios</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
