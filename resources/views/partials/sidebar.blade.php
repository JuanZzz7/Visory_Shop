@php
    $user = auth()->user();
    $role = $user->role;
@endphp

@if($role === 'admin')
    <a href="{{ route('admin.dashboard') }}" class="vs-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid fs-5"></i> Panel principal
    </a>
    <a href="{{ route('admin.users.index') }}" class="vs-nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <i class="bi bi-people fs-5"></i> Usuarios
    </a>
    <a href="{{ route('admin.companies.index') }}" class="vs-nav-link {{ request()->routeIs('admin.companies*') ? 'active' : '' }}">
        <i class="bi bi-building fs-5"></i> Empresas
    </a>
    <a href="{{ route('admin.products.index') }}" class="vs-nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
        <i class="bi bi-box fs-5"></i> Productos
    </a>
    <a href="{{ route('admin.reports.index') }}" class="vs-nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
        <i class="bi bi-bar-chart fs-5"></i> Reportes
    </a>
@elseif($role === 'business')
    <a href="{{ route('business.dashboard') }}" class="vs-nav-link {{ request()->routeIs('business.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid fs-5"></i> Inicio
    </a>
    <a href="{{ route('business.company.edit') }}" class="vs-nav-link {{ request()->routeIs('business.company*') ? 'active' : '' }}">
        <i class="bi bi-building fs-5"></i> Mi empresa
    </a>
    <a href="{{ route('business.products.index') }}" class="vs-nav-link {{ request()->routeIs('business.products*') ? 'active' : '' }}">
        <i class="bi bi-box fs-5"></i> Mis productos
    </a>
    <a href="{{ route('business.expenses.index') }}" class="vs-nav-link {{ request()->routeIs('business.expenses*') ? 'active' : '' }}">
        <i class="bi bi-cash-stack fs-5"></i> Ventas y egresos
    </a>
@else
    <a href="{{ route('user.dashboard') }}" class="vs-nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="bi bi-shop fs-5"></i> Tienda
    </a>
    <a href="{{ route('user.profile.edit') }}" class="vs-nav-link {{ request()->routeIs('user.profile*') ? 'active' : '' }}">
        <i class="bi bi-person fs-5"></i> Mi perfil
    </a>
    <a href="{{ route('user.orders.index') }}" class="vs-nav-link {{ request()->routeIs('user.orders*') ? 'active' : '' }}">
        <i class="bi bi-bag-check fs-5"></i> Mis compras
    </a>
    <a href="{{ route('user.cart.index') }}" class="vs-nav-link {{ request()->routeIs('user.cart*') ? 'active' : '' }}">
        <i class="bi bi-cart3 fs-5"></i> Carrito
        @if(session('cart') && count(session('cart')) > 0)
            <span class="badge ms-auto" style="background-color: var(--vs-secondary);">{{ count(session('cart')) }}</span>
        @endif
    </a>
@endif

<a href="{{ route('chat.index') }}" class="vs-nav-link {{ request()->is('chat*') ? 'active' : '' }}" id="sidebar-messages-link">
    <i class="bi bi-chat-dots fs-5"></i> Mensajes
    <span id="unread-badge" class="badge ms-auto d-none" style="background-color: #ef4444; font-size: 0.65rem; min-width: 18px; border-radius: 9px; animation: pulse-badge 1.5s infinite;"></span>
</a>

{{-- Toast de nuevo mensaje --}}
<div id="new-msg-toast" style="
    display: none;
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: #fff;
    padding: 14px 20px;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.35);
    min-width: 280px;
    max-width: 340px;
    cursor: pointer;
    border-left: 4px solid #6366f1;
    backdrop-filter: blur(8px);
    transition: all 0.3s ease;
">
    <div class="d-flex align-items-center gap-3">
        <div style="background: rgba(99,102,241,0.2); border-radius: 50%; width: 42px; height: 42px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="bi bi-chat-dots-fill" style="color:#818cf8; font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-weight:700; font-size:0.85rem; margin-bottom:2px;">💬 Nuevos mensajes</div>
            <div id="toast-msg-text" style="font-size:0.78rem; color:#94a3b8; line-height:1.3;">Tienes mensajes sin leer</div>
        </div>
        <button onclick="document.getElementById('new-msg-toast').style.display='none'" style="background:none;border:none;color:#64748b;margin-left:auto;font-size:1.1rem;line-height:1;padding:0;" title="Cerrar">✕</button>
    </div>
</div>

<style>
@keyframes pulse-badge {
    0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239,68,68,0.5); }
    50%       { transform: scale(1.15); box-shadow: 0 0 0 5px rgba(239,68,68,0); }
}
</style>

<script>
(function() {
    const badge   = document.getElementById('unread-badge');
    const toast   = document.getElementById('new-msg-toast');
    const toastTxt = document.getElementById('toast-msg-text');
    const apiUrl  = "{{ route('chat.unread.count') }}";
    const chatUrl = "{{ route('chat.index') }}";

    let prevCount = null;
    let toastTimer = null;

    // Al hacer clic en el toast, ir a mensajes
    if (toast) {
        toast.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON') return;
            window.location.href = chatUrl;
        });
    }

    function showToast(count) {
        if (!toast) return;
        toastTxt.textContent = count === 1
            ? 'Tienes 1 mensaje sin leer'
            : `Tienes ${count} mensajes sin leer`;
        toast.style.display = 'block';
        toast.style.animation = 'none';
        // Efecto de entrada
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        requestAnimationFrame(() => {
            toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            toast.style.opacity    = '1';
            toast.style.transform  = 'translateY(0)';
        });
        // Auto-ocultar después de 6s
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.style.opacity   = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => { toast.style.display = 'none'; }, 300);
        }, 6000);
    }

    function checkUnread() {
        fetch(apiUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            const count = data.count || 0;

            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('d-none');
            } else {
                badge.classList.add('d-none');
            }

            // Mostrar toast solo cuando hay mensajes nuevos (el count subió)
            if (prevCount !== null && count > prevCount) {
                showToast(count);
            }

            prevCount = count;
        })
        .catch(() => {});
    }

    // Primera comprobación al cargar
    checkUnread();
    // Polling cada 5 segundos
    setInterval(checkUnread, 5000);
})();
</script>

