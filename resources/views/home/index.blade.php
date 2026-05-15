@extends('layouts.app')
@section('title','Spotlight - Comercio Local')
@section('content')

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark border-bottom border-light" style="background: var(--vs-primary)">
    <div class="container py-2">
        <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Spotlight" class="vs-brand-logo">
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto ps-lg-4">
                <li class="nav-item"><a class="nav-link text-white opacity-75 hover-opacity-100" href="{{ route('home') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white opacity-75 hover-opacity-100" href="#empresas">Empresas</a></li>
                <li class="nav-item"><a class="nav-link text-white opacity-75 hover-opacity-100" href="#productos">Productos</a></li>
            </ul>
            <div class="d-flex gap-3 mt-3 mt-lg-0">
                @auth
                    @php $dash = match(auth()->user()->role) { 'admin'=>'admin.dashboard','business'=>'business.dashboard',default=>'user.dashboard'}; @endphp
                    <a href="{{ route($dash) }}" class="btn btn-outline-light px-4 rounded-pill">Mi Panel</a>
                @else
                    <a href="{{ route('login') }}" class="btn text-white opacity-75 hover-opacity-100 fw-medium">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary px-4 rounded-pill shadow-sm">Registrarse</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Hero / Quiénes Somos --}}
<section style="background: linear-gradient(135deg, var(--vs-primary) 0%, var(--vs-primary-hover) 100%); min-height: 70vh;" class="d-flex align-items-center position-relative overflow-hidden">
    <!-- Decoración de fondo -->
    <div class="position-absolute rounded-circle" style="width: 600px; height: 600px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%); top: -200px; right: -100px;"></div>
    
    <div class="container text-white py-5 position-relative z-1">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill mb-4" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                    <span class="badge bg-secondary rounded-pill">Nuestra Misión</span>
                    <span class="text-sm fw-medium">Impulsando el comercio local</span>
                </div>
                <h1 class="display-4 fw-bold mb-4 text-white" style="letter-spacing: -0.02em; line-height: 1.1;">
                    El futuro del comercio con <span class="text-info">Spotlight</span>
                </h1>
                <p class="lead mb-5 text-white" style="font-size: 1.125rem; line-height: 1.7; opacity: 0.9;">
                    En <strong>Spotlight</strong>, creemos en el poder de nuestra comunidad. Somos el punto de encuentro donde emprendedores y empresas locales conectan con clientes que valoran la calidad y el servicio cercano. 
                    <br><br>
                    Nuestra misión es digitalizar los negocios de nuestra región, brindándoles las herramientas necesarias para crecer, prosperar y llevar sus productos a cada rincón, manteniendo siempre la esencia de lo nuestro.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-lg px-5 rounded-pill shadow-sm">Únete a la comunidad</a>
                    <a href="#empresas" class="btn btn-outline-light btn-lg px-5 rounded-pill">Descubrir empresas</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center position-relative">
                <div class="position-absolute bg-info rounded-circle" style="width: 300px; height: 300px; filter: blur(100px); opacity: 0.2; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                <img src="{{ asset('images/hero-home.jpg') }}" class="img-fluid rounded-4 shadow-lg border border-white border-opacity-25" style="object-fit: cover; height: 500px; width: 100%;" alt="Nuestra Comunidad">
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="bg-white py-5 border-bottom">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-4 rounded-4 bg-light">
                    <h2 class="fw-bold text-primary mb-2 display-6">{{ $companies->count() }}+</h2>
                    <p class="text-muted fw-medium mb-0 text-uppercase tracking-wide text-sm">Empresas activas</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 bg-light">
                    <h2 class="fw-bold text-primary mb-2 display-6">{{ $products->count() }}+</h2>
                    <p class="text-muted fw-medium mb-0 text-uppercase tracking-wide text-sm">Productos listados</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 bg-light">
                    <h2 class="fw-bold text-primary mb-2 display-6">100%</h2>
                    <p class="text-muted fw-medium mb-0 text-uppercase tracking-wide text-sm">Seguro y confiable</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Empresas --}}
