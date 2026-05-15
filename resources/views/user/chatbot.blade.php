@extends('layouts.dashboard')
@section('title', 'Asistente IA - Spotlight')
@section('page-title', 'Asistente de Spotlight')

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

@section('dashboard-content')
<div id="sbot-window" class="vs-card d-flex flex-column" style="height: calc(100vh - 180px); overflow: hidden; border-radius: 20px;">

    {{-- Header --}}
    <div id="sbot-header" class="border-bottom p-3 d-flex align-items-center justify-content-between bg-white">
        <div class="sbot-hd-left d-flex align-items-center gap-3">
            <div class="sbot-avatar-wrap position-relative">
                <div class="sbot-avatar text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: var(--sbot-blue-dark); font-size: 1.4rem;">
                    <i class="bi bi-robot"></i>
                </div>
                <span class="sbot-status-dot position-absolute" style="bottom: 0; right: 0; width: 14px; height: 14px; border-radius: 50%; background-color: #10b981; border: 2px solid #fff;"></span>
            </div>
            <div class="sbot-hd-info">
                <div class="sbot-hd-name fw-bold" style="font-size: 1.15rem; color: #1e293b;">Spotlight AI</div>
                <div class="sbot-hd-status fw-semibold" style="font-size: 0.8rem; color: var(--sbot-teal);">Online Status</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="btn-group btn-group-sm" role="group" id="lang-toggle" aria-label="Idioma">
                <input type="radio" class="btn-check sbot-lang-radio" name="lang" id="lang-es" value="es" autocomplete="off" checked>
                <label class="btn btn-outline-primary shadow-none" for="lang-es" style="font-size: 0.75rem; padding: 2px 8px;">ES</label>
                <input type="radio" class="btn-check sbot-lang-radio" name="lang" id="lang-en" value="en" autocomplete="off">
                <label class="btn btn-outline-primary shadow-none" for="lang-en" style="font-size: 0.75rem; padding: 2px 8px;">EN</label>
            </div>
            <span class="badge bg-light text-secondary rounded-pill px-3 py-2"><i class="bi bi-shield-check me-1"></i> Asistente Oficial</span>
        </div>
    </div>

    {{-- Banner Filosófico --}}
    <div class="px-4 py-3 bg-light border-bottom text-center d-flex align-items-start gap-2 justify-content-center">
        <i class="bi bi-quote text-primary" style="font-size: 1.5rem; line-height: 1;"></i>
        <p class="fst-italic text-secondary mb-0 fw-medium text-start" style="font-size: 0.85rem; line-height: 1.4;" id="sbot-banner-text">
            "Soy LIBRE, AUTÓNOMO Y RESPONSABLE a través del diálogo y la construcción, como ideal regulativo; me dirijo, controlo y dicto mis propias leyes."
        </p>
    </div>

    {{-- Messages Area --}}
    <div id="sbot-msgs" role="log" aria-label="Chat" class="flex-fill p-4 d-flex flex-column gap-3" style="overflow-y: auto; background-color: var(--sbot-bg);">
        {{-- Date separator --}}
        <div class="sbot-date-sep text-center my-2">
            <span style="background: #e2e8f0; color: #475569; font-size: 0.75rem; font-weight: 500; padding: 4px 12px; border-radius: 20px;">Hoy</span>
        </div>
    </div>

    {{-- Typing indicator (Hidden by default) --}}
    <div id="sbot-typing" hidden style="padding: 0 24px 16px; background: var(--sbot-bg);">
        <div class="sbot-bubble-bot d-inline-block px-3 py-2" style="background-color: #ffffff; border: 1px solid var(--sbot-border); border-radius: 16px 16px 16px 4px;">
            <span class="sbot-dot-anim"></span>
            <span class="sbot-dot-anim"></span>
            <span class="sbot-dot-anim"></span>
        </div>
    </div>

    {{-- Input & Quick Replies Area --}}
    <div class="sbot-bottom-area bg-white border-top">
        {{-- Quick Replies --}}
        <div class="sbot-quick-replies d-flex gap-2 px-4 pt-3 pb-2" id="sbot-quick-replies" style="overflow-x: auto; white-space: nowrap; scrollbar-width: none;">
            <button class="sbot-chip" type="button">Rastrear mi pedido</button>
            <button class="sbot-chip" type="button">Ver ofertas</button>
            <button class="sbot-chip" type="button">Soporte técnico</button>
        </div>

        {{-- Form --}}
        <form id="sbot-form" autocomplete="off" novalidate class="p-3 px-4 pb-4">
            @csrf
            <div class="d-flex align-items-center gap-2">
                <div class="position-relative flex-fill">
                    <textarea
                        id="sbot-input"
                        placeholder="Escribe un mensaje..."
                        rows="1"
                        maxlength="2000"
                        aria-label="Mensaje"
                        class="form-control"
                        style="border-radius: 24px; padding: 12px 48px 12px 20px; resize: none; overflow: hidden; max-height: 120px;"
                    ></textarea>
                    <i class="bi bi-paperclip position-absolute" style="right: 18px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 1.2rem; pointer-events: none;"></i>
                </div>
                <button type="submit" id="sbot-send" aria-label="Enviar" class="btn text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px; border-radius: 50%; background-color: var(--sbot-teal); font-size: 1.2rem; transition: transform 0.2s;">
                    <i class="bi bi-send" style="margin-left: -2px;"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
