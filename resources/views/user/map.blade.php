@extends('layouts.dashboard')
@section('title','Mapa Interactivo - Spotlight')
@section('page-title','Explorar Negocios Locales')

@section('sidebar-menu')
<a href="{{ route('user.dashboard') }}" class="vs-nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
    <i class="bi bi-shop fs-5"></i> Tienda
</a>
<a href="{{ route('user.map') }}" class="vs-nav-link {{ request()->routeIs('user.map') ? 'active' : '' }}">
    <i class="bi bi-geo-alt fs-5"></i> Mapa de Empresas
</a>

<a href="{{ route('user.profile.edit') }}" class="vs-nav-link {{ request()->routeIs('user.profile*') ? 'active' : '' }}">
    <i class="bi bi-person fs-5"></i> Mi perfil
</a>
<a href="{{ route('user.orders.index') }}" class="vs-nav-link {{ request()->routeIs('user.orders*') ? 'active' : '' }}">
    <i class="bi bi-bag-check fs-5"></i> Mis compras
</a>
<a href="{{ route('user.cart.index') }}" class="vs-nav-link {{ request()->routeIs('user.cart*') ? 'active' : '' }}">
    <i class="bi bi-cart3 fs-5"></i> Carrito
</a>
<a href="{{ route('chat.index') }}" class="vs-nav-link {{ request()->is('chat*') ? 'active' : '' }}">
    <i class="bi bi-chat-dots fs-5"></i> Mensajes
</a>
<a href="{{ route('chatbot.index') }}" class="vs-nav-link {{ request()->routeIs('chatbot.index') ? 'active' : '' }}">
    <i class="bi bi-robot fs-5"></i> Spotlight AI