<section id="empresas" class="py-5 bg-white">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="text-secondary fw-semibold tracking-wide text-uppercase text-sm">Nuestros socios</span>
                <h2 class="fw-bold mb-0 mt-2 text-dark">Empresas registradas</h2>
            </div>
            <a href="#" class="btn btn-outline-primary rounded-pill px-4 d-none d-md-inline-flex">Ver todas</a>
        </div>
        <div class="row g-4">
            @forelse($companies as $company)
            <div class="col-md-6 col-lg-4">
                {{-- Wrapper con tooltip --}}
                <div class="company-card-wrap position-relative"
                     data-company-id="{{ $company->id }}"
                     data-name="{{ $company->name }}"
                     data-category="{{ $company->category }}"
                     data-description="{{ $company->description ?? '' }}"
                     data-phone="{{ $company->phone ?? '' }}"
                     data-email="{{ $company->email ?? '' }}"
                     data-instagram="{{ $company->instagram ?? '' }}"
                     data-facebook="{{ $company->facebook ?? '' }}"
                     data-website="{{ $company->website ?? '' }}"
                     data-logo="{{ $company->logo ? asset('storage/'.$company->logo) : '' }}"
                     data-url="{{ route('public.company', $company) }}"
                     data-lat="{{ $company->latitude ?? '' }}"
                     data-lng="{{ $company->longitude ?? '' }}">

                    <div class="vs-card h-100 overflow-hidden border-0 shadow-sm hover-translate-y" style="cursor:pointer;">
                        {{-- Banner --}}
                        <div style="height: 120px; position: relative; background: linear-gradient(to right, var(--vs-primary), var(--vs-secondary));">
                            @if($company->banner)
                                <img src="{{ asset('storage/'.$company->banner) }}" class="w-100 h-100" style="object-fit: cover;">
                            @endif
                            {{-- Logo overlapping banner --}}
                            <div class="position-absolute" style="bottom: -30px; left: 20px;">
                                <div class="vs-card p-1 rounded-circle bg-white shadow-sm" style="width: 70px; height: 70px;">
                                    <div class="w-100 h-100 rounded-circle bg-light overflow-hidden d-flex align-items-center justify-content-center">
                                        @if($company->logo)
                                            <img src="{{ asset('storage/'.$company->logo) }}" class="w-100 h-100" style="object-fit: cover;">
                                        @else
                                            <i class="bi bi-building text-muted fs-4"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-5 p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">{{ $company->name }}</h5>
                                    <span class="badge badge-soft-primary rounded-pill mt-1">{{ $company->category }}</span>
                                </div>
                            </div>
                            <p class="text-muted text-sm line-clamp-2 mt-2 mb-4" style="height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $company->description ?? 'Sin descripción disponible.' }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-2 text-muted">
                                    @if($company->instagram)<i class="bi bi-instagram"></i>@endif
                                    @if($company->facebook)<i class="bi bi-facebook"></i>@endif
                                    @if($company->website)<i class="bi bi-globe"></i>@endif
                                </div>
                                <a href="{{ route('public.company', $company) }}" class="btn btn-link text-primary fw-semibold p-0 text-decoration-none">Ver productos <i class="bi bi-arrow-right"></i></a>
                            </div>
                            @if($company->latitude && $company->longitude)
                                <button class="btn btn-sm btn-outline-secondary rounded-pill mt-3 w-100 border-dashed"
                                        onclick="event.stopPropagation(); showMap({{ $company->latitude }}, {{ $company->longitude }}, '{{ $company->name }}')">
                                    <i class="bi bi-geo-alt me-1"></i> Ver Ubicación
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Tooltip flotante (CSS hover, sin JS extra) --}}
                    <div class="company-tooltip" role="tooltip">
                        <div class="tooltip-header">
                            @if($company->logo)
                                <img src="{{ asset('storage/'.$company->logo) }}" class="tooltip-logo" alt="">
                            @else
                                <div class="tooltip-logo-placeholder"><i class="bi bi-building"></i></div>
                            @endif
                            <div>
                                <div class="tooltip-name">{{ $company->name }}</div>
                                <span class="tooltip-badge">{{ $company->category }}</span>
                            </div>
                        </div>

                        @if($company->description)
                        <p class="tooltip-desc">{{ Str::limit($company->description, 100) }}</p>
                        @endif

                        <div class="tooltip-grid">
                            @if($company->phone)
                            <div class="tooltip-info-item">
                                <i class="bi bi-telephone-fill"></i>
                                <span>{{ $company->phone }}</span>
                            </div>
                            @endif
                            @if($company->email)
                            <div class="tooltip-info-item">
                                <i class="bi bi-envelope-fill"></i>
                                <span>{{ $company->email }}</span>
                            </div>
                            @endif
                            {{-- Dirección desde coordenadas del mapa --}}
                            @if($company->latitude && $company->longitude)
                            <div class="tooltip-info-item tooltip-full">
                                <i class="bi bi-geo-alt-fill" style="color:#0d9488;"></i>
                                <span class="tooltip-geo-address" data-lat="{{ $company->latitude }}" data-lng="{{ $company->longitude }}">
                                    <span class="geo-loading"><i class="bi bi-arrow-repeat spin-icon"></i> Obteniendo ubicación...</span>
                                </span>
                            </div>
                            @endif
                        </div>

                        @if($company->instagram || $company->facebook || $company->website)
                        <div class="tooltip-social">
                            @if($company->instagram)
                                <a href="{{ $company->instagram }}" target="_blank" class="tooltip-social-btn" title="Instagram"><i class="bi bi-instagram"></i></a>
                            @endif
                            @if($company->facebook)
                                <a href="{{ $company->facebook }}" target="_blank" class="tooltip-social-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
                            @endif
                            @if($company->website)
                                <a href="{{ $company->website }}" target="_blank" class="tooltip-social-btn" title="Web"><i class="bi bi-globe2"></i></a>
                            @endif
                        </div>
                        @endif

                        {{-- Botones CTA: Ver mapa + Ver productos --}}
                        <div class="d-flex gap-2">
                            @if($company->latitude && $company->longitude)
                            <button type="button"
                                onclick="event.stopPropagation(); showMap({{ $company->latitude }}, {{ $company->longitude }}, '{{ addslashes($company->name) }}')"
                                class="tooltip-cta-map flex-shrink-0">
                                <i class="bi bi-map-fill"></i> Mapa
                            </button>
                            @endif
                            <a href="{{ route('public.company', $company) }}" class="tooltip-cta flex-fill">
                                <i class="bi bi-shop me-1"></i>Ver productos
                            </a>
                        </div>
                        <div class="tooltip-arrow"></div>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted mb-0">No hay empresas registradas aún.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Modal Mapa --}}
