@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')

<!-- Hero Section -->
<section class="swiss-container py-16 md:py-24">
    <div class="swiss-grid items-center">
        <div class="col-span-12 md:col-span-6">
            <h1 class="swiss-h1 mb-6">
                VĂN<br>
                PHÒNG<br>
                PHẨM
            </h1>
            <div class="w-24 h-1 bg-swiss-red mb-6"></div>
            <p class="swiss-body max-w-md mb-8 text-swiss-gray-700">
                Cung cấp đầy đủ các loại văn phòng phẩm chất lượng cao. 
                Thiết kế tối giản, chức năng tối đa.
            </p>
            <a href="{{ route('products.index') }}" class="btn-primary inline-block">
                XEM SẢN PHẨM
            </a>
        </div>
        
        <div class="col-span-12 md:col-span-6">
            <div class="relative">
                <div class="aspect-square bg-swiss-gray-100 flex items-center justify-center">
                    <div class="text-9xl font-bold text-swiss-gray-200">V</div>
                </div>
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-swiss-red"></div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Grid -->
<section class="bg-swiss-gray-50 py-16">
    <div class="swiss-container">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="swiss-h2">DANH MỤC</h2>
                <div class="w-16 h-1 bg-swiss-red mt-2"></div>
            </div>
            <a href="{{ route('products.index') }}" class="btn-ghost hidden md:inline-block">
                XEM TẤT CẢ →
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                   class="group swiss-card p-8 hover:scale-105 transform transition-all">
                    <div class="aspect-square bg-swiss-gray-100 mb-4 flex items-center justify-center
                                group-hover:bg-swiss-red transition-colors">
                        <span class="text-4xl group-hover:text-white transition-colors">
                            {{ substr($category->name, 0, 1) }}
                        </span>
                    </div>
                    <h3 class="font-bold tracking-wide">{{ strtoupper($category->name) }}</h3>
                    <p class="swiss-small text-swiss-gray-600 mt-1">
                        Xem ngay
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="swiss-container py-16 md:py-24">
    <div class="flex items-end justify-between mb-12">
        <div>
            <h2 class="swiss-h2">SẢN PHẨM NỔI BẬT</h2>
            <div class="w-16 h-1 bg-swiss-red mt-2"></div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
        @foreach($featuredProducts as $product)
            <article class="group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <a href="{{ route('products.show', $product->slug) }}" class="block">
                    <!-- Image -->
                    <div class="aspect-square bg-swiss-gray-100 mb-4 overflow-hidden relative">
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-6xl text-swiss-gray-300 font-bold">
                                {{ substr($product->name, 0, 1) }}
                            </span>
                        </div>
                        
                        <!-- Badge -->
                        <div class="absolute top-4 left-4 bg-swiss-red text-white px-3 py-1 text-xs font-bold">
                            MỚI
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="space-y-2">
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
<section class="bg-swiss-black text-white py-16">
    <div class="swiss-container">
        <div class="swiss-grid">
            <div class="col-span-12 md:col-span-3 text-center md:text-left mb-8 md:mb-0">
                <div class="text-5xl font-bold mb-4">01</div>
                <h3 class="font-bold text-xl mb-2">CHẤT LƯỢNG CAO</h3>
                <p class="swiss-small text-swiss-gray-400">
                    Sản phẩm chính hãng từ các thương hiệu uy tín
                </p>
            </div>
            
            <div class="col-span-12 md:col-span-3 text-center md:text-left mb-8 md:mb-0">
                <div class="text-5xl font-bold mb-4">02</div>
                <h3 class="font-bold text-xl mb-2">GIAO HÀNG NHANH</h3>
                <p class="swiss-small text-swiss-gray-400">
                    Đơn hàng được xử lý và giao trong 24h
                </p>
            </div>
            
            <div class="col-span-12 md:col-span-3 text-center md:text-left mb-8 md:mb-0">
                <div class="text-5xl font-bold mb-4">03</div>
                <h3 class="font-bold text-xl mb-2">GIÁ CẢ HỢP LÝ</h3>
                <p class="swiss-small text-swiss-gray-400">
                    Cam kết giá tốt nhất thị trường
                </p>
            </div>
            
            <div class="col-span-12 md:col-span-3 text-center md:text-left">
                <div class="text-5xl font-bold mb-4">04</div>
                <h3 class="font-bold text-xl mb-2">HỖ TRỢ 24/7</h3>
                <p class="swiss-small text-swiss-gray-400">
                    Đội ngũ hỗ trợ luôn sẵn sàng
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