:root {
    --sbot-teal: #006d5b;
    --sbot-teal-light: #80f2d6;
    --sbot-blue-dark: #0b1437;
    --sbot-bg: #f8fafc;
    --sbot-border: #e2e8f0;
}

#sbot-msgs::-webkit-scrollbar { width: 6px; }
#sbot-msgs::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

.sbot-row {
    display: flex;
    flex-direction: column;
    max-width: 80%;
    animation: sbotFadeUp 0.3s ease forwards;
}
.sbot-row.user { align-self: flex-end; align-items: flex-end; }
.sbot-row.bot  { align-self: flex-start; align-items: flex-start; }

@keyframes sbotFadeUp {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.sbot-bubble {
    padding: 14px 18px;
    line-height: 1.5;
    word-break: break-word;
    font-size: 0.95rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.sbot-bubble-user {
    background-color: var(--sbot-teal);
    color: #fff;
    border-radius: 18px 18px 4px 18px;
}
.sbot-bubble-bot {
    background-color: #ffffff;
    color: #334155;
    border: 1px solid var(--sbot-border);
    border-radius: 18px 18px 18px 4px;
}

.sbot-ts {
    font-size: 0.7rem;
    color: #94a3b8;
    margin-top: 6px;
    padding: 0 4px;
}

.sbot-dot-anim {
    display: inline-block;
    width: 6px; height: 6px;
    border-radius: 50%;
    background-color: var(--sbot-teal);
    margin: 0 2px;
    animation: sbotDot 1.4s ease-in-out infinite;
}
.sbot-dot-anim:nth-child(2) { animation-delay: 0.2s; }
.sbot-dot-anim:nth-child(3) { animation-delay: 0.4s; }
@keyframes sbotDot {
    0%, 80%, 100% { transform: scale(1); opacity: 0.4; }
    40% { transform: scale(1.2); opacity: 1; }
}

.sbot-chip {
    background-color: var(--sbot-teal-light);
    color: var(--sbot-teal);
    border: none;
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: filter 0.2s;
    flex-shrink: 0;
}
.sbot-chip:hover { filter: brightness(0.95); }
.sbot-quick-replies::-webkit-scrollbar { display: none; }

#sbot-input:focus {
    border-color: var(--sbot-teal);
    box-shadow: 0 0 0 3px rgba(0, 109, 91, 0.1);
}
#sbot-send:hover { background-color: #005a4b; transform: scale(1.05); }
#sbot-send:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

.sbot-bubble p { margin-bottom: 0.5rem; }
.sbot-bubble p:last-child { margin-bottom: 0; }
.sbot-bubble strong { font-weight: 700; }
.sbot-bubble ul, .sbot-bubble ol { margin: 0.5rem 0; padding-left: 1.5rem; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /* ── Config ── */
    const ENDPOINT = '{{ route("chatbot.message") }}';
    const CSRF     = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    // Languages config
    const LANGS = {
        es: {
            greeting: "¡Hola! Soy tu asistente de Spotlight. ¿Cómo puedo ayudarte a elegir el mejor producto hoy?",
            banner: '"Soy LIBRE, AUTÓNOMO Y RESPONSABLE a través del diálogo y la construcción, como ideal regulativo; me dirijo, controlo y dicto mis propias leyes."',
            placeholder: "Escribe un mensaje...",
            err: "No pude conectar temporalmente con el servidor. Por favor, intenta de nuevo en unos momentos.",
            chip1: "Rastrear mi pedido",
            chip2: "Ver ofertas",
            chip3: "Soporte técnico"
        },
        en: {
            greeting: "Hello! I am your Spotlight assistant. How can I help you choose the best product today?",
            banner: '"I am FREE, AUTONOMOUS AND RESPONSIBLE through dialogue and construction, as a regulative ideal; I direct, control and dictate my own laws."',
            placeholder: "Type a message...",
            err: "Could not connect to the server temporarily. Please try again in a few moments.",
            chip1: "Track my order",
            chip2: "View offers",
            chip3: "Tech support"
        }
    };

    let history = [];
    let busy    = false;
    let currentLang = 'es';

    /* ── DOM Elements ── */
    const msgs       = document.getElementById('sbot-msgs');
    const form       = document.getElementById('sbot-form');
    const input      = document.getElementById('sbot-input');
    const sendBtn    = document.getElementById('sbot-send');
    const typing     = document.getElementById('sbot-typing');
    const chips      = document.querySelectorAll('.sbot-chip');
    const langRadios = document.querySelectorAll('.sbot-lang-radio');
    const bannerText = document.getElementById('sbot-banner-text');

    /* ── Helpers ── */
    function formatTime() {
        return new Date().toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
    }

    function escapeHtml(text) {
        const d = document.createElement('div');
        d.appendChild(document.createTextNode(text));
        return d.innerHTML;
    }

    function formatMarkdown(text) {
        let html = escapeHtml(text);
        html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
        html = html.replace(/`(.*?)`/g, '<code style="background:rgba(0,0,0,0.05);padding:2px 4px;border-radius:4px;">$1</code>');
        html = html.replace(/\n/g, '<br>');
        return html;
    }

    function scrollBottom() {
        requestAnimationFrame(() => {
            msgs.scrollTop = msgs.scrollHeight;
        });
    }

    /* ── Append Message ── */
    function addMsg(role, text) {
        const row = document.createElement('div');
        row.className = `sbot-row ${role}`;
        const bubbleClass = role === 'user' ? 'sbot-bubble-user' : 'sbot-bubble-bot';

        row.innerHTML = `
            <div class="sbot-bubble ${bubbleClass}">${formatMarkdown(text)}</div>
            <span class="sbot-ts">${formatTime()}</span>
        `;
        msgs.appendChild(row);
        scrollBottom();
    }

    /* ── Auto-init ── */
    setTimeout(() => {
        addMsg('bot', LANGS[currentLang].greeting);
        history.push({ role: 'bot', content: LANGS[currentLang].greeting });
    }, 500);

    /* ── Language Toggle ── */
    langRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            if (e.target.checked) {
                currentLang = e.target.value;
                input.placeholder = LANGS[currentLang].placeholder;
                bannerText.textContent = LANGS[currentLang].banner;
                
                chips[0].textContent = LANGS[currentLang].chip1;
                chips[1].textContent = LANGS[currentLang].chip2;
                chips[2].textContent = LANGS[currentLang].chip3;
            }
        });
    });

    /* ── Input Auto-resize ── */
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 120) + 'px';
    });

    input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.requestSubmit();
        }
    });

    /* ── Quick Replies (Chips) ── */
    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            if (busy) return;
            sendMessage(chip.textContent);
        });
    });

    /* ── Send Form ── */
    form.addEventListener('submit', e => {
        e.preventDefault();
        const text = input.value.trim();
        if (text) sendMessage(text);
    });

    /* ── Core Send Logic ── */
    async function sendMessage(text) {
        if (busy) return;

        // Render user UI
        addMsg('user', text);
        history.push({ role: 'user', content: text });

        // Reset input
        input.value = '';
        input.style.height = 'auto';

        // Lock UI
        busy = true;
        sendBtn.disabled = true;
        typing.hidden = false;
        scrollBottom();

        try {
            const res = await fetch(ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: text,
                    lang: currentLang,
                    history: history.slice(-8),
                }),
            });

            if (!res.ok) throw new Error('Network response was not ok');

            const data = await res.json();
            const reply = data.reply || 'Lo siento, no pude procesar la respuesta.';

            addMsg('bot', reply);
            history.push({ role: 'bot', content: reply });

        } catch (err) {
            console.error('[Spotlight Chatbot Error]', err);
            addMsg('bot', LANGS[currentLang].err);
        } finally {
            busy = false;
            sendBtn.disabled = false;
            typing.hidden = true;
            input.focus();
            scrollBottom();
        }
    }
});
</script>
@endpush
