@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')

<!-- Hero Banner -->
<section class="bg-gradient-to-r from-red-600 via-red-500 to-orange-500 py-12">
    <div class="swiss-container">
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center">
                <div class="p-8 md:p-12">
                    <span class="bg-red-600 text-white px-3 py-1 text-sm font-bold rounded inline-block mb-4">KHUYẾN MÃI LỚN</span>
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        GIẢM ĐẾN <span class="text-red-600">40%</span>
                    </h1>
                    <p class="text-lg text-gray-700 mb-6">
                        Văn phòng phẩm chất lượng cao - Giá tốt nhất thị trường
                    </p>
                    <div class="flex gap-4">
                        <a href="{{ route('products.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-bold transition-all shadow-lg hover:shadow-xl">
                            MUA NGAY
                        </a>
                        <a href="{{ route('products.index') }}" class="border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white px-8 py-3 rounded-lg font-bold transition-all">
                            XEM THÊM
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=800&h=600&fit=crop" alt="Promotion" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Grid -->
<section class="bg-gray-50 py-12">
    <div class="swiss-container">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900">DANH MỤC NỔI BẬT</h2>
            <a href="{{ route('products.index') }}" class="text-red-600 hover:text-red-700 font-medium hidden md:inline-block">
                Xem tất cả →
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                   class="group bg-white rounded-lg p-4 hover:shadow-lg transition-all duration-300">
                    <div class="aspect-square bg-gray-100 rounded-lg mb-3 overflow-hidden">
                        @if($category->image)
                            <img src="{{ Str::startsWith($category->image, 'http') ? $category->image : asset($category->image) }}" 
                                 alt="{{ $category->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-3xl text-gray-400 font-bold">
                                    {{ substr($category->name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-sm font-medium text-center group-hover:text-red-600 transition-colors">{{ $category->name }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="swiss-container py-12">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-900">SẢN PHẨM NỔI BẬT</h2>
        <a href="{{ route('products.index') }}" class="text-red-600 hover:text-red-700 font-medium hidden md:inline-block">
            Xem tất cả →
        </a>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        @foreach($featuredProducts as $product)
            <article class="group hover:shadow-2xl transition-all duration-300 rounded-lg overflow-hidden" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <a href="{{ route('products.show', $product->slug) }}" class="block">
                    <!-- Image -->
                    <div class="aspect-square bg-gradient-to-br from-swiss-gray-100 to-swiss-gray-200 mb-4 overflow-hidden relative shadow-md">
                        <div class="w-full h-full flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                            <span class="text-6xl text-swiss-gray-300 font-bold group-hover:text-swiss-red transition-colors duration-500">
                                {{ substr($product->name, 0, 1) }}
                            </span>
                        </div>
                        
                        <!-- Badge -->
                        <div class="absolute top-4 left-4 bg-gradient-to-r from-swiss-red to-red-700 text-white px-3 py-1 text-xs font-bold shadow-lg">
                            MỚI
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="space-y-2 px-4 pb-4">
                        <p class="swiss-small text-swiss-gray-600 tracking-wide">
                            {{ strtoupper($product->category->name) }}
                        </p>
                        <h3 class="font-bold text-lg leading-tight group-hover:text-swiss-red transition-colors">
                            {{ $product->name }}
                        </h3>
                        <div class="flex items-baseline justify-between">
                            <span class="text-2xl font-bold">
                                {{ number_format($product->price, 0, ',', '.') }}₫
                            </span>
                            <span class="swiss-small text-swiss-gray-600">
                                Còn {{ $product->stock_quantity }}
                            </span>
                        </div>
                    </div>
                </a>
            </article>
        @endforeach
    </div>
    
    <div class="text-center mt-12">
        <a href="{{ route('products.index') }}" class="btn-primary">
            XEM TẤT CẢ SẢN PHẨM
        </a>
    </div>
</section>

<!-- Features -->
<section class="bg-gradient-to-br from-swiss-black via-gray-900 to-swiss-black text-white py-16 shadow-inner">
    <div class="swiss-container">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-sm mb-1">CHẤT LƯỢNG CAO</h3>
                <p class="text-xs text-gray-500">Sản phẩm chính hãng</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-sm mb-1">GIAO HÀNG NHANH</h3>
                <p class="text-xs text-gray-500">Xử lý trong 24h</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-sm mb-1">GIÁ CẢ HỢP LÝ</h3>
                <p class="text-xs text-gray-500">Giá tốt nhất thị trường</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-sm mb-1">HỖ TRỢ 24/7</h3>
                <p class="text-xs text-gray-500">Luôn sẵn sàng hỗ trợ</p>
            </div>
        </div>
    </div>
</section>

@endsection