<div class="modal fade" id="mapModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="mapModalTitle">Ubicación de la Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="modalMap" class="rounded-4 border shadow-inner" style="height: 400px; width: 100%; background: #f8fafc;"></div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .border-dashed { border-style: dashed !important; }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06); }

    /* ════ TOOLTIP DE EMPRESA ════ */
    .company-card-wrap {
        /* El tooltip sale hacia arriba por defecto */
    }
    .company-tooltip {
        position: absolute;
        bottom: calc(100% + 12px);
        left: 50%;
        transform: translateX(-50%) translateY(8px);
        width: 300px;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 20px 60px rgba(0,35,111,0.2), 0 4px 16px rgba(0,0,0,0.1);
        padding: 18px;
        z-index: 1000;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.22s ease, transform 0.22s ease;
        border: 1px solid rgba(0,35,111,0.08);
    }
    /* Flecha apuntando hacia abajo */
    .tooltip-arrow {
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 16px; height: 16px;
        background: #fff;
        border-right: 1px solid rgba(0,35,111,0.08);
        border-bottom: 1px solid rgba(0,35,111,0.08);
        clip-path: polygon(0 0, 100% 100%, 0 100%);
        transform: translateX(-50%) rotate(-135deg);
    }
    /* Mostrar al hover del wrapper */
    .company-card-wrap:hover .company-tooltip {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
        pointer-events: auto;
    }
    /* Si la card está en la última fila visible, mostrar hacia abajo */
    .company-card-wrap:nth-child(3n) .company-tooltip,
    .company-card-wrap:last-child .company-tooltip {
        bottom: auto;
        top: calc(100% + 12px);
        transform: translateX(-50%) translateY(-8px);
    }
    .company-card-wrap:nth-child(3n):hover .company-tooltip,
    .company-card-wrap:last-child:hover .company-tooltip {
        transform: translateX(-50%) translateY(0);
    }

    /* Contenido del tooltip */
    .tooltip-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }
    .tooltip-logo {
        width: 44px; height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        flex-shrink: 0;
    }
    .tooltip-logo-placeholder {
        width: 44px; height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00236f, #0d9488);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.2rem; flex-shrink: 0;
    }
    .tooltip-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #00236f;
        line-height: 1.2;
    }
    .tooltip-badge {
        display: inline-block;
        background: rgba(0,35,111,0.08);
        color: #00236f;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
        margin-top: 3px;
    }
    .tooltip-desc {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 10px;
    }
    .tooltip-grid {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 10px;
    }
    .tooltip-info-item {
        display: flex;
        align-items: flex-start;
        gap: 7px;
        font-size: 0.78rem;
        color: #475569;
    }
    .tooltip-info-item i {
        color: #0d9488;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .tooltip-social {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
    }
    .tooltip-social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px; height: 30px;
        border-radius: 8px;
        background: #f8fafc;
        color: #475569;
        font-size: 0.85rem;
        transition: background 0.15s, color 0.15s;
        text-decoration: none;
    }
    .tooltip-social-btn:hover {
        background: #00236f;
        color: #fff;
    }
    .tooltip-cta {
        display: block;
        text-align: center;
        background: linear-gradient(135deg, #00236f, #0d9488);
        color: #fff;
        border-radius: 10px;
        padding: 8px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.15s, transform 0.15s;
    }
    .tooltip-cta:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        color: #fff;
    }
    /* Botón de mapa dentro del tooltip */
    .tooltip-cta-map {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        background: rgba(0,35,111,0.08);
        color: #00236f;
        border: 1.5px solid rgba(0,35,111,0.2);
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s, color 0.15s;
        white-space: nowrap;
    }
    .tooltip-cta-map:hover {
        background: #00236f;
        color: #fff;
        border-color: #00236f;
    }
    /* Spinner geocoding */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }
    .spin-icon { display: inline-block; animation: spin 1s linear infinite; }
    .geo-loading { color: #94a3b8; font-size: 0.76rem; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let modalMap = null;
    let modalMarker = null;

    function showMap(lat, lng, name) {
        const modal = new bootstrap.Modal(document.getElementById('mapModal'));
        document.getElementById('mapModalTitle').innerText = name;
        modal.show();

        // Inicializar mapa después de que el modal se muestre
        setTimeout(() => {
            if (modalMap) {
                modalMap.remove();
            }
            modalMap = L.map('modalMap', {
                zoomControl: true,
                scrollWheelZoom: true
            }).setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(modalMap);

            modalMarker = L.marker([lat, lng]).addTo(modalMap);
            
            // Forzar redibujado para evitar áreas grises
            modalMap.invalidateSize();
        }, 400);
    }

    // ── Reverse-geocoding para los tooltips de empresa ──────────────────────
    // Usamos Nominatim (OpenStreetMap, gratuito, sin API key)
    // Cache para no pedir dos veces la misma coordenada
    const geoCache = {};

    async function reverseGeocode(lat, lng) {
        const key = `${lat},${lng}`;
        if (geoCache[key]) return geoCache[key];
        try {
            const res = await fetch(
                `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=es`,
                { headers: { 'Accept-Language': 'es' } }
            );
            const data = await res.json();
            // Mostrar calle + municipio/ciudad
            const addr = data.address;
            let label = '';
            if (addr.road)        label += addr.road;
            if (addr.house_number) label += ' ' + addr.house_number;
            if (addr.city || addr.town || addr.municipality || addr.village) {
                const city = addr.city || addr.town || addr.municipality || addr.village;
                label += (label ? ', ' : '') + city;
            }
            if (!label && data.display_name) label = data.display_name.split(',').slice(0,2).join(', ');
            geoCache[key] = label || 'Ubicación en el mapa';
        } catch (e) {
            geoCache[key] = 'Ubicación en el mapa';
        }
        return geoCache[key];
    }

    // Al hacer hover sobre cada card, geocodificar (lazy)
    document.querySelectorAll('.company-card-wrap').forEach(wrap => {
        const spans = wrap.querySelectorAll('.tooltip-geo-address');
        if (!spans.length) return;

        let fetched = false;
        wrap.addEventListener('mouseenter', async () => {
            if (fetched) return;
            fetched = true;
            for (const span of spans) {
                const lat = span.dataset.lat;
                const lng = span.dataset.lng;
                if (!lat || !lng) continue;
                const address = await reverseGeocode(lat, lng);
                span.innerHTML = address;
            }
        });
    });
</script>
@endpush

{{-- Productos destacados --}}
<section id="productos" class="py-5" style="background-color: var(--vs-bg-color);">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-secondary fw-semibold tracking-wide text-uppercase text-sm">Catálogo</span>
            <h2 class="fw-bold mb-0 mt-2 text-dark">Productos destacados</h2>
        </div>
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="vs-card h-100 overflow-hidden d-flex flex-column">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" style="height:200px;object-fit:cover" alt="{{ $product->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                            <i class="bi bi-box-seam text-muted" style="font-size:3rem; opacity: 0.3;"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column p-4 flex-fill">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title fw-bold text-dark mb-0 text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                        </div>
                        <p class="text-muted text-sm mb-3 d-flex align-items-center gap-1">
                            <i class="bi bi-shop"></i> {{ $product->company->name }}
                        </p>
                        <div class="fw-bold fs-3 text-primary mb-4 mt-auto">${{ number_format($product->price,0,',','.') }}</div>
                        <div class="d-flex gap-2">
                            @auth
                                @if(auth()->user()->role === 'user')
                                    <form action="{{ route('user.cart.add', $product) }}" method="POST" class="flex-fill">
                                        @csrf
                                        <button class="btn btn-primary w-100 rounded-pill py-2 shadow-sm fw-medium">Comprar</button>
                                    </form>
                                    <a href="{{ route('chat.show', $product->company->user_id) }}" class="btn btn-outline-primary rounded-pill px-3 shadow-sm d-flex align-items-center justify-content-center" title="Chatear con la empresa">
                                        <i class="bi bi-chat-dots"></i>
                                    </a>
                                @else
                                    <span class="btn btn-primary flex-fill rounded-pill py-2 shadow-sm fw-medium disabled">Comprar</span>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary flex-fill rounded-pill py-2 shadow-sm fw-medium">Comprar</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted mb-0">No hay productos destacados aún.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="text-white py-5" style="background-color: #0f172a;">
    <div class="container text-center">
        <div class="mb-4">
            <a class="d-inline-block text-decoration-none" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Spotlight" class="vs-brand-logo-lg">
            </a>
        </div>
        <p class="text-white-50 mb-0">© {{ date('Y') }} Spotlight. Todos los derechos reservados.</p>
    </div>
</footer>
@endsection
