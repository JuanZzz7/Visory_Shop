@extends('layouts.dashboard')
@section('title', 'Mis Chats - Spotlight')
@section('page-title', 'Centro de Mensajes')

@section('sidebar-menu')
    @include('partials.sidebar')
@endsection

@section('dashboard-content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="vs-card h-100">
            <div class="p-3 border-bottom">
                <h6 class="fw-bold mb-0">Conversaciones recientes</h6>
            </div>
            <div class="list-group list-group-flush overflow-auto" style="max-height: 600px;">
                @forelse($chats as $chat)
                    <a href="{{ route('chat.show', $chat) }}" class="list-group-item list-group-item-action p-3 border-0 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; flex-shrink: 0;">
                                {{ strtoupper(substr($chat->name, 0, 1)) }}
                            </div>
                            <div class="overflow-hidden">
                                <div class="fw-bold text-dark text-truncate">{{ $chat->name }}</div>
                                <div class="text-muted text-xs text-truncate">
                                    {{ $chat->role === 'business' ? 'Empresa' : 'Cliente' }}
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-chat-left-text fs-1 d-block mb-2"></i>
                        No tienes mensajes aún.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        @if(auth()->user()->role === 'user')
            <div class="vs-card">
                <div class="p-3 border-bottom">
                    <h6 class="fw-bold mb-0">Contactar con empresas locales</h6>
                </div>
                <div class="p-3">
                    <div class="row g-3">
                        @foreach($companies as $biz)
                            <div class="col-md-6">
                                <div class="p-3 border rounded-4 d-flex align-items-center justify-content-between hover-shadow transition-all">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-info bg-opacity-10 text-info rounded p-2">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="fw-medium">{{ $biz->company->name ?? $biz->name }}</div>
                                    </div>
                                    <a href="{{ route('chat.show', $biz) }}" class="btn btn-sm btn-primary rounded-pill px-3">Chatear</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="vs-card h-100 d-flex flex-column align-items-center justify-content-center text-center p-5">
                <div class="bg-light rounded-circle p-4 mb-3">
                    <i class="bi bi-chat-quote text-primary" style="font-size: 3rem;"></i>
                </div>
                <h5 class="fw-bold">Selecciona una conversación</h5>
                <p class="text-muted">Tus clientes aparecerán aquí cuando te escriban un mensaje.</p>
            </div>
        @endif
    </div>
</div>
@endsection
