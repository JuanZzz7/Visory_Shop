@extends('layouts.dashboard')
@section('title','Mi Perfil - Spotlight')
@section('page-title','Mi Perfil')

@section('sidebar-menu')
<a href="{{ route('user.dashboard') }}" class="vs-nav-link"><i class="bi bi-shop fs-5"></i> Tienda</a>
<a href="{{ route('user.map') }}" class="vs-nav-link {{ request()->routeIs('user.map') ? 'active' : '' }}"><i class="bi bi-geo-alt fs-5"></i> Mapa de Empresas</a>
<a href="{{ route('user.profile.edit') }}" class="vs-nav-link active"><i class="bi bi-person fs-5"></i> Mi perfil</a>
<a href="{{ route('user.orders.index') }}" class="vs-nav-link"><i class="bi bi-bag-check fs-5"></i> Mis compras</a>
<a href="{{ route('user.cart.index') }}" class="vs-nav-link"><i class="bi bi-cart3 fs-5"></i> Carrito</a>
<a href="{{ route('chat.index') }}" class="vs-nav-link {{ request()->is('chat*') ? 'active' : '' }}">
    <i class="bi bi-chat-dots fs-5"></i> Mensajes
</a>
<a href="{{ route('chatbot.index') }}" class="vs-nav-link {{ request()->routeIs('chatbot.index') ? 'active' : '' }}">
    <i class="bi bi-robot fs-5"></i> Spotlight AI
</a>
@endsection

@section('dashboard-content')
<div class="vs-card" style="max-width:560px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger border-0" style="background-color: rgba(220, 38, 38, 0.1); color: #dc2626;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
        @endif
        <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" id="avatar-preview" width="100" height="100" class="rounded-circle mb-2 border-4 border-white shadow-sm" style="object-fit:cover">
                @else
                    <div id="avatar-placeholder" class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow-sm border-4 border-white" style="width:100px;height:100px;background:var(--vs-primary)">
                        <span class="text-white fw-bold fs-1">{{ strtoupper(substr($user->name,0,1)) }}</span>
                    </div>
                    <img src="" id="avatar-preview" width="100" height="100" class="rounded-circle mb-2 border-4 border-white shadow-sm d-none" style="object-fit:cover">
                @endif
                <label for="avatar-input" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow-sm border border-white cursor-pointer" style="width:32px; height:32px; display:flex; align-items:center; justify-content:center; cursor:pointer;">
                    <i class="bi bi-camera-fill" style="font-size: 0.8rem;"></i>
                </label>
            </div>
            <h5 class="fw-bold mb-0 text-dark mt-2">{{ $user->name }}</h5>
            <span class="text-muted text-sm">{{ $user->email }}</span>
        </div>
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <input type="file" name="avatar" id="avatar-input" class="d-none" accept="image/*">
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Nombre completo</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-sm fw-semibold text-dark">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-sm fw-semibold text-dark">Documento</label>
                    <input type="text" name="document" class="form-control" value="{{ old('document', $user->document) }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Dirección</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
            </div>
            <hr class="border-light my-4">
            <p class="text-muted text-sm mb-3">Cambiar contraseña <span class="fw-normal">(dejar vacío para no cambiar)</span></p>
            <div class="mb-3">
                <label class="form-label text-sm fw-semibold text-dark">Nueva contraseña</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-4">
                <label class="form-label text-sm fw-semibold text-dark">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100 shadow-sm py-2 fw-bold">Guardar cambios</button>
        </form>
    </div>
</div>

<script>
document.getElementById('avatar-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (placeholder) placeholder.classList.add('d-none');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
