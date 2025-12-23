@extends('layouts.app')

@section('title', 'Chat với ' . ($receiver->full_name ?? $receiver->username))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr($receiver->full_name ?? $receiver->username, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ $receiver->full_name ?? $receiver->username }}</h2>
                    <p class="text-sm text-gray-500">{{ $receiver->email }}</p>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div id="messages-container" class="h-96 overflow-y-auto p-6 space-y-4 bg-gray-50">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md">
                        <div class="px-4 py-2 rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-white text-gray-900 border border-gray-200' }}">
                            <p class="text-sm">{{ $message->message }}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                            {{ $message->created_at->format('H:i - d/m/Y') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500">Chưa có tin nhắn nào</p>
                </div>
            @endforelse
        </div>

        <!-- Input -->
        <div class="px-6 py-4 border-t border-gray-200 bg-white">
            <form action="{{ route('chat.send', $receiver->id) }}" method="POST" class="flex space-x-3">
                @csrf
                <input 
                    type="text" 
                    name="message" 
                    placeholder="Nhập tin nhắn..." 
                    required
                    class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >
                <button 
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150 font-medium"
                >
                    Gửi
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto scroll to bottom
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });

    // Auto refresh messages every 5 seconds
    setInterval(() => {
        location.reload();
    }, 5000);
</script>
@endsection
