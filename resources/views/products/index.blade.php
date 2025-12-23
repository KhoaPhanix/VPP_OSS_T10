@extends('layouts.app')

@section('title', 'Sản phẩm')

@section('content')

<!-- Page Header -->
<section class="border-b-2 border-swiss-black">
    <div class="swiss-container py-12">
        <h1 class="swiss-h2 mb-2">TẤT CẢ SẢN PHẨM</h1>
        <div class="w-16 h-1 bg-swiss-red"></div>
    </div>
</section>

<!-- Filters & Products -->
<section class="swiss-container py-12">
    <div class="swiss-grid">
        
        <!-- Sidebar Filters -->
        <aside class="col-span-12 md:col-span-3" x-data="productFilters">
            <div class="sticky top-24">
                
                <!-- Search -->
                <div class="mb-8">
                    <label class="font-bold mb-3 block tracking-wide">TÌM KIẾM</label>
                    <input type="text" 
                           x-model="searchQuery"
                           @keyup.enter="applyFilters()"
                           placeholder="Nhập tên sản phẩm..."
                           class="swiss-input">
                </div>
                
                <!-- Categories -->
                <div class="mb-8">
                    <label class="font-bold mb-3 block tracking-wide">DANH MỤC</label>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" 
                                   name="category" 
                                   value="" 
                                   x-model="category"
                                   @change="applyFilters()"
                                   class="mr-3">
                            <span class="group-hover:text-swiss-red transition-colors">Tất cả</span>
                        </label>
                        @foreach($categories as $cat)
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" 
                                       name="category" 
                                       value="{{ $cat->id }}" 
                                       x-model="category"
                                       @change="applyFilters()"
                                       {{ request('category') == $cat->id ? 'checked' : '' }}
                                       class="mr-3">
                                <span class="group-hover:text-swiss-red transition-colors">
                                    {{ $cat->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Sort -->
                <div class="mb-8">
                    <label class="font-bold mb-3 block tracking-wide">SẮP XẾP</label>
                    <select x-model="sortBy" 
                            @change="applyFilters()"
                            class="swiss-input">
                        <option value="name">Tên A-Z</option>
                        <option value="price">Giá thấp → cao</option>
                        <option value="-price">Giá cao → thấp</option>
                        <option value="-created_at">Mới nhất</option>
                    </select>
                </div>
                
                <!-- Reset -->
                <button @click="category = ''; sortBy = 'name'; searchQuery = ''; applyFilters()"
                        class="btn-secondary w-full">
                    XÓA BỘ LỌC
                </button>
            </div>
        </aside>
        
        <!-- Products Grid -->
        <div class="col-span-12 md:col-span-9">
            
            <!-- Results Count -->
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-swiss-gray-300">
                <p class="font-medium">
                    <span class="text-2xl font-bold">{{ $products->total() }}</span> sản phẩm
                </p>
                
                <!-- View Toggle (optional) -->
                <div class="hidden md:flex space-x-2">
                    <button class="w-10 h-10 border-2 border-swiss-black bg-swiss-black text-white">
                        <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </button>
                    <button class="w-10 h-10 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all">
                        <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Products -->
            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-8 mb-12">
                    @foreach($products as $product)
                        <article class="group animate-fade-in">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <!-- Image -->
                                <div class="aspect-square bg-swiss-gray-100 mb-4 overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center 
                                                group-hover:scale-110 transition-transform duration-500">
                                        <span class="text-6xl text-swiss-gray-300 font-bold">
                                            {{ substr($product->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Info -->
                                <div class="space-y-2">
                                    <p class="swiss-small text-swiss-gray-600 tracking-wide">
                                        {{ strtoupper($product->category->name) }}
                                    </p>
                                    <h3 class="font-bold text-lg leading-tight 
                                               group-hover:text-swiss-red transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                    <div class="flex items-baseline justify-between">
                                        <span class="text-2xl font-bold">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </span>
                                        <span class="swiss-small text-swiss-gray-600">
                                            @if($product->stock_quantity > 0)
                                                Còn {{ $product->stock_quantity }}
                                            @else
                                                <span class="text-swiss-red">Hết hàng</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="border-t-2 border-swiss-gray-300 pt-8">
                    {{ $products->links('vendor.pagination.swiss') }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-9xl font-bold text-swiss-gray-200 mb-4">∅</div>
                    <h3 class="swiss-h3 mb-4">KHÔNG TÌM THẤY SẢN PHẨM</h3>
                    <p class="swiss-body text-swiss-gray-600 mb-8">
                        Vui lòng thử lại với bộ lọc khác
                    </p>
                    <a href="{{ route('products.index') }}" class="btn-primary">
                        XEM TẤT CẢ
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
