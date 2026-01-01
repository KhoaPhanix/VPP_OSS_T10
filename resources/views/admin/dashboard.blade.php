@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-1">Tổng quan hệ thống</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Products -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($totalProducts) }}</div>
            <div class="text-sm text-gray-600">Sản phẩm</div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($totalOrders) }}</div>
            <div class="text-sm text-gray-600">Đơn hàng</div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-yellow-700 mb-1">{{ number_format($pendingOrders) }}</div>
            <div class="text-sm text-yellow-700">Chờ duyệt</div>
        </div>

        <!-- Customers -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($totalCustomers) }}</div>
            <div class="text-sm text-gray-600">Khách hàng</div>
        </div>
    </div>

    <!-- Revenue Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="text-sm text-red-100 mb-1">Doanh thu tuần</div>
                    <div class="text-3xl font-bold">{{ number_format($weeklyRevenue, 0, ',', '.') }}₫</div>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="text-sm text-blue-100 mb-1">Doanh thu tháng</div>
                    <div class="text-3xl font-bold">{{ number_format($monthlyRevenue, 0, ',', '.') }}₫</div>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Products -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-gray-900">TOP SẢN PHẨM BÁN CHẠY (TUẦN)</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($topProducts as $index => $product)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <span class="w-8 h-8 bg-red-600 text-white rounded-lg flex items-center justify-center mr-4 font-bold text-sm">
                                {{ $index + 1 }}
                            </span>
                            <span class="font-medium text-gray-900">{{ $product->name }}</span>
                        </div>
                        <span class="text-red-600 font-bold">{{ $product->total_sold }}</span>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        Chưa có dữ liệu bán hàng trong tuần này.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-gray-900">ĐƠN HÀNG GẦN NHẤT</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-bold text-gray-900">{{ $order->order_number }}</div>
                                <div class="text-sm text-gray-600">{{ $order->user->full_name }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-red-600">{{ number_format($order->total_amount, 0, ',', '.') }}₫</div>
                                <div class="text-xs mt-1">
                                    @if($order->status === 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Chờ duyệt</span>
                                    @elseif($order->status === 'approved')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Đã duyệt</span>
                                    @elseif($order->status === 'completed')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Hoàn thành</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Từ chối</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        Chưa có đơn hàng nào.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.products.index') }}" class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Quản lý</div>
                    <div class="font-bold text-gray-900">Sản phẩm</div>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
        
        <a href="{{ route('admin.categories.index') }}" class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Quản lý</div>
                    <div class="font-bold text-gray-900">Danh mục</div>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
        
        <a href="{{ route('admin.orders.index') }}" class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Quản lý</div>
                    <div class="font-bold text-gray-900">Đơn hàng</div>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
        
        <a href="{{ route('admin.reports.revenue') }}" class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Xem</div>
                    <div class="font-bold text-gray-900">Báo cáo</div>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
    </div>
</div>
@endsection
