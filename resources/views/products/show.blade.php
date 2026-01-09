@extends('layouts.app')

@section('title', $product->name)

@section('content')

<section class="swiss-container py-12">
    <div class="swiss-grid">
        
        <!-- Product Image -->
        <div class="col-span-12 md:col-span-7">
            <div class="sticky top-24">
                <div class="aspect-square bg-white rounded-lg mb-4 overflow-hidden border border-gray-200 shadow-lg">
                    @if($product->image)
                        <img src="{{ $product->image }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-9xl text-gray-300 font-bold">
                                {{ substr($product->name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                </div>
                
                <!-- Thumbnail Gallery (if multiple images) -->
                @if($product->images && count($product->images) > 0)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <div class="aspect-square bg-gray-100 border border-gray-300 hover:border-red-600 cursor-pointer transition-all rounded">
                                <img src="{{ asset($image) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-span-12 md:col-span-5">
            <div class="md:pl-12">
                
                <!-- Category -->
                <p class="text-sm text-gray-600 mb-2">
                    {{ strtoupper($product->category->name) }}
                </p>
                
                <!-- Product Name -->
                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                
                <!-- Price -->
                <div class="mb-8 pb-6 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-3">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 fill-yellow-400" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                        <span class="text-sm text-gray-600">| Đã bán {{ rand(100, 9999) }}</span>
                    </div>
                    <div class="flex items-baseline space-x-3">
                        <span class="text-xs text-gray-400 line-through">
                            {{ number_format($product->price * 1.5, 0, ',', '.') }}₫
                        </span>
                        <span class="text-4xl font-bold text-red-600">
                            {{ number_format($product->price, 0, ',', '.') }}₫
                        </span>
                        <span class="text-sm bg-red-100 text-red-600 px-2 py-1 rounded font-bold">
                            -{{ rand(10, 50) }}%
                        </span>
                    </div>
                    </div>
                </div>
                
                <!-- Stock Status -->
                <div class="mb-8">
                    @if($product->stock_quantity > 0)
                        <div class="flex items-center space-x-3 bg-swiss-red bg-opacity-10 px-4 py-3 border-l-4 border-swiss-red">
                            <div class="w-3 h-3 bg-swiss-red animate-pulse"></div>
                            <span class="font-bold">CÒN HÀNG: {{ $product->stock_quantity }} {{ $product->unit }}</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-3 bg-swiss-gray-100 px-4 py-3 border-l-4 border-swiss-gray-400">
                            <div class="w-3 h-3 bg-swiss-gray-400"></div>
                            <span class="font-bold text-swiss-gray-600">HẾT HÀNG</span>
                        </div>
                    @endif
                </div>
                
                <!-- Add to Cart Form -->
                @auth
                    @if($product->stock_quantity > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-8">
                            @csrf
                            
                            <!-- Quantity -->
                            <div class="mb-6">
                                <label class="font-bold mb-3 block tracking-wide">SỐ LƯỢNG</label>
                                <div class="flex items-center space-x-4">
                                    <button type="button" 
                                            onclick="decrementQuantity()"
                                            class="w-12 h-12 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all font-bold">
                                        −
                                    </button>
                                    <input type="number" 
                                           name="quantity" 
                                           id="quantity"
                                           value="1" 
                                           min="1" 
                                           max="{{ $product->stock_quantity }}"
                                           class="w-20 h-12 border-2 border-swiss-black text-center font-bold text-xl">
                                    <button type="button" 
                                            onclick="incrementQuantity()"
                                            class="w-12 h-12 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all font-bold">
                                        +
                                    </button>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn-primary w-full h-14 text-lg">
                                THÊM VÀO GIỎ HÀNG
                            </button>
                        </form>
                    @endif
                @else
                    <div class="mb-8 p-6 border-2 border-swiss-gray-300">
                        <p class="font-medium mb-4">Vui lòng đăng nhập để mua hàng</p>
                        <a href="{{ route('login') }}" class="btn-primary w-full inline-block text-center">
                            ĐĂNG NHẬP
                        </a>
                    </div>
                @endauth
                
                <!-- Product Details -->
                <div class="mb-8 pb-8 border-b-2 border-swiss-gray-300">
                    <h3 class="font-bold mb-4 tracking-wide">MÔ TẢ SẢN PHẨM</h3>
                    <div class="swiss-body text-swiss-gray-700 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
                
                <!-- Product Meta -->
                <div class="space-y-3 swiss-small">
                    <div class="flex justify-between">
                        <span class="text-swiss-gray-600">Mã sản phẩm:</span>
                        <span class="font-bold">{{ $product->code }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-swiss-gray-600">Danh mục:</span>
                        <span class="font-bold">{{ $product->category->name }}</span>
                    </div>
                    @if($product->supplier)
                        <div class="flex justify-between">
                            <span class="text-swiss-gray-600">Nhà cung cấp:</span>
                            <span class="font-bold">{{ $product->supplier->name }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-swiss-gray-600">Đơn vị:</span>
                        <span class="font-bold">{{ $product->unit }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
    <section class="bg-swiss-gray-50 py-16 mt-24">
        <div class="swiss-container">
            <div class="mb-12">
                <h2 class="swiss-h3">SẢN PHẨM LIÊN QUAN</h2>
                <div class="w-16 h-1 bg-swiss-red mt-2"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                @foreach($relatedProducts as $related)
                    <article class="group">
                        <a href="{{ route('products.show', $related->slug) }}" class="block">
                            <div class="aspect-square bg-white mb-4 overflow-hidden">
                                <div class="w-full h-full flex items-center justify-center 
                                            group-hover:scale-110 transition-transform duration-500">
                                    <span class="text-6xl text-swiss-gray-300 font-bold">
                                        {{ substr($related->name, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <h3 class="font-bold leading-tight group-hover:text-swiss-red transition-colors">
                                    {{ $related->name }}
                                </h3>
                                <div class="flex items-baseline justify-between">
                                    <span class="text-xl font-bold">
                                        {{ number_format($related->price, 0, ',', '.') }}₫
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection

@push('scripts')
<script>
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.min);
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}
</script>
@endpush
