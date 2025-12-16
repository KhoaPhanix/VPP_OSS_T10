<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Báo cáo doanh thu
     */
    public function revenue(Request $request)
    {
        $period = $request->get('period', 'week');

        switch ($period) {
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'quarter':
                $startDate = now()->startOfQuarter();
                $endDate = now()->endOfQuarter();
                break;
            default:
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
        }

        $totalRevenue = Order::where('status', 'completed')
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalOrders = Order::where('status', 'completed')
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->count();

        // Daily breakdown
        $dailyRevenue = Order::where('status', 'completed')
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(completed_at) as date'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy('date')
            ->get();

        return view('admin.reports.revenue', compact('totalRevenue', 'totalOrders', 'dailyRevenue', 'period'));
    }

    /**
     * Phân tích hành vi mua hàng
     */
    public function behavior()
    {
        // Thời gian cao điểm theo giờ
        $peakHours = Order::select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as total'))
            ->groupBy('hour')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.reports.behavior', compact('peakHours'));
    }

    /**
     * Top sản phẩm bán chạy
     */
    public function topProducts()
    {
        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'products.id',
                'products.name',
                'products.price',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.top-products', compact('topProducts'));
    }
}
