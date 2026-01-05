@extends('layouts.app')

@section('title', 'Chat với ' . ($receiver->full_name ?? $receiver->username))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="w-10 h-10 {{ $receiver->role == 'admin' ? 'bg-red-600' : 'bg-blue-600' }} rounded-full flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr($receiver->full_name ?? $receiver->username, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        {{ $receiver->full_name ?? $receiver->username }}
                        @if($receiver->role == 'admin')
                            <span class="ml-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded">Admin</span>
                        @endif
                    </h2>
                    <p class="text-sm text-gray-500">{{ $receiver->email }}</p>
                </div>
            </div>
            <div id="typing-indicator" class="text-sm text-gray-500 hidden">
                Đang nhập...
            </div>
        </div>

        <!-- Messages -->
        <div id="messages-container" class="h-[400px] overflow-y-auto p-6 space-y-4 bg-gray-50">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}" data-message-id="{{ $message->id }}">
                    <div class="max-w-xs lg:max-w-md">
                        <div class="px-4 py-2 rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-white text-gray-900 border border-gray-200' }}">
                            <p class="text-sm whitespace-pre-wrap">{{ $message->message }}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                            {{ $message->created_at->format('H:i') }}
                            @if($message->sender_id == auth()->id() && $message->is_read)
                                <span class="text-blue-500 ml-1">✓✓</span>
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8" id="empty-message">
                    <p class="text-gray-500">Bắt đầu cuộc trò chuyện...</p>
                </div>
            @endforelse
        </div>

        <!-- Input -->
        <div class="px-6 py-4 border-t border-gray-200 bg-white">
            <form id="chat-form" class="flex space-x-3">
                @csrf
                <input 
                    type="text" 
                    name="message" 
                    id="message-input"
                    placeholder="Nhập tin nhắn..." 
                    autocomplete="off"
                    required
                    class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >
                <button 
                    type="submit"
                    id="send-btn"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150 font-medium disabled:opacity-50"
                >
                    Gửi
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('messages-container');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');
    const receiverId = {{ $receiver->id }};
    const currentUserId = {{ auth()->id() }};
    let lastMessageId = {{ $messages->last()?->id ?? 0 }};

    // Auto scroll to bottom
    function scrollToBottom() {
        container.scrollTop = container.scrollHeight;
    }
    scrollToBottom();

    // Send message
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = input.value.trim();
        if (!message) return;

        sendBtn.disabled = true;
        input.value = '';

        // Optimistic UI update
        const emptyMsg = document.getElementById('empty-message');
        if (emptyMsg) emptyMsg.remove();

        const tempId = Date.now();
        const messageHtml = `
            <div class="flex justify-end" data-temp-id="${tempId}">
                <div class="max-w-xs lg:max-w-md">
                    <div class="px-4 py-2 rounded-lg bg-blue-600 text-white">
                        <p class="text-sm whitespace-pre-wrap">${escapeHtml(message)}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 text-right">Đang gửi...</p>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', messageHtml);
        scrollToBottom();

        try {
            const response = await fetch(`/chat/${receiverId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            if (data.success) {
                lastMessageId = data.chat.id;
                // Update temp message with real data
                const tempMsg = document.querySelector(`[data-temp-id="${tempId}"]`);
                if (tempMsg) {
                    tempMsg.setAttribute('data-message-id', data.chat.id);
                    tempMsg.removeAttribute('data-temp-id');
                    const timeEl = tempMsg.querySelector('.text-xs');
                    if (timeEl) {
                        const time = new Date(data.chat.created_at).toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'});
                        timeEl.textContent = time;
                    }
                }
            }
        } catch (error) {
            console.error('Error sending message:', error);
        } finally {
            sendBtn.disabled = false;
            input.focus();
        }
    });

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Poll for new messages every 3 seconds
    setInterval(async () => {
        try {
            const response = await fetch(`/chat/${receiverId}/messages`);
            const data = await response.json();
            
            data.messages.forEach(msg => {
                if (msg.id > lastMessageId && msg.sender_id != currentUserId) {
                    const messageHtml = `
                        <div class="flex justify-start" data-message-id="${msg.id}">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="px-4 py-2 rounded-lg bg-white text-gray-900 border border-gray-200">
                                    <p class="text-sm whitespace-pre-wrap">${escapeHtml(msg.message)}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 text-left">
                                    ${new Date(msg.created_at).toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'})}
                                </p>
                            </div>
                        </div>
                    `;
                    const emptyMsg = document.getElementById('empty-message');
                    if (emptyMsg) emptyMsg.remove();
                    container.insertAdjacentHTML('beforeend', messageHtml);
                    scrollToBottom();
                    lastMessageId = msg.id;
                }
            });
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    }, 3000);

    // Focus input on load
    input.focus();
});
</script>
@endsection
