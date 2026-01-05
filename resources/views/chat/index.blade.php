@extends('layouts.app')

@section('title', 'Tin nhắn')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Tin nhắn</h1>
            @if(auth()->user()->isCustomer() && $admins->count() > 0)
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                        + Liên hệ hỗ trợ
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-xl z-50">
                        <div class="p-2">
                            <p class="text-xs text-gray-500 px-3 py-2">Chọn admin để liên hệ:</p>
                            @foreach($admins as $admin)
                                <a href="{{ route('chat.show', $admin->id) }}" 
                                   class="flex items-center px-3 py-2 hover:bg-gray-50 rounded-lg transition-colors">
                                    <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-3">
                                        {{ strtoupper(substr($admin->full_name ?? $admin->username, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm">{{ $admin->full_name ?? $admin->username }}</div>
                                        <div class="text-xs text-gray-500">Admin</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($conversations as $user)
                <a href="{{ route('chat.show', $user->id) }}" 
                   class="block px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 relative">
                                <div class="w-12 h-12 {{ $user->role == 'admin' ? 'bg-red-600' : 'bg-blue-600' }} rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->full_name ?? $user->username, 0, 1)) }}
                                </div>
                                @if(isset($unreadCounts[$user->id]) && $unreadCounts[$user->id] > 0)
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                        {{ $unreadCounts[$user->id] }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $user->full_name ?? $user->username }}
                                    @if($user->role == 'admin')
                                        <span class="ml-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded">Admin</span>
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Chưa có tin nhắn</h3>
                    <p class="mt-1 text-sm text-gray-500">Bạn chưa có cuộc trò chuyện nào.</p>
                    @if(auth()->user()->isCustomer() && $admins->count() > 0)
                        <div class="mt-6">
                            <p class="text-sm text-gray-600 mb-3">Bắt đầu trò chuyện với hỗ trợ:</p>
                            <div class="flex flex-wrap justify-center gap-2">
                                @foreach($admins as $admin)
                                    <a href="{{ route('chat.show', $admin->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                        Chat với {{ $admin->full_name ?? $admin->username }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforelse

            @if(auth()->user()->isAdmin() && $customers->count() > 0)
                <div class="px-6 py-4 bg-gray-50">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Khách hàng chưa nhắn tin:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($customers->take(5) as $customer)
                            <a href="{{ route('chat.show', $customer->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-semibold mr-2">
                                    {{ strtoupper(substr($customer->full_name ?? $customer->username, 0, 1)) }}
                                </div>
                                {{ $customer->full_name ?? $customer->username }}
                            </a>
                        @endforeach
                        @if($customers->count() > 5)
                            <span class="text-sm text-gray-500 py-1.5">+{{ $customers->count() - 5 }} khách hàng khác</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
