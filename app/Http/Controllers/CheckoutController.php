<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Hiển thị trang thanh toán
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Xử lý đặt hàng
     */
    public function process(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string',
            'payment_method' => 'required|in:cod,transfer',
            'notes' => 'nullable|string',
        ], [
            'full_name.required' => 'Vui lòng nhập họ và tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'email.required' => 'Vui lòng nhập email',
            'address.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if (!$item->product->hasStock($item->quantity)) {
                return back()->with('error', "Sản phẩm {$item->product->name} không đủ hàng trong kho!");
            }
        }

        DB::beginTransaction();
        try {
            // Calculate total
            $totalAmount = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'shipping_address' => $request->address,
                'phone' => $request->phone,
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
            ]);

            // Create order details and update stock
            foreach ($cartItems as $item) {
                // Create order detail
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);

                // Get current stock before update
                $stockBefore = $item->product->stock_quantity;
                
                // Reduce stock
                $item->product->decrement('stock_quantity', $item->quantity);
                
                $stockAfter = $stockBefore - $item->quantity;

                // Record stock movement
                StockMovement::create([
                    'product_id' => $item->product_id,
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'quantity_before' => $stockBefore,
                    'quantity_after' => $stockAfter,
                    'reference_type' => 'order',
                    'reference_id' => $order->id,
                    'notes' => "Đơn hàng #{$order->order_number}",
                    'created_by' => Auth::id(),
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout error: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            return back()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Trang đặt hàng thành công
     */
    public function success($orderId)
    {
        $order = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        return view('checkout.success', compact('order'));
    }
}
