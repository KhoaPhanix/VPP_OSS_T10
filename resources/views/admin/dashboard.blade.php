@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="swiss-container py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold tracking-tight">DASHBOARD</h1>
        <p class="text-swiss-gray-600">Tổng quan hệ thống</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Products -->
        <div class="border-2 border-swiss-black p-6">
            <div class="text-3xl font-bold text-swiss-red mb-2">{{ number_format($totalProducts) }}</div>
            <div class="text-sm tracking-widest text-swiss-gray-600">SẢN PHẨM</div>
        </div>

        <!-- Total Orders -->
        <div class="border-2 border-swiss-black p-6">
            <div class="text-3xl font-bold text-swiss-blue mb-2">{{ number_format($totalOrders) }}</div>
            <div class="text-sm tracking-widest text-swiss-gray-600">ĐƠN HÀNG</div>
        </div>

        <!-- Pending Orders -->
        <div class="border-2 border-swiss-black p-6 bg-yellow-50">
            <div class="text-3xl font-bold text-yellow-600 mb-2">{{ number_format($pendingOrders) }}</div>
            <div class="text-sm tracking-widest text-swiss-gray-600">CHỜ DUYỆT</div>
        </div>

        <!-- Customers -->
        <div class="border-2 border-swiss-black p-6">
            <div class="text-3xl font-bold mb-2">{{ number_format($totalCustomers) }}</div>
            <div class="text-sm tracking-widest text-swiss-gray-600">KHÁCH HÀNG</div>
        </div>
    </div>

    <!-- Revenue Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="border-2 border-swiss-black p-6">
            <div class="text-sm tracking-widest text-swiss-gray-600 mb-2">DOANH THU TUẦN</div>
            <div class="text-3xl font-bold text-swiss-red">{{ number_format($weeklyRevenue, 0, ',', '.') }}₫</div>
        </div>
        <div class="border-2 border-swiss-black p-6">
            <div class="text-sm tracking-widest text-swiss-gray-600 mb-2">DOANH THU THÁNG</div>
            <div class="text-3xl font-bold text-swiss-blue">{{ number_format($monthlyRevenue, 0, ',', '.') }}₫</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Products -->
        <div class="border-2 border-swiss-black">
            <div class="p-4 border-b-2 border-swiss-black bg-swiss-gray-50">
                <h2 class="font-bold tracking-wide">TOP SẢN PHẨM BÁN CHẠY (TUẦN)</h2>
            </div>
            <div class="divide-y-2 divide-swiss-gray-200">
                @forelse($topProducts as $index => $product)
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-8 h-8 bg-swiss-black text-white flex items-center justify-center mr-4 font-bold">
                                {{ $index + 1 }}
                            </span>
                            <span class="font-medium">{{ $product->name }}</span>
                        </div>
                        <span class="text-swiss-red font-bold">{{ $product->total_sold }} đã bán</span>
                    </div>
                @empty
                    <div class="p-8 text-center text-swiss-gray-500">
                        Chưa có dữ liệu bán hàng trong tuần này.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="border-2 border-swiss-black">
            <div class="p-4 border-b-2 border-swiss-black bg-swiss-gray-50">
                <h2 class="font-bold tracking-wide">ĐƠN HÀNG GẦN NHẤT</h2>
            </div>
            <div class="divide-y-2 divide-swiss-gray-200">
                @forelse($recentOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="block p-4 hover:bg-swiss-gray-50 transition-colors">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-bold">{{ $order->order_number }}</div>
                                <div class="text-sm text-swiss-gray-600">{{ $order->user->full_name }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-swiss-red">{{ number_format($order->total_amount, 0, ',', '.') }}₫</div>
                                <div class="text-xs">
                                    @if($order->status === 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800">Chờ duyệt</span>
                                    @elseif($order->status === 'approved')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800">Đã duyệt</span>
                                    @elseif($order->status === 'completed')
                                        <span class="px-2 py-1 bg-green-100 text-green-800">Hoàn thành</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800">Từ chối</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-swiss-gray-500">
                        Chưa có đơn hàng nào.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.products.index') }}" class="btn-primary text-center py-4">
            QUẢN LÝ SẢN PHẨM
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn-primary text-center py-4">
            QUẢN LÝ DANH MỤC
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn-primary text-center py-4">
            QUẢN LÝ ĐƠN HÀNG
        </a>
        <a href="{{ route('admin.reports.revenue') }}" class="btn-ghost text-center py-4">
            BÁO CÁO
        </a>
    </div>
</div>
@endsection
