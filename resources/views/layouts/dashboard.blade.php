@extends('layouts.app')
@section('content')
<div class="d-flex position-relative">
    {{-- Sidebar Overlay for Mobile --}}
    <div class="vs-sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    <div class="vs-sidebar vs-sidebar-dark d-flex flex-column p-0" id="sidebar">
        <div class="p-4 border-bottom" style="border-color: rgba(255,255,255,0.1) !important;">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <img src="{{ asset('images/logo.png') }}" alt="Spotlight" class="vs-brand-logo">
                </a>
                <button class="btn btn-link text-white d-lg-none p-0" id="sidebarClose">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>
            </div>
            <div class="text-white-50 text-xs text-uppercase fw-semibold tracking-wide">
                {{ auth()->user()->role === 'admin' ? 'Administrador' : (auth()->user()->role === 'business' ? 'Empresario' : 'Usuario') }}
            </div>
            <div class="text-white text-sm fw-medium text-truncate mt-1">{{ auth()->user()->name }}</div>
        </div>
        <nav class="flex-fill p-3 d-flex flex-column gap-1">
            @yield('sidebar-menu')
        </nav>
        <div class="p-3 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-light w-100 d-flex justify-content-center align-items-center gap-2" style="border-color: rgba(255,255,255,0.2);">
                    <i class="bi bi-box-arrow-left"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </div>

    {{-- Main --}}
    <div class="flex-fill bg-body" style="min-height: 100vh; width: 100%; overflow-y: auto;">
        <nav class="vs-topbar d-flex align-items-center gap-3">
            <button class="btn btn-link text-dark d-lg-none p-0" id="sidebarToggle">
                <i class="bi bi-list fs-3"></i>
            </button>
            <h4 class="mb-0 fw-semibold text-dark text-truncate">@yield('page-title', 'Panel')</h4>
            <div class="ms-auto d-flex align-items-center gap-2">
                <span class="text-muted small d-none d-sm-inline">{{ auth()->user()->email }}</span>
                @if(auth()->user()->role === 'user')
                    <a href="{{ route('user.cart.index') }}" class="btn btn-sm btn-outline-primary position-relative">
                        <i class="bi bi-cart3"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.6rem">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                @endif
            </div>
        </nav>
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 rounded-3"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3"><i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if($errors->any())
                <div class="alert alert-warning alert-dismissible fade show border-0 rounded-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Error al guardar:</strong> {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('dashboard-content')
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }

        if(sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
        if(sidebarClose) sidebarClose.addEventListener('click', toggleSidebar);
        if(sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);
    });
</script>
@endpush
@endsection