</a>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<style>
    :root {
        --map-ui-shadow: 0 10px 25px -5px rgba(0, 35, 111, 0.1), 0 8px 10px -6px rgba(0, 35, 111, 0.1);
    }
    
    #map { 
        height: calc(100vh - 180px); 
        width: 100%; 
        border-radius: 1.5rem;
        z-index: 1;
        background: #f1f5f9;
    }

    .map-wrapper {
        position: relative;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: var(--vs-shadow-2);
    }

    /* Buscador Minimalista Flotante */
    .map-search-bar {
        position: absolute;
        top: 24px;
        left: 24px;
        z-index: 1000;
        width: 340px;
        max-width: calc(100% - 48px);
        transition: all 0.3s ease;
    }

    .search-input-group {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        padding: 8px 12px;
        box-shadow: var(--map-ui-shadow);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-input-group input {
        border: none;
        background: transparent;
        flex: 1;
        font-size: 0.95rem;
        font-weight: 500;
        padding: 4px 0;
        outline: none;
        color: var(--vs-text-header);
    }

    .search-input-group input::placeholder {
        color: var(--vs-text-muted);
        font-weight: 400;
    }

    /* Card de Detalles Lateral (Glassmorphism) */
    .company-detail-card {
        position: absolute;
        bottom: 24px;
        right: 24px;
        z-index: 1000;
        width: 320px;
        max-width: calc(100% - 48px);
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 1.25rem;
        padding: 20px;
        box-shadow: var(--map-ui-shadow);
        transform: translateY(20px);
        opacity: 0;
        pointer-events: none;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .company-detail-card.active {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
    }

    .detail-category {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 700;
        text-uppercase;
        letter-spacing: 0.05em;
        color: var(--vs-secondary);
        background: rgba(13, 148, 136, 0.1);
        padding: 4px 10px;
        border-radius: 20px;
        margin-bottom: 12px;
    }

    .detail-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--vs-text-header);
        margin-bottom: 8px;
    }

    .detail-address {
        font-size: 0.85rem;
        color: var(--vs-text-muted);
        margin-bottom: 16px;
        display: flex;
        gap: 6px;
    }

    .detail-specs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 20px;
        padding: 12px;
        background: rgba(0,0,0,0.03);
        border-radius: 0.75rem;
    }

    .spec-item {
        display: flex;
        flex-direction: column;
    }

    .spec-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        color: var(--vs-text-muted);
        font-weight: 600;
    }

    .spec-value {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--vs-text-header);
    }

    .detail-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    /* Resultados de Búsqueda */
    .search-results-floating {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        margin-top: 8px;
        border-radius: 1rem;
        max-height: 200px;
        overflow-y: auto;
        box-shadow: var(--map-ui-shadow);
        display: none;
    }

    .result-row {
        padding: 12px 16px;
        cursor: pointer;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s;
    }

    .result-row:hover {
        background: rgba(0, 35, 111, 0.03);
    }

    .result-icon {
        width: 32px;
        height: 32px;
        background: var(--vs-primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }

    .btn-maps {
        background: #4285F4;
        color: white !important;
        border: none;
    }
    
    .btn-maps:hover {
        background: #3367D6;
    }

    /* Estilo para los Markers de Leaflet */
    .custom-marker {
        background: var(--vs-primary);
        border: 3px solid white;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }
    
    .custom-marker i {
        transform: rotate(45deg);
        color: white;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('dashboard-content')
<div class="map-wrapper">
    {{-- Buscador Flotante --}}
    <div class="map-search-bar">
        <div class="search-input-group">
            <i class="bi bi-search text-primary"></i>
            <input type="text" id="mapSearch" placeholder="Buscar por nombre de empresa...">
            <i class="bi bi-x-circle text-muted" id="clearSearch" style="cursor: pointer; display: none;"></i>
        </div>
        <div id="searchResults" class="search-results-floating"></div>
    </div>

    {{-- Mapa --}}
    <div id="map"></div>

    {{-- Card de Detalles Lateral --}}
    <div id="companyDetail" class="company-detail-card">
        <div class="detail-category" id="detCat">Categoría</div>
        <h3 class="detail-name" id="detName">Nombre de Empresa</h3>
        <div class="detail-address">
            <i class="bi bi-geo-alt-fill text-danger"></i>
            <span id="detAddr">Calle 123 #45-67, Ciudad</span>
        </div>
        
        <div class="detail-specs">
            <div class="spec-item">
                <span class="spec-label">Contacto</span>
                <span class="spec-value" id="detPhone">300 000 0000</span>
            </div>
            <div class="spec-item">
                <span class="spec-label">Email</span>
                <span class="spec-value" id="detEmail">correo@empresa.com</span>
            </div>
            <div class="spec-item">
                <span class="spec-label">Web</span>
                <span class="spec-value" id="detWeb">www.empresa.com</span>
            </div>
            <div class="spec-item">
                <span class="spec-label">Estado</span>
                <span class="spec-value text-success">
                    <i class="bi bi-patch-check-fill me-1"></i>Verificado
                </span>
            </div>
        </div>

        <div class="detail-actions">
            <a href="#" id="detStore" class="btn btn-primary rounded-pill fw-semibold btn-sm d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-shop"></i> Ver Tienda
            </a>
            <a href="#" id="detRoute" target="_blank" class="btn btn-maps rounded-pill fw-semibold btn-sm d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-signpost-2"></i> Cómo llegar
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const companies = @json($companies);
    const map = L.map('map', {
        zoomControl: false // Quitamos el control por defecto para una UI más limpia
    }).setView([5.3086, -73.8149], 14);

    // Agregar control de zoom en una posición más discreta
    L.control.zoom({ position: 'bottomleft' }).addTo(map);

    // Capa de mapa elegante (Muted style if possible, but OSM is fine)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    const markerGroup = L.featureGroup().addTo(map);
    const markerMap = new Map();

    companies.forEach(company => {
        if (!company.latitude || !company.longitude) return;

        // Marcador Personalizado
        const marker = L.marker([company.latitude, company.longitude], {
            icon: L.divIcon({
                className: 'custom-marker-wrapper',
                html: `<div class="custom-marker"><i class="bi bi-shop"></i></div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 30]
            })
        });

        marker.on('click', () => showCompanyDetails(company));
        marker.addTo(markerGroup);
        markerMap.set(company.id, marker);
    });

    if (companies.length > 0) {
        map.fitBounds(markerGroup.getBounds().pad(0.1));
    }

    // Funciones de UI
    const detailCard = document.getElementById('companyDetail');
    
    function showCompanyDetails(company) {
        document.getElementById('detName').textContent = company.name;
        document.getElementById('detCat').textContent = company.category || 'Empresa';
        document.getElementById('detAddr').textContent = company.address || 'Ubicación física';
        document.getElementById('detPhone').textContent = company.phone || 'No disponible';
        document.getElementById('detEmail').textContent = company.email || 'No disponible';
        document.getElementById('detWeb').textContent = company.website ? company.website.replace('https://', '').replace('http://', '') : 'No disponible';
        
        // Botón Ver Tienda
        document.getElementById('detStore').href = `/empresas/${company.id}`;
        
        // Botón Cómo llegar (Google Maps)
        const mapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${company.latitude},${company.longitude}`;
        document.getElementById('detRoute').href = mapsUrl;

        detailCard.classList.add('active');
        
        // Centrar mapa un poco desplazado para que no lo tape la card si es móvil
        map.panTo([company.latitude, company.longitude]);
    }

    // Cerrar card al hacer clic en el mapa
    map.on('click', () => {
        detailCard.classList.remove('active');
        resultsBox.style.display = 'none';
    });

    // Lógica del Buscador
    const searchInput = document.getElementById('mapSearch');
    const resultsBox = document.getElementById('searchResults');
    const clearBtn = document.getElementById('clearSearch');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        resultsBox.innerHTML = '';
        
        if (query.length === 0) {
            resultsBox.style.display = 'none';
            clearBtn.style.display = 'none';
            return;
        }

        clearBtn.style.display = 'block';
        const filtered = companies.filter(c => c.name.toLowerCase().includes(query));

        if (filtered.length > 0) {
            filtered.forEach(c => {
                const row = document.createElement('div');
                row.className = 'result-row';
                row.innerHTML = `
                    <div class="result-icon"><i class="bi bi-building"></i></div>
                    <div>
                        <div class="fw-bold text-dark text-sm">${c.name}</div>
                        <div class="text-xs text-muted">${c.category}</div>
                    </div>
                `;
                row.onclick = () => {
                    const m = markerMap.get(c.id);
                    if (m) {
                        map.setView([c.latitude, c.longitude], 17);
                        showCompanyDetails(c);
                    }
                    resultsBox.style.display = 'none';
                    searchInput.value = c.name;
                };
                resultsBox.appendChild(row);
            });
            resultsBox.style.display = 'block';
        } else {
            resultsBox.innerHTML = '<div class="p-3 text-center text-muted small">No se encontraron resultados</div>';
            resultsBox.style.display = 'block';
        }
    });

    clearBtn.onclick = () => {
        searchInput.value = '';
        resultsBox.style.display = 'none';
        clearBtn.style.display = 'none';
        detailCard.classList.remove('active');
        if (companies.length > 0) {
            map.fitBounds(markerGroup.getBounds().pad(0.1));
        }
    };

    // Fix para tamaño de mapa
    setTimeout(() => map.invalidateSize(), 500);
});
</script>
@endpush
