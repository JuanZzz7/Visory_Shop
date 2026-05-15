{{-- ================================================================
     Spotlight AI Chatbot — Floating Widget
     ================================================================ --}}

{{-- ── Floating Trigger Button (FAB) ─────────────────────────── --}}
<button id="sbot-btn" aria-label="Abrir asistente IA" title="Chatea con Spotlight AI">
    <i class="bi bi-chat-left-text-fill" id="sbot-icon-open"></i>
    <i class="bi bi-x-lg" id="sbot-icon-close" style="display:none"></i>
</button>

{{-- ── Chat Window ─────────────────────────────────────────────── --}}
<div id="sbot-window" hidden>

    {{-- Header --}}
    <div id="sbot-header">
        <div class="sbot-hd-left">
            <div class="sbot-avatar-wrap">
                <div class="sbot-avatar">
                    <i class="bi bi-robot"></i>
                </div>
                <span class="sbot-status-dot"></span>
            </div>
            <div class="sbot-hd-info">
                <div class="sbot-hd-name">Spotlight AI</div>
                <div class="sbot-hd-status">Online Status</div>
            </div>
        </div>
        <button id="sbot-close-btn" aria-label="Cerrar chat">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- Messages Area --}}
    <div id="sbot-msgs" role="log" aria-label="Chat">
        {{-- Date separator --}}
        <div class="sbot-date-sep"><span>Hoy</span></div>
    </div>

    {{-- Typing indicator (Hidden by default) --}}
    <div id="sbot-typing" hidden>
        <div class="sbot-bubble sbot-bubble-bot">
            <span class="sbot-dot-anim"></span>
            <span class="sbot-dot-anim"></span>
            <span class="sbot-dot-anim"></span>
        </div>
    </div>

    {{-- Input & Quick Replies Area --}}
    <div class="sbot-bottom-area">
        {{-- Quick Replies --}}
        <div class="sbot-quick-replies" id="sbot-quick-replies">
            <button class="sbot-chip" type="button">Rastrear mi pedido</button>
            <button class="sbot-chip" type="button">Ver ofertas</button>
            <button class="sbot-chip" type="button">Soporte técnico</button>
        </div>

        {{-- Form --}}
        <form id="sbot-form" autocomplete="off" novalidate>
            @csrf
            <div class="sbot-input-group">
                <div class="sbot-input-wrapper">
                    <textarea
                        id="sbot-input"
                        placeholder="Escribe un mensaje..."
                        rows="1"
                        maxlength="2000"
                        aria-label="Mensaje"
                    ></textarea>
                    <i class="bi bi-paperclip sbot-clip-icon"></i>
                </div>
                <button type="submit" id="sbot-send" aria-label="Enviar">
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================================================================
     STYLES
     ================================================================ --}}
@once
@push('styles')
<style>
/* ── Variables ─────────────────────────────────────────────────── */
:root {
    --sbot-teal: #006d5b;
    --sbot-teal-light: #80f2d6;
    --sbot-blue-dark: #0b1437;
    --sbot-bg: #f8fafc;
    --sbot-border: #e2e8f0;
}

/* ── Floating trigger (FAB) ────────────────────────────────────── */
#sbot-btn {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 1060;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
    background-color: var(--sbot-teal);
    box-shadow: 0 4px 14px rgba(0, 109, 91, 0.4), 0 8px 30px rgba(0, 0, 0, 0.15);
    transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease;
    outline: none;
}
#sbot-btn:hover  { transform: scale(1.08); box-shadow: 0 6px 20px rgba(0, 109, 91, 0.5); }
#sbot-btn:active { transform: scale(0.95); }

/* Pulse animation behind the button */
#sbot-btn::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background-color: var(--sbot-teal);
    animation: sbotPulse 2s ease-out infinite;
    z-index: -1;
}
@keyframes sbotPulse {
    0%   { transform: scale(1); opacity: 0.6; }
    70%  { transform: scale(1.5); opacity: 0; }
    100% { transform: scale(1.5); opacity: 0; }
}

/* ── Chat Window ───────────────────────────────────────────────── */
#sbot-window {
    position: fixed;
    bottom: 100px;
    right: 24px;
    z-index: 1059;
    width: 380px;
    max-width: calc(100vw - 40px);
    height: 550px;
    max-height: calc(100vh - 140px);
    background: var(--sbot-bg);
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12), 0 2px 10px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transform-origin: bottom right;
    animation: sbotIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    font-family: 'Inter', sans-serif;
}
#sbot-window[hidden] { display: none !important; }

