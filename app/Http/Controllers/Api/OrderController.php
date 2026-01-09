<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get user orders
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $orders = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Create new order from cart
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống',
            ], 400);
        }

        // Check stock
        foreach ($cartItems as $item) {
            if (!$item->product->hasStock($item->quantity)) {
                return response()->json([
                    'success' => false,
                    'message' => "Sản phẩm {$item->product->name} không đủ hàng",
                ], 400);
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
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'notes' => $request->notes,
            ]);

            // Create order details and update stock
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);

                // Update stock
                $product = $item->product;
                $oldStock = $product->stock_quantity;
                $product->decrement('stock_quantity', $item->quantity);

                // Record stock movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'quantity_before' => $oldStock,
                    'quantity_after' => $product->stock_quantity,
                    'reference_type' => 'order',
                    'reference_id' => $order->id,
                    'notes' => "Đơn hàng {$order->order_number}",
                    'created_by' => Auth::id(),
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công',
                'data' => $order->load('orderDetails.product'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get order detail
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $order = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Reorder - Add products from order to cart
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function reorder(int $id): JsonResponse
    {
        $order = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng',
            ], 404);
        }

        if (!$order->isCompleted()) {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ có thể mua lại đơn hàng đã hoàn thành',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Clear current cart
            Cart::where('user_id', Auth::id())->delete();

            $addedProducts = [];
            $outOfStockProducts = [];

            foreach ($order->orderDetails as $detail) {
                if (!$detail->product) {
                    continue;
                }

                if ($detail->product->stock_quantity >= $detail->quantity) {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $detail->product_id,
                        'quantity' => $detail->quantity,
                    ]);
                    $addedProducts[] = $detail->product->name;
                } elseif ($detail->product->stock_quantity > 0) {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $detail->product_id,
                        'quantity' => $detail->product->stock_quantity,
                    ]);
                    $addedProducts[] = $detail->product->name . " (chỉ còn {$detail->product->stock_quantity})";
                } else {
                    $outOfStockProducts[] = $detail->product->name;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'data' => [
                    'added_products' => $addedProducts,
                    'out_of_stock_products' => $outOfStockProducts,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }
}
