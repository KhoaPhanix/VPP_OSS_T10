<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'VPP Online') | Văn Phòng Phẩm</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="h-full flex flex-col" x-data="cart">
    
    <!-- Header -->
    <header class="bg-red-600 sticky top-0 z-50 shadow-lg">
        <div class="swiss-container">
            <!-- Top Bar -->
            <div class="py-4 md:py-6">
                <div class="flex items-center justify-between gap-4">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group flex-shrink-0">
                        <img src="{{ asset('images/logo.jpg') }}" 
                             alt="VPP Online" 
                             class="h-12 w-auto group-hover:scale-105 transition-transform duration-300">
                        <div class="hidden lg:block">
                            <div class="text-xl font-bold tracking-tight leading-none text-white">VPP ONLINE</div>
                            <div class="text-xs tracking-wide text-red-100">Hệ thống Văn phòng phẩm Online</div>
                        </div>
                    </a>
                    
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-2xl hidden md:block">
                        <form action="{{ route('products.index') }}" method="GET" class="relative">
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Tìm kiếm sản phẩm..."
                                       class="w-full pl-12 pr-4 py-3 border-0 focus:ring-2 focus:ring-white transition-all duration-200 font-medium text-gray-900 placeholder-gray-500 rounded-lg">
                                <div class="absolute left-0 top-0 h-full w-12 flex items-center justify-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                @if(request('search'))
                                    <a href="{{ route('products.index') }}" 
                                       class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-600 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-3 flex-shrink-0">
                        @auth
                            <!-- Cart -->
                            <a href="{{ route('cart.index') }}" class="relative group">
                                <div class="w-10 h-10 bg-white flex items-center justify-center
                                            group-hover:bg-red-700 group-hover:scale-110 transition-all duration-300 shadow-md rounded">
                                    <svg class="w-5 h-5 text-red-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <span x-show="count > 0" 
                                      x-text="count"
                                      class="absolute -top-2 -right-2 w-5 h-5 bg-yellow-400 text-red-600 animate-pulse 
                                             text-xs font-bold flex items-center justify-center rounded-full">
                                </span>
                            </a>
                            
                            <!-- User Menu -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" 
                                        class="w-10 h-10 bg-white flex items-center justify-center
                                               hover:bg-red-700 transition-all rounded">
                                    <svg class="w-5 h-5 text-red-600 hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </button>
                                
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition
                                     class="absolute right-0 mt-2 w-64 bg-white border-2 border-swiss-black shadow-xl z-50 rounded-lg overflow-hidden">
                                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                                        <div class="font-bold text-gray-900">{{ auth()->user()->full_name ?? auth()->user()->username }}</div>
                                        <div class="text-sm text-gray-600">{{ auth()->user()->email }}</div>
                                        @if(auth()->user()->isAdmin())
                                            <span class="inline-block mt-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded font-medium">Admin</span>
                                        @endif
                                    </div>
                                    <div class="py-2">
                                        <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            Đơn hàng của tôi
                                        </a>
                                        <a href="{{ route('chat.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            Tin nhắn
                                        </a>
                                        <a href="{{ route('cart.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                            </svg>
                                            Giỏ hàng
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                            <div class="border-t border-gray-200 my-2"></div>
                                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                Quản trị Admin
                                            </a>
                                        @endif
                                    </div>
                                    <div class="border-t border-gray-200">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                </svg>
                                                Đăng xuất
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" 
                               class="hidden sm:inline-block px-5 py-2.5 text-white font-semibold text-sm
                                      border-2 border-white rounded-lg hover:bg-white hover:text-red-600 
                                      transition-all duration-300">
                                ĐĂNG NHẬP
                            </a>
                            <a href="{{ route('register') }}" 
                               class="px-5 py-2.5 bg-white text-red-600 font-bold text-sm rounded-lg 
                                      hover:bg-yellow-400 hover:text-red-700 hover:scale-105
                                      transition-all duration-300 shadow-md">
                                ĐĂNG KÝ
                            </a>
                        @endauth
                        
                        <!-- Mobile Menu Toggle -->
                        <button x-data="mobileMenu" 
                                @click="toggle()"
                                class="md:hidden w-10 h-10 border-2 border-swiss-black flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Search Bar -->
                <div class="md:hidden mt-4">
                    <form action="{{ route('products.index') }}" method="GET" class="relative">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Tìm kiếm sản phẩm..."
                                   class="w-full pl-12 pr-4 py-3 border-2 border-swiss-black focus:border-swiss-red focus:ring-0 transition-all duration-200 font-medium text-swiss-black placeholder-swiss-gray-500 shadow-md">
                            <div class="absolute left-0 top-0 h-full w-12 flex items-center justify-center pointer-events-none">
                                <svg class="w-5 h-5 text-swiss-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center justify-center space-x-8 mt-4 pt-4 border-t border-red-500">
                    <a href="{{ route('products.index') }}" 
                       class="font-medium tracking-wide text-white hover:text-yellow-300 transition-colors
                              {{ request()->routeIs('products.*') ? 'text-yellow-300' : '' }}">
                        SẢN PHẨM
                    </a>
                    @auth
                        <a href="{{ route('orders.index') }}" 
                           class="font-medium tracking-wide text-white hover:text-yellow-300 transition-colors
                                  {{ request()->routeIs('orders.*') ? 'text-yellow-300' : '' }}">
                            ĐƠN HÀNG
                        </a>
                        <a href="{{ route('chat.index') }}" 
                           class="font-medium tracking-wide text-white hover:text-yellow-300 transition-colors
                                  {{ request()->routeIs('chat.*') ? 'text-yellow-300' : '' }}">
                            TRÒ CHUYỆN
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="font-medium tracking-wide text-yellow-300 hover:text-yellow-400 transition-colors">
                                ADMIN
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Flash Messages -->
    @if(session('success') || session('error'))
        <div class="swiss-container py-4 animate-fade-in">
            @if(session('success'))
                <div class="border-l-4 border-swiss-red bg-swiss-gray-50 p-4">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-swiss-red text-white flex items-center justify-center mr-3">✓</div>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="border-l-4 border-swiss-black bg-swiss-gray-50 p-4">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-swiss-black text-white flex items-center justify-center mr-3">!</div>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
        </div>
    @endif
    
    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="swiss-container py-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-red-600 flex items-center justify-center rounded">
                            <span class="text-white font-bold text-xl">V</span>
                        </div>
                        <h3 class="text-lg font-bold">VPP ONLINE</h3>
                    </div>
                    <p class="text-sm text-gray-400">
                        Hệ thống bán văn phòng phẩm trực tuyến chất lượng cao.
                    </p>
                </div>
                
                <!-- Links -->
                <div>
                    <h4 class="font-bold mb-3 text-sm">DANH MỤC</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('products.index') }}" class="hover:text-red-500 transition-colors">Sản phẩm</a></li>
                        <li><a href="{{ route('products.index', ['category' => 1]) }}" class="hover:text-red-500 transition-colors">Bút viết</a></li>
                        <li><a href="{{ route('products.index', ['category' => 2]) }}" class="hover:text-red-500 transition-colors">Giấy tờ</a></li>
                        <li><a href="{{ route('products.index', ['category' => 3]) }}" class="hover:text-red-500 transition-colors">Sổ tay</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-3 text-sm">HỖ TRỢ</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="hover:text-red-500 transition-colors">Đơn hàng của tôi</a></li>
                            <li><a href="{{ route('chat.index') }}" class="hover:text-red-500 transition-colors">Liên hệ</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-red-500 transition-colors">Đăng nhập</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-red-500 transition-colors">Đăng ký</a></li>
                        @endauth
                        <li><a href="#" class="hover:text-red-500 transition-colors">Chính sách đổi trả</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-3 text-sm">NHÓM PHÁT TRIỂN</h4>
                    <ul class="space-y-1 text-sm text-gray-400">
                        <li>Nguyễn Đình Nhật Huy</li>
                        <li>Hồ Hoàng Long</li>
                        <li>Phan Đăng Khoa</li>
                    </ul>
                    <div class="flex gap-3 mt-4">
                        <a href="#" class="w-8 h-8 bg-gray-700 hover:bg-red-600 rounded flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-700 hover:bg-red-600 rounded flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-6">
                <p class="text-center text-sm text-gray-400">
                    © 2024 VPP_OSS_T10. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>