@keyframes sbotIn {
    from { opacity: 0; transform: scale(0.85) translateY(10px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

/* ── Header ────────────────────────────────────────────────────── */
#sbot-header {
    flex-shrink: 0;
    background: #ffffff;
    border-bottom: 1px solid var(--sbot-border);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}
.sbot-hd-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.sbot-avatar-wrap {
    position: relative;
}
.sbot-avatar {
    width: 42px; height: 42px;
    border-radius: 50%;
    background-color: var(--sbot-blue-dark);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: #fff;
}
.sbot-status-dot {
    position: absolute;
    bottom: 0; right: 0;
    width: 12px; height: 12px;
    border-radius: 50%;
    background-color: #10b981; /* Green */
    border: 2px solid #fff;
}
.sbot-hd-name {
    font-weight: 700;
    font-size: 1.05rem;
    color: #1e293b;
    line-height: 1.2;
}
.sbot-hd-status {
    font-size: 0.75rem;
    color: var(--sbot-teal);
    font-weight: 600;
    margin-top: 2px;
}
#sbot-close-btn {
    background: none;
    border: none;
    color: #64748b;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 4px;
    transition: color 0.2s;
}
#sbot-close-btn:hover { color: #0f172a; }

/* ── Messages Area ─────────────────────────────────────────────── */
#sbot-msgs {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    background: var(--sbot-bg);
}
#sbot-msgs::-webkit-scrollbar { width: 6px; }
#sbot-msgs::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

.sbot-date-sep {
    text-align: center;
    margin: 10px 0;
}
.sbot-date-sep span {
    background: #e2e8f0;
    color: #475569;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 4px 12px;
    border-radius: 20px;
}

.sbot-row {
    display: flex;
    flex-direction: column;
    max-width: 85%;
    animation: sbotFadeUp 0.3s ease forwards;
}
.sbot-row.user { align-self: flex-end; align-items: flex-end; }
.sbot-row.bot  { align-self: flex-start; align-items: flex-start; }

@keyframes sbotFadeUp {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.sbot-bubble {
    padding: 12px 16px;
    line-height: 1.5;
    word-break: break-word;
    font-size: 0.9rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.sbot-bubble-user {
    background-color: var(--sbot-teal);
    color: #fff;
    border-radius: 16px 16px 4px 16px;
}
.sbot-bubble-bot {
    background-color: #ffffff;
    color: #334155;
    border: 1px solid var(--sbot-border);
    border-radius: 16px 16px 16px 4px;
}

.sbot-ts {
    font-size: 0.65rem;
    color: #94a3b8;
    margin-top: 4px;
    padding: 0 4px;
}

/* ── Typing Indicator ──────────────────────────────────────────── */
#sbot-typing {
    padding: 0 20px 10px;
    background: var(--sbot-bg);
    flex-shrink: 0;
}
#sbot-typing .sbot-bubble-bot {
    display: inline-block;
    padding: 10px 16px;
    border-radius: 16px 16px 16px 4px;
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

/* ── Bottom Area (Quick Replies & Input) ───────────────────────── */
.sbot-bottom-area {
    flex-shrink: 0;
    background: #ffffff;
    border-top: 1px solid var(--sbot-border);
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
}

.sbot-quick-replies {
    display: flex;
    gap: 8px;
    padding: 12px 16px 4px;
    overflow-x: auto;
    white-space: nowrap;
    scrollbar-width: none; /* Firefox */
}
.sbot-quick-replies::-webkit-scrollbar { display: none; } /* Chrome */

.sbot-chip {
    background-color: var(--sbot-teal-light);
    color: var(--sbot-teal);
    border: none;
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: filter 0.2s;
    flex-shrink: 0;
}
.sbot-chip:hover { filter: brightness(0.95); }

#sbot-form {
    padding: 12px 16px 16px;
}
.sbot-input-group {
    display: flex;
    align-items: center;
    gap: 10px;
}
.sbot-input-wrapper {
    position: relative;
    flex: 1;
}
#sbot-input {
    width: 100%;
    background-color: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 24px;
    padding: 10px 40px 10px 16px;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    color: #1e293b;
    resize: none;
    outline: none;
    max-height: 100px;
    line-height: 1.5;
    transition: border-color 0.2s, box-shadow 0.2s;
}
#sbot-input:focus {
    border-color: var(--sbot-teal);
    box-shadow: 0 0 0 3px rgba(0, 109, 91, 0.1);
}
#sbot-input::placeholder { color: #94a3b8; }

