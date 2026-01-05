@extends('layouts.app')

@section('title', 'Phân tích hành vi mua hàng')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Phân tích hành vi mua hàng</h1>
        <p class="text-gray-600">Thống kê thời gian khách hàng đặt hàng nhiều nhất trong ngày</p>
    </div>

    <!-- Peak Hours Chart -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Thời gian cao điểm (theo giờ)</h2>
        
        @if($peakHours->count() > 0)
            <div class="space-y-3">
                @php
                    $maxTotal = $peakHours->max('total');
                    $sortedHours = $peakHours->sortBy('hour');
                @endphp
                @foreach($sortedHours as $item)
                    <div class="flex items-center">
                        <div class="w-16 text-sm font-medium text-gray-700">
                            {{ str_pad($item->hour, 2, '0', STR_PAD_LEFT) }}:00
                        </div>
                        <div class="flex-1 mx-4">
                            <div class="bg-gray-200 rounded-full h-6 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded-full flex items-center justify-end pr-2 transition-all duration-300" 
                                     style="width: {{ $maxTotal > 0 ? ($item->total / $maxTotal * 100) : 0 }}%">
                                    @if(($item->total / $maxTotal * 100) > 15)
                                        <span class="text-xs text-white font-medium">{{ $item->total }} đơn</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="w-20 text-sm text-gray-600 text-right">
                            {{ $item->total }} đơn
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <p class="text-gray-500">Chưa có dữ liệu đơn hàng</p>
            </div>
        @endif
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @if($peakHours->count() > 0)
            @php
                $topHour = $peakHours->first();
                $totalOrders = $peakHours->sum('total');
                $avgOrders = $peakHours->avg('total');
            @endphp
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Giờ cao điểm</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ str_pad($topHour->hour, 2, '0', STR_PAD_LEFT) }}:00</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Tổng đơn hàng</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">TB đơn/giờ</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($avgOrders, 1) }}</p>
                    </div>
                </div>
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
