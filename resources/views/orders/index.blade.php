@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="swiss-container py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold tracking-tight">ĐƠN HÀNG CỦA TÔI</h1>
        <p class="text-swiss-gray-600">Theo dõi trạng thái đơn hàng</p>
    </div>

    @if($orders->isEmpty())
        <div class="border-2 border-swiss-black p-12 text-center">
            <div class="text-6xl mb-4">📦</div>
            <h2 class="text-2xl font-bold mb-2">Chưa có đơn hàng nào</h2>
            <p class="text-swiss-gray-600 mb-6">Bạn chưa có đơn hàng nào. Hãy mua sắm ngay!</p>
            <a href="{{ route('products.index') }}" class="btn-primary">
                XEM SẢN PHẨM
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="border-2 border-swiss-black hover:border-swiss-red transition-colors">
                    <div class="p-4 border-b-2 border-swiss-gray-200 flex justify-between items-center">
                        <div>
                            <span class="font-bold font-mono">{{ $order->order_number }}</span>
                            <span class="text-swiss-gray-600 ml-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($order->status === 'pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 font-medium text-sm">Chờ duyệt</span>
                        @elseif($order->status === 'approved')
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 font-medium text-sm">Đã duyệt</span>
                        @elseif($order->status === 'completed')
                            <span class="px-3 py-1 bg-green-100 text-green-800 font-medium text-sm">Hoàn thành</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-800 font-medium text-sm">Từ chối</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($order->orderDetails->take(3) as $detail)
                                <div class="flex items-center gap-2 bg-swiss-gray-50 px-3 py-1">
                                    <span class="font-medium">{{ Str::limit($detail->product->name, 20) }}</span>
                                    <span class="text-swiss-gray-600">x{{ $detail->quantity }}</span>
                                </div>
                            @endforeach
                            @if($order->orderDetails->count() > 3)
                                <div class="bg-swiss-gray-50 px-3 py-1 text-swiss-gray-600">
                                    +{{ $order->orderDetails->count() - 3 }} sản phẩm khác
                                </div>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-swiss-red">
                                {{ number_format($order->total_amount, 0, ',', '.') }}₫
                            </span>
                            <a href="{{ route('orders.show', $order) }}" class="btn-ghost">
                                XEM CHI TIẾT →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
