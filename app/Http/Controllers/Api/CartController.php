<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get cart items
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $cartItems,
                'total' => $total,
                'count' => $cartItems->sum('quantity'),
            ],
        ]);
    }

    /**
     * Add product to cart
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if (!$product->hasStock($request->quantity)) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không đủ số lượng trong kho',
            ], 400);
        }

        // Check if product already in cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if (!$product->hasStock($newQuantity)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tổng số lượng vượt quá số lượng trong kho',
                ], 400);
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cartItem = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng',
            'data' => $cartItem->load('product'),
        ], 201);
    }

    /**
     * Update cart item quantity
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng',
            ], 404);
        }

        // Check stock
        if (!$cartItem->product->hasStock($request->quantity)) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng vượt quá số lượng trong kho',
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật số lượng',
            'data' => $cartItem->load('product'),
        ]);
    }

    /**
     * Remove item from cart
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng',
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
        ]);
    }

    /**
     * Clear cart
     * 
     * @return JsonResponse
     */
    public function clear(): JsonResponse
    {
        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ giỏ hàng',
        ]);
    }
}
