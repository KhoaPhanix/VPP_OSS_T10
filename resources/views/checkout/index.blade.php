@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')

<section class="swiss-container py-16">
    
    <!-- Header -->
    <div class="mb-12">
        <h1 class="swiss-h2 mb-4 bg-gradient-to-r from-swiss-black to-swiss-red bg-clip-text text-transparent">THANH TOÁN</h1>
        <div class="w-16 h-1 bg-gradient-to-r from-swiss-red to-red-700"></div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="swiss-grid">
            
            <!-- Checkout Form -->
            <div class="col-span-12 lg:col-span-7">
                
                <!-- Customer Info -->
                <div class="border-2 border-swiss-black p-8 mb-8 shadow-xl rounded-lg bg-gradient-to-br from-white to-swiss-gray-50">
                    <h2 class="font-bold text-xl mb-6 tracking-wide">THÔNG TIN KHÁCH HÀNG</h2>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="full_name" class="font-bold mb-3 block tracking-wide">
                                    HỌ VÀ TÊN *
                                </label>
                                <input type="text" 
                                       id="full_name" 
                                       name="full_name" 
                                       value="{{ old('full_name', auth()->user()->full_name) }}"
                                       required
                                       class="swiss-input @error('full_name') border-swiss-red @enderror">
                                @error('full_name')
                                    <p class="mt-2 text-swiss-red swiss-small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="font-bold mb-3 block tracking-wide">
                                    SỐ ĐIỆN THOẠI *
                                </label>
                                <input type="text" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}"
                                       required
                                       class="swiss-input @error('phone') border-swiss-red @enderror">
                                @error('phone')
                                    <p class="mt-2 text-swiss-red swiss-small">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="font-bold mb-3 block tracking-wide">
                                EMAIL *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required
                                   class="swiss-input @error('email') border-swiss-red @enderror">
                            @error('email')
                                <p class="mt-2 text-swiss-red swiss-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="font-bold mb-3 block tracking-wide">
                                ĐỊA CHỈ GIAO HÀNG *
                            </label>
                            <textarea id="address" 
                                      name="address" 
                                      rows="3"
                                      required
                                      class="swiss-input @error('address') border-swiss-red @enderror">{{ old('address', auth()->user()->address) }}</textarea>
                            @error('address')
                                <p class="mt-2 text-swiss-red swiss-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="font-bold mb-3 block tracking-wide">
                                GHI CHÚ ĐƠN HÀNG
                            </label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="3"
                                      placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."
                                      class="swiss-input">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="border-2 border-swiss-black p-8">
                    <h2 class="font-bold text-xl mb-6 tracking-wide">PHƯƠNG THỨC THANH TOÁN</h2>
                    
                    <div class="space-y-4">
                        <label class="flex items-start p-4 border-2 border-swiss-gray-300 hover:border-swiss-black cursor-pointer transition-all">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="cod" 
                                   checked
                                   class="mt-1 w-5 h-5 border-2 border-swiss-black text-swiss-red focus:ring-0">
                            <div class="ml-4">
                                <div class="font-bold mb-1">THANH TOÁN KHI NHẬN HÀNG (COD)</div>
                                <p class="swiss-small text-swiss-gray-600">
                                    Thanh toán bằng tiền mặt khi nhận hàng
                                </p>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 border-swiss-gray-300 hover:border-swiss-black cursor-pointer transition-all">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="transfer"
                                   class="mt-1 w-5 h-5 border-2 border-swiss-black text-swiss-red focus:ring-0">
                            <div class="ml-4">
                                <div class="font-bold mb-1">CHUYỂN KHOẢN NGÂN HÀNG</div>
                                <p class="swiss-small text-swiss-gray-600">
                                    Thực hiện chuyển khoản theo thông tin được cung cấp sau khi đặt hàng
                                </p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-span-12 lg:col-span-5">
                <div class="border-2 border-swiss-black p-8 sticky top-24">
                    
                    <h2 class="font-bold text-2xl mb-6 tracking-wide">ĐƠN HÀNG</h2>
                    
                    <!-- Products -->
                    <div class="space-y-4 pb-6 border-b-2 border-swiss-gray-300 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="font-medium mb-1">{{ $item->product->name }}</div>
                                    <div class="swiss-small text-swiss-gray-600">
                                        {{ number_format($item->product->price, 0, ',', '.') }}₫ × {{ $item->quantity }}
                                    </div>
                                </div>
                                <div class="font-bold ml-4">
                                    {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}₫
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Totals -->
                    <div class="space-y-4 pb-6 border-b-2 border-swiss-gray-300 mb-6">
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
                    
                    <div class="flex justify-between mb-8">
                        <span class="text-2xl font-bold">TỔNG CỘNG:</span>
                        <span class="text-3xl font-bold text-swiss-red">
                            {{ number_format($total, 0, ',', '.') }}₫
                        </span>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full h-14 mb-4">
                        ĐẶT HÀNG
                    </button>
                    
                    <a href="{{ route('cart.index') }}" class="btn-secondary w-full text-center inline-block">
                        QUAY LẠI GIỎ HÀNG
                    </a>
                </div>
            </div>
        </div>
    </form>

</section>

@endsection
