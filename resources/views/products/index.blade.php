@extends('layouts.app')

@section('title', 'Sản phẩm')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-red-600 via-red-500 to-orange-500 py-8">
    <div class="swiss-container">
        <h1 class="text-4xl font-bold text-white mb-2">TẤT CẢ SẢN PHẨM</h1>
        <p class="text-red-100">{{ $products->total() }} sản phẩm</p>
    </div>
</section>

<!-- Filters & Products -->
<section class="swiss-container py-8">
    <div class="swiss-grid">
        
        <!-- Sidebar Filters -->
        <aside class="col-span-12 md:col-span-3" x-data="productFilters">
            <div class="sticky top-24 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                
                <!-- Debug Info (Remove in production) -->
                <div class="mb-4 p-3 bg-gray-100 rounded text-xs" x-show="true">
                    <div><strong>Category:</strong> <span x-text="category || 'None'"></span></div>
                    <div><strong>Sort:</strong> <span x-text="sortBy"></span></div>
                    <div><strong>Search:</strong> <span x-text="searchQuery || 'None'"></span></div>
                </div>
                
                <!-- Search -->
                <div class="mb-6">
                    <label class="font-bold mb-3 block text-gray-900">TÌM KIẾM</label>
                    <input type="text" 
                           x-model="searchQuery"
                           @keyup.enter="applyFilters()"
                           placeholder="Nhập tên sản phẩm..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>
                
                <!-- Categories -->
                <div class="mb-6">
                    <label class="font-bold mb-3 block text-gray-900">DANH MỤC</label>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer group p-2 rounded hover:bg-gray-50">
                            <input type="radio" 
                                   name="category" 
                                   value="" 
                                   x-model="category"
                                   @change="applyFilters()"
                                   class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                            <span class="ml-3 text-gray-700 group-hover:text-red-600 transition-colors">Tất cả</span>
                        </label>
                        @foreach($categories as $cat)
                            <label class="flex items-center cursor-pointer group p-2 rounded hover:bg-gray-50">
                                <input type="radio" 
                                       name="category" 
                                       value="{{ $cat->id }}" 
                                       x-model="category"
                                       @change="applyFilters()"
                                       class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                <span class="ml-3 text-gray-700 group-hover:text-red-600 transition-colors">
                                    {{ $cat->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Sort -->
                <div class="mb-6">
                    <label class="font-bold mb-3 block text-gray-900">SẮP XẾP</label>
                    <select x-model="sortBy" 
                            @change="applyFilters()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="name">Tên A-Z</option>
                        <option value="price">Giá thấp → cao</option>
                        <option value="-price">Giá cao → thấp</option>
                        <option value="-created_at">Mới nhất</option>
                    </select>
                </div>
                
                <!-- Reset -->
                <button @click="category = ''; sortBy = 'name'; searchQuery = ''; applyFilters()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    XÓA BỘ LỌC
                </button>
            </div>
        </aside>
        
        <!-- Products Grid -->
        <div class="col-span-12 md:col-span-9">
            
            <!-- Results Count -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Sản phẩm</h2>
                    <p class="text-gray-600">{{ $products->total() }} sản phẩm có sẵn</p>
                </div>
                
                <!-- View Toggle (optional) -->
                <div class="hidden md:flex space-x-2 bg-gray-100 p-1 rounded-lg">
                    <button class="p-2 bg-red-600 text-white rounded">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </button>
                    <button class="p-2 text-gray-600 hover:bg-white hover:text-gray-900 rounded transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Products -->
            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
                    @foreach($products as $product)
                        <article class="group bg-white border border-gray-200 hover:shadow-xl transition-all duration-300 rounded-lg overflow-hidden">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <!-- Image -->
                                <div class="aspect-square bg-white overflow-hidden relative">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <span class="text-6xl text-gray-300 font-bold">
                                                {{ substr($product->name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <!-- Badges -->
                                    <div class="absolute top-2 left-2 flex flex-col gap-1">
                                        @if($product->is_featured)
                                            <span class="bg-red-600 text-white px-2 py-1 text-xs font-bold rounded">HOT</span>
                                        @endif
                                        @if($product->stock_quantity > 0 && $product->price < 50000)
                                            <span class="bg-green-600 text-white px-2 py-1 text-xs font-bold rounded">FREESHIP</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Discount Badge -->
                                    @php
                                        $discount = rand(10, 40);
                                        $oldPrice = $product->price * (100 + $discount) / 100;
                                    @endphp
                                    <div class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 text-xs font-bold rounded-full">
                                        -{{ $discount }}%
                                    </div>
                                </div>
                                
                                <!-- Info -->
                                <div class="p-3">
                                    <h3 class="text-sm leading-tight mb-2 line-clamp-2 group-hover:text-red-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    <!-- Rating -->
                                    <div class="flex items-center gap-1 mb-2">
                                        @for($i = 0; $i < 5; $i++)
                                            <svg class="w-3 h-3 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="mb-2">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-red-600 font-bold text-lg">
                                                {{ number_format($product->price, 0, ',', '.') }}₫
                                            </span>
                                            <span class="text-gray-400 line-through text-sm">
                                                {{ number_format($oldPrice, 0, ',', '.') }}₫
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600">
                                            Đã bán {{ rand(50, 999) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            
                            <!-- Quick View Button -->
                            <div class="px-3 pb-3">
                                <button onclick="window.location.href='{{ route('products.show', $product->slug) }}'" 
                                        class="w-full py-2 border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition-all rounded font-medium text-sm">
                                    XEM NHANH
                                </button>
                            </div>
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
