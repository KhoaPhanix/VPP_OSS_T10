@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="swiss-container py-8">
    <div class="mb-8">
        <a href="{{ route('admin.orders.index') }}" class="text-swiss-gray-600 hover:text-swiss-black">
            ← Quay lại danh sách
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="border-2 border-swiss-black mb-6">
                <div class="p-4 border-b-2 border-swiss-black bg-swiss-gray-50 flex justify-between items-center">
                    <h2 class="font-bold tracking-wide">ĐƠN HÀNG #{{ $order->order_number }}</h2>
                    @if($order->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 font-medium">Chờ duyệt</span>
                    @elseif($order->status === 'approved')
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 font-medium">Đã duyệt</span>
                    @elseif($order->status === 'completed')
                        <span class="px-3 py-1 bg-green-100 text-green-800 font-medium">Hoàn thành</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 font-medium">Từ chối</span>
                    @endif
                </div>
                
                <table class="w-full">
                    <thead class="border-b-2 border-swiss-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">SẢN PHẨM</th>
                            <th class="px-4 py-3 text-right">ĐƠN GIÁ</th>
                            <th class="px-4 py-3 text-center">SỐ LƯỢNG</th>
                            <th class="px-4 py-3 text-right">THÀNH TIỀN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-swiss-gray-200">
                        @foreach($order->orderDetails as $detail)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="font-medium">{{ $detail->product->name }}</div>
                                    <div class="text-sm text-swiss-gray-600">{{ $detail->product->code }}</div>
                                </td>
                                <td class="px-4 py-4 text-right">{{ number_format($detail->price, 0, ',', '.') }}₫</td>
                                <td class="px-4 py-4 text-center">{{ $detail->quantity }}</td>
                                <td class="px-4 py-4 text-right font-bold">{{ number_format($detail->subtotal, 0, ',', '.') }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-swiss-black bg-swiss-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-right font-bold">TỔNG CỘNG:</td>
                            <td class="px-4 py-4 text-right text-xl font-bold text-swiss-red">
                                {{ number_format($order->total_amount, 0, ',', '.') }}₫
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Actions -->
            @if($order->isPending())
                <div class="flex gap-4">
                    <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="btn-primary w-full py-4">
                            ✓ DUYỆT ĐƠN HÀNG
                        </button>
                    </form>
                    
                    <div x-data="{ showReject: false }" class="flex-1">
                        <button @click="showReject = true" class="btn-ghost w-full py-4 border-red-500 text-red-500 hover:bg-red-500 hover:text-white">
                            ✗ TỪ CHỐI
                        </button>
                        
                        <div x-show="showReject" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                            <div class="bg-white border-2 border-swiss-black p-6 w-full max-w-md" @click.away="showReject = false">
                                <h3 class="font-bold text-xl mb-4">Lý do từ chối</h3>
                                <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                                    @csrf
                                    <textarea name="reject_reason" rows="3" required
                                        class="w-full border-2 border-swiss-black p-3 mb-4"
                                        placeholder="Nhập lý do từ chối đơn hàng..."></textarea>
                                    <div class="flex gap-2">
                                        <button type="button" @click="showReject = false" class="btn-ghost flex-1">Hủy</button>
                                        <button type="submit" class="btn-primary flex-1 bg-red-500 border-red-500">Từ chối</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($order->isApproved())
                <form action="{{ route('admin.orders.complete', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary w-full py-4 bg-green-600 border-green-600">
                        ✓ HOÀN THÀNH ĐƠN HÀNG
                    </button>
                </form>
            @endif

            @if($order->isRejected() && $order->reject_reason)
                <div class="border-2 border-red-500 bg-red-50 p-4 mt-4">
                    <div class="font-bold text-red-600 mb-2">Lý do từ chối:</div>
                    <p>{{ $order->reject_reason }}</p>
                </div>
            @endif
        </div>

        <!-- Customer Info -->
        <div class="lg:col-span-1">
            <div class="border-2 border-swiss-black mb-6">
                <div class="p-4 border-b-2 border-swiss-black bg-swiss-gray-50">
                    <h3 class="font-bold tracking-wide">THÔNG TIN KHÁCH HÀNG</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <div class="text-sm text-swiss-gray-600">Họ tên</div>
                        <div class="font-medium">{{ $order->user->full_name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-swiss-gray-600">Email</div>
                        <div class="font-medium">{{ $order->user->email }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-swiss-gray-600">Số điện thoại</div>
                        <div class="font-medium">{{ $order->phone }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-swiss-gray-600">Địa chỉ giao hàng</div>
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

            <div class="border-2 border-swiss-black">
                <div class="p-4 border-b-2 border-swiss-black bg-swiss-gray-50">
                    <h3 class="font-bold tracking-wide">TIMELINE</h3>
                </div>
                <div class="p-4 space-y-4">
                    <div class="flex items-start">
                        <div class="w-3 h-3 bg-swiss-black rounded-full mt-1 mr-3"></div>
                        <div>
                            <div class="font-medium">Đặt hàng</div>
                            <div class="text-sm text-swiss-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    @if($order->approved_at)
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mt-1 mr-3"></div>
                            <div>
                                <div class="font-medium">Đã duyệt</div>
                                <div class="text-sm text-swiss-gray-600">{{ $order->approved_at->format('d/m/Y H:i') }}</div>
                                @if($order->approvedBy)
                                    <div class="text-sm text-swiss-gray-600">bởi {{ $order->approvedBy->full_name }}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if($order->completed_at)
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-green-500 rounded-full mt-1 mr-3"></div>
                            <div>
                                <div class="font-medium">Hoàn thành</div>
                                <div class="text-sm text-swiss-gray-600">{{ $order->completed_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    @endif
                    @if($order->rejected_at)
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-red-500 rounded-full mt-1 mr-3"></div>
                            <div>
                                <div class="font-medium">Từ chối</div>
                                <div class="text-sm text-swiss-gray-600">{{ $order->rejected_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
