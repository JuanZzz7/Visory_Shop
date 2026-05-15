@extends('layouts.dashboard')
@section('title', 'Chat con ' . ($receiver->company->name ?? $receiver->name) . ' - Spotlight')

@section('sidebar-menu')
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="vs-nav-link"><i class="bi bi-speedometer2 fs-5"></i> Dashboard</a>
    @elseif(auth()->user()->role === 'business')
        <a href="{{ route('business.dashboard') }}" class="vs-nav-link"><i class="bi bi-speedometer2 fs-5"></i> Dashboard</a>
    @else
        <a href="{{ route('user.dashboard') }}" class="vs-nav-link"><i class="bi bi-shop fs-5"></i> Tienda</a>
    @endif
    <a href="{{ route('chat.index') }}" class="vs-nav-link active"><i class="bi bi-chat-dots fs-5"></i> Mensajes</a>
@endsection

@section('dashboard-content')
<div class="vs-card d-flex flex-column overflow-hidden border-0 shadow-sm" style="height: calc(100vh - 180px);">
    {{-- Header --}}
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-white">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('chat.index') }}" class="btn btn-sm btn-light rounded-circle"><i class="bi bi-arrow-left"></i></a>
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; font-weight: 600;">
                {{ strtoupper(substr($receiver->name, 0, 1)) }}
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-dark">{{ $receiver->company->name ?? $receiver->name }}</h6>
                <div class="d-flex align-items-center gap-1">
                    <span class="bg-success rounded-circle" style="width: 8px; height: 8px;"></span>
                    <span class="text-xs text-muted">En línea ahora</span>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-light rounded-circle" title="Llamar"><i class="bi bi-telephone"></i></button>
            <button class="btn btn-sm btn-light rounded-circle" title="Info"><i class="bi bi-info-circle"></i></button>
        </div>
    </div>

    {{-- Messages Area --}}
    <div class="flex-fill p-4 overflow-auto" id="chat-messages" style="background-color: #f8fafc; background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px); background-size: 20px 20px;">
        @foreach($messages as $msg)
            <div class="d-flex mb-4 {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="p-3 shadow-sm {{ $msg->sender_id === auth()->id() ? 'bg-primary text-white chat-bubble-me' : 'bg-white text-dark chat-bubble-them' }}" style="max-width: 75%; border-radius: 1.25rem;">
                    <div class="text-sm" style="white-space: pre-wrap; line-height: 1.5;">{{ $msg->message }}</div>
                    <div class="text-end mt-2 d-flex align-items-center justify-content-end gap-1" style="font-size: 0.65rem; opacity: 0.8;">
                        {{ $msg->created_at->format('H:i') }}
                        @if($msg->sender_id === auth()->id())
                            <i class="bi bi-check2-all text-white"></i>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Input Area --}}
    <div class="p-3 bg-white border-top">
        <form id="chat-form" class="d-flex gap-2 align-items-center">
            @csrf
            <div class="flex-fill position-relative">
                <input type="text" id="message-input" class="form-control border-0 bg-light rounded-pill px-4 py-3" placeholder="Escribe un mensaje para {{ $receiver->company->name ?? $receiver->name }}..." autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                <i class="bi bi-send-fill fs-5"></i>
            </button>
        </form>
    </div>
</div>

<style>
    .chat-bubble-me {
        border-bottom-right-radius: 0.25rem !important;
    }
    .chat-bubble-them {
        border-bottom-left-radius: 0.25rem !important;
    }
    #chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    #chat-messages::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 10px;
    }
    @keyframes slideUpFade {
        from { opacity: 0; transform: translateX(-50%) translateY(16px); }
        to   { opacity: 1; transform: translateX(-50%) translateY(0); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const receiverId = "{{ $receiver->id }}";

    // Scroll al fondo al cargar
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Enviar mensaje por AJAX
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const msg = messageInput.value.trim();
        if (!msg) return;

        // Limpiar input inmediatamente para mejor UX
        messageInput.value = '';

        fetch("{{ route('chat.send', $receiver) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ message: msg })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                appendMessage(msg, true);
                chatMessages.scrollTo({ top: chatMessages.scrollHeight, behavior: 'smooth' });
            }
        });
    });

    // Polling para mensajes nuevos (cada 3 segundos)
    setInterval(() => {
        fetch(`{{ route('chat.messages', $receiver) }}`)
        .then(res => res.json())
        .then(messages => {
            if (messages.length > 0) {
                messages.forEach(m => {
                    appendMessage(m.message, false);
                });
                chatMessages.scrollTo({ top: chatMessages.scrollHeight, behavior: 'smooth' });
                // Mostrar notificación flotante dentro del chat
                showInChatAlert(messages.length);
            }
        });
    }, 3000);

    // Notificación flotante dentro del chat al recibir mensajes
    function showInChatAlert(count) {
        let alertEl = document.getElementById('in-chat-alert');
        if (!alertEl) {
            alertEl = document.createElement('div');
            alertEl.id = 'in-chat-alert';
            alertEl.style.cssText = `
                position: absolute; bottom: 80px; left: 50%; transform: translateX(-50%);
                background: linear-gradient(135deg,#6366f1,#818cf8);
                color: #fff; padding: 10px 22px; border-radius: 30px;
                font-size: 0.82rem; font-weight: 600; letter-spacing: 0.02em;
                box-shadow: 0 6px 24px rgba(99,102,241,0.45);
                display: flex; align-items: center; gap: 8px; z-index: 100;
                animation: slideUpFade 0.4s ease;
                cursor: pointer;
            `;
            alertEl.innerHTML = `<i class="bi bi-arrow-down-circle-fill"></i> <span id="in-chat-alert-txt"></span>`;
            alertEl.addEventListener('click', () => {
                chatMessages.scrollTo({ top: chatMessages.scrollHeight, behavior: 'smooth' });
                alertEl.remove();
            });
            // El contenedor del chat debe ser position:relative
            const container = document.querySelector('.vs-card.d-flex.flex-column');
            if (container) container.style.position = 'relative';
            container ? container.appendChild(alertEl) : document.body.appendChild(alertEl);
        }
        document.getElementById('in-chat-alert-txt').textContent =
            count === 1 ? '1 mensaje nuevo ↓' : `${count} mensajes nuevos ↓`;
        clearTimeout(alertEl._timer);
        alertEl._timer = setTimeout(() => alertEl.remove(), 5000);
    }

    function appendMessage(text, isMe) {
        const div = document.createElement('div');
        div.className = `d-flex mb-4 ${isMe ? 'justify-content-end' : 'justify-content-start'}`;
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        div.innerHTML = `
            <div class="p-3 shadow-sm ${isMe ? 'bg-primary text-white chat-bubble-me' : 'bg-white text-dark chat-bubble-them'}" style="max-width: 75%; border-radius: 1.25rem;">
                <div class="text-sm" style="white-space: pre-wrap; line-height: 1.5;">${text}</div>
                <div class="text-end mt-2 d-flex align-items-center justify-content-end gap-1" style="font-size: 0.65rem; opacity: 0.8;">
                    ${time} ${isMe ? '<i class="bi bi-check2-all text-white"></i>' : ''}
                </div>
            </div>
        `;
        chatMessages.appendChild(div);
    }
});
</script>
@endsection

