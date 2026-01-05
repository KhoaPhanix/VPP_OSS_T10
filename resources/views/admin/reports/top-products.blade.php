@extends('layouts.app')

@section('title', 'Top sản phẩm bán chạy')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Top sản phẩm bán chạy</h1>
        <p class="text-gray-600">Thống kê 10 sản phẩm bán chạy nhất trong tuần này</p>
    </div>

    <!-- Top Products Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($topProducts->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sản phẩm
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Giá bán
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Số lượng bán
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Doanh thu
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tỷ lệ
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $maxSold = $topProducts->max('total_sold');
                    @endphp
                    @foreach($topProducts as $index => $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($index < 3)
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                        {{ $index == 0 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $index == 1 ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $index == 2 ? 'bg-orange-100 text-orange-800' : '' }}
                                        font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                @else
                                    <span class="text-gray-500 font-medium">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($product->price) }}₫
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $product->total_sold }} sản phẩm
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ number_format($product->total_revenue) }}₫
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2.5 w-24 overflow-hidden">
                                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-full rounded-full" 
                                             style="width: {{ $maxSold > 0 ? ($product->total_sold / $maxSold * 100) : 0 }}%">
                                        </div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500">
                                        {{ $maxSold > 0 ? round($product->total_sold / $maxSold * 100) : 0 }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">
                        Tổng số sản phẩm đã bán: <strong>{{ $topProducts->sum('total_sold') }}</strong>
                    </span>
                    <span class="text-sm text-gray-600">
                        Tổng doanh thu: <strong class="text-green-600">{{ number_format($topProducts->sum('total_revenue')) }}₫</strong>
                    </span>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <p class="text-gray-500 mb-2">Chưa có dữ liệu bán hàng trong tuần này</p>
                <p class="text-sm text-gray-400">Các đơn hàng sẽ được thống kê tại đây</p>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <div class="mt-8">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="mr-2 -ml-1 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Quay lại Dashboard
        </a>
    </div>
</div>
@endsection
