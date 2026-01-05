@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')

<section class="swiss-container py-16">
    
    <div class="max-w-2xl mx-auto text-center">
        
        <!-- Success Icon -->
        <div class="mb-8">
            <div class="w-24 h-24 bg-green-100 rounded-full mx-auto flex items-center justify-center">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Message -->
        <h1 class="text-3xl font-bold mb-4 text-green-600">ĐẶT HÀNG THÀNH CÔNG!</h1>
        <p class="text-lg text-gray-600 mb-8">
            Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.
        </p>

        <!-- Order Info -->
        <div class="border-2 border-swiss-black p-8 mb-8 text-left">
            <h2 class="font-bold text-xl mb-6 text-center">THÔNG TIN ĐƠN HÀNG</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Mã đơn hàng:</span>
                    <span class="font-bold">{{ $order->order_number }}</span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Ngày đặt:</span>
                    <span class="font-bold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Trạng thái:</span>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                        Chờ xác nhận
                    </span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Phương thức thanh toán:</span>
                    <span class="font-bold">
                        @if($order->payment_method == 'cod')
                            Thanh toán khi nhận hàng
                        @else
                            Chuyển khoản ngân hàng
                        @endif
                    </span>
                </div>
                
                <div class="py-2 border-b border-gray-200">
                    <span class="text-gray-600">Địa chỉ giao hàng:</span>
                    <p class="font-bold mt-1">{{ $order->shipping_address }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mt-6 pt-6 border-t-2 border-gray-200">
                <h3 class="font-bold mb-4">SẢN PHẨM ĐÃ ĐẶT</h3>
                <div class="space-y-3">
                    @foreach($order->orderDetails as $detail)
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-medium">{{ $detail->product->name }}</span>
                                <span class="text-gray-500 ml-2">x{{ $detail->quantity }}</span>
                            </div>
                            <span class="font-bold">{{ number_format($detail->subtotal, 0, ',', '.') }}₫</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Total -->
            <div class="mt-6 pt-6 border-t-2 border-swiss-black flex justify-between items-center">
                <span class="text-xl font-bold">TỔNG CỘNG:</span>
                <span class="text-2xl font-bold text-swiss-red">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
            </div>
        </div>

        @if($order->payment_method == 'transfer')
            <!-- Bank Transfer Info -->
            <div class="border-2 border-blue-500 bg-blue-50 p-6 mb-8 text-left">
                <h3 class="font-bold text-lg mb-4 text-blue-800">THÔNG TIN CHUYỂN KHOẢN</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-600">Ngân hàng:</span> <strong>Vietcombank</strong></p>
                    <p><span class="text-gray-600">Số tài khoản:</span> <strong>1234567890</strong></p>
                    <p><span class="text-gray-600">Chủ tài khoản:</span> <strong>CÔNG TY VĂN PHÒNG PHẨM VPP</strong></p>
                    <p><span class="text-gray-600">Nội dung CK:</span> <strong>{{ $order->order_number }}</strong></p>
                </div>
                <p class="mt-4 text-sm text-blue-700">
                    Vui lòng chuyển khoản trong vòng 24h để đơn hàng được xử lý.
                </p>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('orders.show', $order->id) }}" class="btn-primary">
                XEM CHI TIẾT ĐƠN HÀNG
            </a>
            <a href="{{ route('products.index') }}" class="btn-secondary">
                TIẾP TỤC MUA SẮM
            </a>
        </div>

    </div>

</section>

@endsection
