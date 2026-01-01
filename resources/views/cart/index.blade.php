@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')

<section class="swiss-container py-16">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">GIỎ HÀNG CỦA BẠN</h1>
        <div class="w-16 h-1 bg-red-600"></div>
    </div>

    @if($cartItems->count() > 0)
        <div class="swiss-grid">
            
            <!-- Cart Items -->
            <div class="col-span-12 lg:col-span-8">
                <div class="border border-gray-200 shadow-md rounded-lg overflow-hidden bg-white">
                    
                    <!-- Header -->
                    <div class="hidden md:grid grid-cols-12 gap-4 p-4 border-b border-gray-200 bg-gray-50">
                        <div class="col-span-6 font-bold text-sm">SẢN PHẨM</div>
                        <div class="col-span-2 font-bold text-sm text-center">ĐƠN GIÁ</div>
                        <div class="col-span-2 font-bold text-sm text-center">SỐ LƯỢNG</div>
                        <div class="col-span-2 font-bold text-sm text-right">THÀNH TIỀN</div>
                    </div>

                    <!-- Cart Items -->
                    @foreach($cartItems as $item)
                        <div class="grid grid-cols-12 gap-4 p-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-all">
                            
                            <!-- Product Info -->
                            <div class="col-span-12 md:col-span-6 flex items-center space-x-4">
                                <div class="w-20 h-20 bg-gray-100 flex-shrink-0 rounded overflow-hidden">
                                    @if($item->product->image)
                                        <img src="{{ $item->product->image }}" 
                                             alt="{{ $item->product->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <span class="text-2xl font-bold text-gray-300">
                                                {{ substr($item->product->name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div>
                                    <h3 class="font-bold mb-1">
                                        <a href="{{ route('products.show', $item->product->slug) }}" 
                                           class="hover:text-swiss-red transition-colors">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    <p class="swiss-small text-swiss-gray-600">
                                        Mã: {{ $item->product->code }}
                                    </p>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="col-span-4 md:col-span-2 flex items-center md:justify-center">
                                <div>
                                    <span class="md:hidden swiss-small text-swiss-gray-600 block mb-1">Đơn giá:</span>
                                    <span class="font-bold">
                                        {{ number_format($item->product->price, 0, ',', '.') }}₫
                                    </span>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-span-4 md:col-span-2 flex items-center md:justify-center">
                                <div>
                                    <span class="md:hidden swiss-small text-swiss-gray-600 block mb-1">Số lượng:</span>
                                    <form action="{{ route('cart.update', $item->id) }}" 
                                          method="POST" 
                                          class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        
                                        <button type="submit" 
                                                name="action" 
                                                value="decrease"
                                                class="w-8 h-8 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all">
                                            −
                                        </button>
                                        
                                        <span class="w-12 text-center font-bold">
                                            {{ $item->quantity }}
                                        </span>
                                        
                                        <button type="submit" 
                                                name="action" 
                                                value="increase"
                                                class="w-8 h-8 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all">
                                            +
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Subtotal -->
                            <div class="col-span-4 md:col-span-2 flex items-center md:justify-end">
                                <div>
                                    <span class="md:hidden swiss-small text-swiss-gray-600 block mb-1">Thành tiền:</span>
                                    <span class="text-xl font-bold">
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}₫
                                    </span>
                                </div>
                            </div>

                            <!-- Remove Button (Mobile) -->
                            <div class="col-span-12 md:hidden mt-4">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-ghost w-full text-swiss-red border-swiss-red hover:bg-swiss-red">
                                        XÓA
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-span-12 lg:col-span-4">
                <div class="border-2 border-swiss-black p-8 sticky top-24">
                    
                    <h2 class="font-bold text-2xl mb-6 tracking-wide">TỔNG ĐơN HÀNG</h2>
                    
                    <div class="space-y-4 pb-6 border-b-2 border-swiss-gray-300">
                        <div class="flex justify-between">
                            <span class="text-swiss-gray-600">Tạm tính:</span>
                            <span class="font-bold">
                                {{ number_format($total, 0, ',', '.') }}₫
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-swiss-gray-600">Phí vận chuyển:</span>
                            <span class="font-bold">Miễn phí</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between py-6 mb-6">
                        <span class="text-2xl font-bold">TỔNG CỘNG:</span>
                        <span class="text-3xl font-bold text-swiss-red">
                            {{ number_format($total, 0, ',', '.') }}₫
                        </span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="btn-primary w-full h-14 text-center inline-block mb-4">
                        THANH TOÁN
                    </a>
                    
                    <a href="{{ route('products.index') }}" class="btn-secondary w-full text-center inline-block">
                        TIẾP TỤC MUA HÀNG
                    </a>
                </div>
            </div>
        </div>

    @else
        <!-- Empty Cart -->
        <div class="text-center py-24">
            <div class="mb-8">
                <div class="w-32 h-32 bg-swiss-gray-100 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-16 h-16 text-swiss-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h2 class="swiss-h3 mb-4">GIỎ HÀNG TRỐNG</h2>
                <p class="swiss-body text-swiss-gray-600 mb-8">
                    Bạn chưa có sản phẩm nào trong giỏ hàng
                </p>
            </div>
            
            <a href="{{ route('products.index') }}" class="btn-primary inline-block">
                KHÁM PHÁ SẢN PHẨM
            </a>
        </div>
    @endif

</section>

@endsection
