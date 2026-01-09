<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Danh sách đơn hàng của user
     */
    public function index()
    {
        $orders = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Order::with('orderDetails.product', 'approvedBy')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Tạo đơn hàng từ giỏ hàng
     */
    public function create(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Giỏ hàng trống!');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if (!$item->product->hasStock($item->quantity)) {
                return back()->with('error', "Sản phẩm {$item->product->name} không đủ hàng!");
            }
        }

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . time() . '-' . Auth::id(),
                'user_id' => Auth::id(),
                'total_amount' => $cartItems->sum(fn($item) => $item->quantity * $item->product->price),
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'notes' => $request->notes,
            ]);

            // Create order details
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Đơn hàng đã được tạo thành công! Vui lòng chờ Admin duyệt.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Mua lại đơn hàng (thêm sản phẩm vào giỏ và chuyển đến checkout)
     */
    public function reorder($id)
    {
        $order = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // Chỉ cho phép mua lại đơn hàng đã hoàn thành
        if (!$order->isCompleted()) {
            return back()->with('error', 'Chỉ có thể mua lại đơn hàng đã hoàn thành!');
        }

        DB::beginTransaction();
        try {
            // Xóa giỏ hàng hiện tại
            Cart::where('user_id', Auth::id())->delete();

            $addedProducts = [];
            $outOfStockProducts = [];
            $adjustedProducts = [];
            $unavailableProducts = [];

            // Thêm sản phẩm từ đơn hàng vào giỏ
            foreach ($order->orderDetails as $detail) {
                // Kiểm tra sản phẩm còn tồn tại
                if (!$detail->product) {
                    $unavailableProducts[] = 'Sản phẩm #' . $detail->product_id;
                    continue;
                }

                $productName = $detail->product->name;

                // Kiểm tra còn đủ hàng
                if ($detail->product->stock >= $detail->quantity) {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $detail->product_id,
                        'quantity' => $detail->quantity,
                    ]);
                    $addedProducts[] = $productName;
                } elseif ($detail->product->stock > 0) {
                    // Thêm với số lượng tối đa có thể
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $detail->product_id,
                        'quantity' => $detail->product->stock,
                    ]);
                    $adjustedProducts[] = "{$productName} (chỉ còn {$detail->product->stock} sản phẩm)";
                } else {
                    $outOfStockProducts[] = $productName;
                }
            }

            DB::commit();

            // Tạo thông báo chi tiết
            $messages = [];
            
            if (count($addedProducts) > 0) {
                $messages[] = 'Đã thêm ' . count($addedProducts) . ' sản phẩm vào giỏ hàng.';
            }
            
            if (count($adjustedProducts) > 0) {
                $messages[] = 'Một số sản phẩm đã được điều chỉnh số lượng: ' . implode(', ', $adjustedProducts) . '.';
            }
            
            if (count($outOfStockProducts) > 0) {
                $messages[] = 'Các sản phẩm hết hàng: ' . implode(', ', $outOfStockProducts) . '.';
            }
            
            if (count($unavailableProducts) > 0) {
                $messages[] = 'Các sản phẩm không còn tồn tại: ' . implode(', ', $unavailableProducts) . '.';
            }

            // Kiểm tra nếu không có sản phẩm nào được thêm
            if (count($addedProducts) == 0 && count($adjustedProducts) == 0) {
                return back()->with('error', 'Không thể mua lại vì tất cả sản phẩm đã hết hàng hoặc không còn tồn tại!');
            }

            $message = implode(' ', $messages);
            
            // Nếu có sản phẩm bị điều chỉnh hoặc hết hàng, hiển thị warning
            if (count($adjustedProducts) > 0 || count($outOfStockProducts) > 0 || count($unavailableProducts) > 0) {
                return redirect()->route('checkout.index')->with('warning', $message);
            }

            return redirect()->route('checkout.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
