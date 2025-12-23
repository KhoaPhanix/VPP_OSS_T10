@extends('layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="swiss-container py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold tracking-tight">QUẢN LÝ ĐƠN HÀNG</h1>
            <p class="text-swiss-gray-600">Danh sách tất cả đơn hàng</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="mb-6 flex gap-2">
        <a href="{{ route('admin.orders.index') }}" 
           class="px-4 py-2 {{ !request('status') ? 'bg-swiss-black text-white' : 'border-2 border-swiss-black' }}">
            Tất cả
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'border-2 border-swiss-black' }}">
            Chờ duyệt
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'approved']) }}" 
           class="px-4 py-2 {{ request('status') === 'approved' ? 'bg-blue-500 text-white' : 'border-2 border-swiss-black' }}">
            Đã duyệt
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" 
           class="px-4 py-2 {{ request('status') === 'completed' ? 'bg-green-500 text-white' : 'border-2 border-swiss-black' }}">
            Hoàn thành
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'rejected']) }}" 
           class="px-4 py-2 {{ request('status') === 'rejected' ? 'bg-red-500 text-white' : 'border-2 border-swiss-black' }}">
            Từ chối
        </a>
    </div>

    <!-- Orders Table -->
    <div class="border-2 border-swiss-black">
        <table class="w-full">
            <thead class="bg-swiss-gray-50 border-b-2 border-swiss-black">
                <tr>
                    <th class="px-4 py-3 text-left font-bold">MÃ ĐƠN</th>
                    <th class="px-4 py-3 text-left font-bold">KHÁCH HÀNG</th>
                    <th class="px-4 py-3 text-right font-bold">TỔNG TIỀN</th>
                    <th class="px-4 py-3 text-center font-bold">TRẠNG THÁI</th>
                    <th class="px-4 py-3 text-center font-bold">NGÀY TẠO</th>
                    <th class="px-4 py-3 text-center font-bold">THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-swiss-gray-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-swiss-gray-50">
                        <td class="px-4 py-4 font-mono font-bold">{{ $order->order_number }}</td>
                        <td class="px-4 py-4">
                            <div class="font-medium">{{ $order->user->full_name }}</div>
                            <div class="text-sm text-swiss-gray-600">{{ $order->user->phone }}</div>
                        </td>
                        <td class="px-4 py-4 text-right font-bold text-swiss-red">
                            {{ number_format($order->total_amount, 0, ',', '.') }}₫
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($order->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium">Chờ duyệt</span>
                            @elseif($order->status === 'approved')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium">Đã duyệt</span>
                            @elseif($order->status === 'completed')
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium">Hoàn thành</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium">Từ chối</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center text-sm">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="inline-block px-3 py-1 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-colors">
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-swiss-gray-500">
                            Không có đơn hàng nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
