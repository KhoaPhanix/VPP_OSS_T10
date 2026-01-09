@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="swiss-container py-8">
    <div class="mb-8">
        <a href="{{ route('orders.index') }}" class="text-swiss-gray-600 hover:text-swiss-black">
            ← Quay lại đơn hàng
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="border-2 border-swiss-black">
                <div class="p-4 border-b-2 border-swiss-black bg-swiss-gray-50 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">{{ $order->order_number }}</h1>
                        <p class="text-swiss-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($order->status === 'pending')
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 font-bold">CHỜ DUYỆT</span>
                    @elseif($order->status === 'approved')
                        <span class="px-4 py-2 bg-blue-100 text-blue-800 font-bold">ĐÃ DUYỆT</span>
                    @elseif($order->status === 'completed')
                        <span class="px-4 py-2 bg-green-100 text-green-800 font-bold">HOÀN THÀNH</span>
                    @else
                        <span class="px-4 py-2 bg-red-100 text-red-800 font-bold">TỪ CHỐI</span>
                    @endif
                </div>

                <div class="divide-y divide-swiss-gray-200">
                    @foreach($order->orderDetails as $detail)
                        <div class="p-4 flex items-center gap-4">
                            @if($detail->product->image)
                                <img src="{{ asset('storage/' . $detail->product->image) }}" 
                                     alt="{{ $detail->product->name }}"
                                     class="w-16 h-16 object-cover border-2 border-swiss-gray-200">
                            @else
                                <div class="w-16 h-16 bg-swiss-gray-100 flex items-center justify-center border-2 border-swiss-gray-200">
                                    <span class="text-swiss-gray-400">📦</span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="font-bold">{{ $detail->product->name }}</div>
                                <div class="text-sm text-swiss-gray-600">
                                    {{ number_format($detail->price, 0, ',', '.') }}₫ x {{ $detail->quantity }}
                                </div>
                            </div>
                            <div class="font-bold text-swiss-red">
                                {{ number_format($detail->subtotal, 0, ',', '.') }}₫
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 border-t-2 border-swiss-black bg-swiss-gray-50 flex justify-between items-center">
                    <span class="font-bold">TỔNG CỘNG</span>
                    <span class="text-2xl font-bold text-swiss-red">
                        {{ number_format($order->total_amount, 0, ',', '.') }}₫
                    </span>
                </div>
            </div>

            @if($order->isRejected() && $order->reject_reason)
                <div class="mt-6 border-2 border-red-500 bg-red-50 p-4">
                    <div class="font-bold text-red-600 mb-2">Lý do từ chối:</div>
                    <p>{{ $order->reject_reason }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Shipping Info -->
            <div class="border-2 border-swiss-black">
                <div class="p-4 border-b-2 border-swiss-black bg-swiss-gray-50">
                    <h3 class="font-bold">THÔNG TIN GIAO HÀNG</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <div class="text-sm text-swiss-gray-600">Số điện thoại</div>
                        <div class="font-medium">{{ $order->phone }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-swiss-gray-600">Địa chỉ</div>
                        <div class="font-medium">{{ $order->shipping_address }}</div>
                    </div>
                    @if($order->notes)
                        <div>
                            <div class="text-sm text-swiss-gray-600">Ghi chú</div>
                            <div class="font-medium">{{ $order->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="border-2 border-swiss-black">
                <div class="p-4 border-b-2 border-swiss-black bg-swiss-gray-50">
                    <h3 class="font-bold">TRẠNG THÁI ĐƠN HÀNG</h3>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-4 h-4 bg-swiss-black rounded-full mt-0.5 mr-3 flex-shrink-0"></div>
                            <div>
                                <div class="font-medium">Đặt hàng thành công</div>
                                <div class="text-sm text-swiss-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        
                        @if($order->approved_at)
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-blue-500 rounded-full mt-0.5 mr-3 flex-shrink-0"></div>
                                <div>
                                    <div class="font-medium">Đã được duyệt</div>
                                    <div class="text-sm text-swiss-gray-600">{{ $order->approved_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($order->completed_at)
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-green-500 rounded-full mt-0.5 mr-3 flex-shrink-0"></div>
                                <div>
                                    <div class="font-medium">Hoàn thành</div>
                                    <div class="text-sm text-swiss-gray-600">{{ $order->completed_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($order->rejected_at)
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-red-500 rounded-full mt-0.5 mr-3 flex-shrink-0"></div>
                                <div>
                                    <div class="font-medium">Đã bị từ chối</div>
                                    <div class="text-sm text-swiss-gray-600">{{ $order->rejected_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        @endif

                        @if($order->isPending())
                            <div class="flex items-start opacity-50">
                                <div class="w-4 h-4 border-2 border-swiss-gray-400 rounded-full mt-0.5 mr-3 flex-shrink-0"></div>
                                <div>
                                    <div class="font-medium">Chờ Admin duyệt</div>
                                    <div class="text-sm text-swiss-gray-600">Đang xử lý...</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($order->isCompleted())
                <div class="border-2 border-swiss-black">
                    <div class="p-4 border-b-2 border-swiss-black bg-swiss-gray-50">
                        <h3 class="font-bold">MUA LẠI ĐƠN HÀNG</h3>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('orders.reorder', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                MUA LẠI ĐƠN HÀNG NÀY
                            </button>
                        </form>
                        <p class="text-xs text-swiss-gray-600 mt-2 text-center">Các sản phẩm sẽ được thêm vào giỏ hàng của bạn</p>
                    </div>
                </div>
            @endif

            @if($order->isPending())
                <div class="border-2 border-swiss-black">
                    <div class="p-4">
                        <button 
                            onclick="showCancelModal()" 
                            class="btn-ghost w-full border-2 border-red-500 text-red-600 hover:bg-red-50">
                            ❌ YÊU CẦU HỦY ĐƠN
                        </button>
                    </div>
                </div>
            @endif

            <!-- Contact -->
            <div class="border-2 border-swiss-black p-4">
                <p class="text-sm text-swiss-gray-600 mb-2">Có thắc mắc về đơn hàng?</p>
                <a href="{{ route('chat.index') }}" class="btn-ghost w-full text-center">
                    LIÊN HỆ HỖ TRỢ
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal hủy đơn -->
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white border-4 border-swiss-black max-w-md w-full">
        <div class="p-6 border-b-2 border-swiss-black bg-swiss-gray-50">
            <h3 class="text-xl font-bold">YÊU CẦU HỦY ĐƠN HÀNG</h3>
        </div>
        <div class="p-6">
            <div class="text-center mb-6">
                <div class="text-6xl mb-4">📞</div>
                <p class="text-lg mb-2">Để hủy đơn hàng, vui lòng liên hệ:</p>
                <a href="tel:0383277120" class="text-3xl font-bold text-swiss-red hover:underline">
                    0383277120
                </a>
                <p class="text-sm text-swiss-gray-600 mt-4">
                    Chúng tôi sẽ xác nhận và xử lý yêu cầu hủy đơn của bạn trong thời gian sớm nhất.
                </p>
            </div>
            <div class="space-y-3">
                <a href="tel:0383277120" class="btn-primary w-full text-center">
                    GỌI NGAY
                </a>
                <button onclick="closeCancelModal()" class="btn-ghost w-full">
                    ĐÓNG
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showCancelModal() {
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
}

// Đóng modal khi click bên ngoài
document.getElementById('cancelModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancelModal();
    }
});
</script>
@endsection
