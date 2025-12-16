<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Danh sách đơn hàng
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'orderDetails');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Order::with('user', 'orderDetails.product', 'approvedBy')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Duyệt đơn hàng
     */
    public function approve($id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);

        if (!$order->isPending()) {
            return back()->with('error', 'Chỉ có thể duyệt đơn hàng đang chờ duyệt!');
        }

        // Check stock availability
        foreach ($order->orderDetails as $detail) {
            if (!$detail->product->hasStock($detail->quantity)) {
                return back()->with('error', "Sản phẩm {$detail->product->name} không đủ hàng!");
            }
        }

        DB::beginTransaction();
        try {
            // Update order status
            $order->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

            // Deduct stock and log movements
            foreach ($order->orderDetails as $detail) {
                $product = $detail->product;
                $oldStock = $product->stock_quantity;

                $product->decrement('stock_quantity', $detail->quantity);

                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $detail->quantity,
                    'quantity_before' => $oldStock,
                    'quantity_after' => $oldStock - $detail->quantity,
                    'notes' => "Đơn hàng #{$order->order_number}",
                    'created_by' => Auth::id(),
                ]);
            }

            DB::commit();

            return back()->with('success', 'Đơn hàng đã được duyệt!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Từ chối đơn hàng
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string',
        ]);

        $order = Order::findOrFail($id);

        if (!$order->isPending()) {
            return back()->with('error', 'Chỉ có thể từ chối đơn hàng đang chờ duyệt!');
        }

        $order->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'reject_reason' => $request->reject_reason,
        ]);

        return back()->with('success', 'Đơn hàng đã bị từ chối!');
    }
}
