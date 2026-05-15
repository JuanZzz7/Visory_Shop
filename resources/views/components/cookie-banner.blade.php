<div id="vs-cookie-banner" class="position-fixed bottom-0 start-0 w-100 p-3 p-md-4" style="z-index: 1050; display: none; opacity: 0; transform: translateY(100%);">
    <div class="container-fluid max-w-7xl mx-auto">
        <div class="vs-card border-0 p-4" style="border-radius: var(--vs-radius-lg); background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 -10px 40px rgba(0,0,0,0.1);">
            <div class="row align-items-center">
                <div class="col-md-8 mb-3 mb-md-0">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-cookie text-primary fs-4 me-2"></i>
                        <h5 class="fw-bold mb-0 text-dark">Tu privacidad es importante</h5>
                    </div>
                    <p class="text-muted text-sm mb-0">
                        Utilizamos cookies propias y de terceros para asegurar el correcto funcionamiento de <strong>Spotlight</strong>, mejorar tu experiencia de navegación y analizar el tráfico. Puedes aceptar todas las cookies o elegir usar solo las esenciales.
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-md-end gap-2">
                        <button id="btn-cookies-essential" class="btn btn-outline-secondary fw-semibold text-sm">
                            Solo esenciales
                        </button>
                        <button id="btn-cookies-accept" class="btn btn-primary fw-semibold text-sm shadow-sm">
                            Aceptar todas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- GSAP is included in login/register, but we ensure it's available or we handle it gracefully if not loaded globally -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cookieBanner = document.getElementById('vs-cookie-banner');
        const acceptBtn = document.getElementById('btn-cookies-accept');
        const essentialBtn = document.getElementById('btn-cookies-essential');
        const cookieName = 'VS_COOKIE_CONSENT';

        // Check if user has already made a choice
        if (!localStorage.getItem(cookieName)) {
            // Show banner with GSAP
            cookieBanner.style.display = 'block';
            gsap.to(cookieBanner, {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power3.out",
                delay: 1 // Pequeño retraso para que no interrumpa la carga inicial
            });
        }

        const hideBanner = (choice) => {
            // Save choice
            localStorage.setItem(cookieName, choice);
            
            // Animate out
            gsap.to(cookieBanner, {
                y: '100%',
                opacity: 0,
                duration: 0.5,
                ease: "power2.in",
                onComplete: () => {
                    cookieBanner.style.display = 'none';
                }
            });
            
            // Here you could dispatch a custom event to load analytics scripts if 'all' was chosen
            if (choice === 'all') {
                window.dispatchEvent(new CustomEvent('vs-cookies-accepted'));
            }
        };

        acceptBtn.addEventListener('click', () => hideBanner('all'));
        essentialBtn.addEventListener('click', () => hideBanner('essential'));
    });
</script>
@endpush