.sbot-clip-icon {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    font-size: 1.1rem;
    pointer-events: none;
}

#sbot-send {
    width: 44px; height: 44px;
    border-radius: 50%;
    border: none;
    background-color: var(--sbot-teal);
    color: #fff;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
    transition: background 0.2s, transform 0.15s;
    padding-right: 2px; /* slight visual balance for send icon */
}
#sbot-send:hover  { background-color: #005a4b; transform: scale(1.05); }
#sbot-send:active { transform: scale(0.95); }
#sbot-send:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

/* ── Markdown adjustments inside bubbles ───────────────────────── */
.sbot-bubble p { margin-bottom: 0.5rem; }
.sbot-bubble p:last-child { margin-bottom: 0; }
.sbot-bubble strong { font-weight: 700; }
.sbot-bubble ul, .sbot-bubble ol { margin: 0.5rem 0; padding-left: 1.5rem; }

/* Mobile */
@media (max-width: 480px) {
    #sbot-btn    { bottom: 20px; right: 20px; }
    #sbot-window { right: 16px; bottom: 90px; width: calc(100vw - 32px); height: calc(100vh - 120px); }
}
</style>
@endpush
@endonce

{{-- ================================================================
     JAVASCRIPT
     ================================================================ --}}
@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /* ── Config ── */
    const ENDPOINT = '{{ route("chatbot.message") }}';
    const CSRF     = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    // The backend uses auto-detection, we just pass the text.
    // The greeting matches the image provided.
    const GREETING = "¡Hola! Soy tu asistente de Spotlight. ¿Cómo puedo ayudarte a elegir el mejor producto hoy?";

    /* ── State ── */
    let history = [];
    let busy    = false;
    let open    = false;

    /* ── DOM Elements ── */
    const btn       = document.getElementById('sbot-btn');
    const win       = document.getElementById('sbot-window');
    const msgs      = document.getElementById('sbot-msgs');
    const form      = document.getElementById('sbot-form');
    const input     = document.getElementById('sbot-input');
    const sendBtn   = document.getElementById('sbot-send');
    const typing    = document.getElementById('sbot-typing');
    const iconOpen  = document.getElementById('sbot-icon-open');
    const iconClose = document.getElementById('sbot-icon-close');
    const closeBtn  = document.getElementById('sbot-close-btn');
    const chips     = document.querySelectorAll('.sbot-chip');

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

    /* ── Toggle Chat ── */
    function openChat() {
        open = true;
        win.hidden = false;
        iconOpen.style.display = 'none';
        iconClose.style.display = 'inline';

        if (msgs.querySelectorAll('.sbot-row').length === 0) {
            // First time open -> Show Greeting
            setTimeout(() => {
                addMsg('bot', GREETING);
                history.push({ role: 'bot', content: GREETING });
            }, 300);
        }
        input.focus();
    }

    function closeChat() {
        open = false;
        win.hidden = true;
        iconOpen.style.display = 'inline';
        iconClose.style.display = 'none';
    }

    btn.addEventListener('click', () => open ? closeChat() : openChat());
    closeBtn.addEventListener('click', closeChat);
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && open) closeChat();
    });

    /* ── Input Auto-resize ── */
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 100) + 'px';
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
            const text = chip.textContent;
            sendMessage(text);
        });
    });

    /* ── Send Form ── */
    form.addEventListener('submit', e => {
        e.preventDefault();
        const text = input.value.trim();
        if (text) {
            sendMessage(text);
        }
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
                    history: history.slice(-8), // Send last 8 context
                }),
            });

            if (!res.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await res.json();
            const reply = data.reply || 'Lo siento, no pude procesar la respuesta.';

            addMsg('bot', reply);
            history.push({ role: 'bot', content: reply });

        } catch (err) {
            console.error('[Spotlight Chatbot Error]', err);
            // Fallback error message (graceful UI)
            addMsg('bot', 'No pude conectar temporalmente con el servidor. Por favor, intenta de nuevo en unos momentos.');
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
@endonce
