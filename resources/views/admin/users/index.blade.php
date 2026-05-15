@extends('layouts.dashboard')
@section('title','Usuarios - Admin')
@section('page-title','Gestión de Usuarios')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}" class="vs-nav-link"><i class="bi bi-grid fs-5"></i> Panel principal</a>
<a href="{{ route('admin.users.index') }}" class="vs-nav-link active"><i class="bi bi-people fs-5"></i> Gestión de usuarios</a>
<a href="{{ route('admin.companies.index') }}" class="vs-nav-link"><i class="bi bi-building fs-5"></i> Gestión de empresas</a>
<a href="{{ route('admin.products.index') }}" class="vs-nav-link"><i class="bi bi-box fs-5"></i> Gestión de productos</a>
<a href="{{ route('admin.reports.index') }}" class="vs-nav-link"><i class="bi bi-bar-chart fs-5"></i> Reportes generales</a>
@endsection

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex gap-2">
        <a href="?role=user" class="btn {{ $role==='user'?'btn-primary':'btn-outline-primary' }} rounded-pill px-4">Usuarios</a>
        <a href="?role=business" class="btn {{ $role==='business'?'btn-primary':'btn-outline-primary' }} rounded-pill px-4">Empresarios</a>
        <a href="?role=admin" class="btn {{ $role==='admin'?'btn-primary':'btn-outline-primary' }} rounded-pill px-4">Admins</a>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus me-1"></i>Nuevo usuario</a>
</div>
<div class="vs-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Estado</th><th>Registro</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="fw-semibold text-dark">{{ $user->name }}</td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td><span class="badge badge-soft-primary rounded-pill px-3 py-1">{{ ucfirst($user->role) }}</span></td>
                    <td>
                        <span class="badge {{ $user->active ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill px-3 py-1">
                            {{ $user->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm {{ $user->active?'btn-outline-warning':'btn-outline-success' }}">
                                    <i class="bi {{ $user->active?'bi-pause':'bi-play' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">No hay usuarios registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">{{ $users->appends(request()->query())->links() }}</div>
@endsection
