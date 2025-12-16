<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'VPP Online') | Văn Phòng Phẩm</title>
    
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
    <header class="border-b-2 border-swiss-black bg-white sticky top-0 z-50">
        <div class="swiss-container">
            <!-- Top Bar -->
            <div class="flex items-center justify-between py-4 md:py-6">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-swiss-red flex items-center justify-center">
                        <span class="text-white font-bold text-xl">V</span>
                    </div>
                    <div class="hidden md:block">
                        <div class="text-2xl font-bold tracking-tight leading-none">VPP ONLINE</div>
                        <div class="text-xs tracking-widest text-swiss-gray-600">STATIONERY STORE</div>
                    </div>
                </a>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('products.index') }}" 
                       class="font-medium tracking-wide hover:text-swiss-red transition-colors
                              {{ request()->routeIs('products.*') ? 'text-swiss-red' : 'text-swiss-black' }}">
                        SẢN PHẨM
                    </a>
                    @auth
                        <a href="{{ route('orders.index') }}" 
                           class="font-medium tracking-wide hover:text-swiss-red transition-colors
                                  {{ request()->routeIs('orders.*') ? 'text-swiss-red' : 'text-swiss-black' }}">
                            ĐƠN HÀNG
                        </a>
                        <a href="{{ route('chat.index') }}" 
                           class="font-medium tracking-wide hover:text-swiss-red transition-colors
                                  {{ request()->routeIs('chat.*') ? 'text-swiss-red' : 'text-swiss-black' }}">
                            TRÒ CHUYỆN
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="font-medium tracking-wide text-swiss-blue hover:text-swiss-red transition-colors">
                                ADMIN
                            </a>
                        @endif
                    @endauth
                </nav>
                
                <!-- Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative group">
                            <div class="w-10 h-10 border-2 border-swiss-black flex items-center justify-center
                                        group-hover:bg-swiss-black transition-all">
                                <svg class="w-5 h-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <span x-show="count > 0" 
                                  x-text="count"
                                  class="absolute -top-2 -right-2 w-5 h-5 bg-swiss-red text-white 
                                         text-xs font-bold flex items-center justify-center">
                            </span>
                        </a>
                        
                        <!-- User Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" 
                                    class="w-10 h-10 border-2 border-swiss-black flex items-center justify-center
                                           hover:bg-swiss-black hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-64 bg-white border-2 border-swiss-black shadow-xl">
                                <div class="p-4 border-b-2 border-swiss-gray-200">
                                    <div class="font-bold">{{ auth()->user()->full_name }}</div>
                                    <div class="text-sm text-swiss-gray-600">{{ auth()->user()->email }}</div>
                                </div>
                                <form method="POST" action="{{ route('logout') }}" class="p-2">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left px-4 py-2 font-medium hover:bg-swiss-gray-50">
                                        ĐĂNG XUẤT
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-ghost">ĐĂNG NHẬP</a>
                        <a href="{{ route('register') }}" class="btn-primary">ĐĂNG KÝ</a>
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
    <footer class="border-t-2 border-swiss-black mt-24 bg-swiss-gray-50">
        <div class="swiss-container py-12">
            <div class="swiss-grid">
                <!-- Brand -->
                <div class="col-span-12 md:col-span-4 mb-8 md:mb-0">
                    <div class="w-16 h-16 bg-swiss-red flex items-center justify-center mb-4">
                        <span class="text-white font-bold text-3xl">V</span>
                    </div>
                    <h3 class="swiss-h4 mb-2">VPP ONLINE</h3>
                    <p class="swiss-small text-swiss-gray-600 max-w-xs">
                        Hệ thống bán văn phòng phẩm trực tuyến. 
                        Chất lượng cao, giá cả hợp lý.
                    </p>
                </div>
                
                <!-- Links -->
                <div class="col-span-6 md:col-span-2">
                    <h4 class="font-bold mb-4 tracking-wide">DANH MỤC</h4>
                    <ul class="space-y-2 swiss-small">
                        <li><a href="{{ route('products.index') }}" class="hover:text-swiss-red transition-colors">Sản phẩm</a></li>
                        <li><a href="{{ route('products.index', ['category' => 1]) }}" class="hover:text-swiss-red transition-colors">Bút viết</a></li>
                        <li><a href="{{ route('products.index', ['category' => 2]) }}" class="hover:text-swiss-red transition-colors">Giấy tờ</a></li>
                        <li><a href="{{ route('products.index', ['category' => 3]) }}" class="hover:text-swiss-red transition-colors">Sổ tay</a></li>
                    </ul>
                </div>
                
                <div class="col-span-6 md:col-span-3">
                    <h4 class="font-bold mb-4 tracking-wide">HỖ TRỢ</h4>
                    <ul class="space-y-2 swiss-small">
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="hover:text-swiss-red transition-colors">Đơn hàng</a></li>
                            <li><a href="{{ route('chat.index') }}" class="hover:text-swiss-red transition-colors">Liên hệ</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-swiss-red transition-colors">Đăng nhập</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-swiss-red transition-colors">Đăng ký</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div class="col-span-12 md:col-span-3">
                    <h4 class="font-bold mb-4 tracking-wide">NHÓM PHÁT TRIỂN</h4>
                    <ul class="space-y-1 swiss-small text-swiss-gray-600">
                        <li>Nguyễn Đình Nhật Huy</li>
                        <li>Hồ Hoàng Long</li>
                        <li>Phan Đăng Khoa</li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t-2 border-swiss-gray-300 mt-12 pt-6">
                <p class="text-center swiss-small text-swiss-gray-600">
                    © 2024 VPP_OSS_T10. Designed with Swiss Typography.
                </p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>
