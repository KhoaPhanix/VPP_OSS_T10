<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);

        if (!$product->hasStock($request->quantity)) {
            return back()->with('error', 'Không đủ hàng trong kho!');
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ],
            [
                'quantity' => \DB::raw("quantity + {$request->quantity}"),
            ]
        );

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    /**
     * Cập nhật số lượng
     */
    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', Auth::id())->findOrFail($cartId);

        if (!$cart->product->hasStock($request->quantity)) {
            return back()->with('error', 'Không đủ hàng trong kho!');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Đã cập nhật giỏ hàng!');
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove($cartId)
    {
        Cart::where('user_id', Auth::id())->findOrFail($cartId)->delete();

        return back()->with('success', 'Đã xóa khỏi giỏ hàng!');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}
