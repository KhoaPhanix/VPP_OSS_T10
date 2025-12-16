<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Danh sách sản phẩm
     */
    public function index()
    {
        $products = Product::with('category', 'supplier')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Form thêm sản phẩm
     */
    public function create()
    {
        $categories = Category::active()->get();
        $suppliers = Supplier::active()->get();

        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    /**
     * Lưu sản phẩm mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:products',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);

        $product = Product::create($validated);

        // Log initial stock
        if ($product->stock_quantity > 0) {
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $product->stock_quantity,
                'quantity_before' => 0,
                'quantity_after' => $product->stock_quantity,
                'notes' => 'Nhập kho ban đầu',
                'created_by' => Auth::id(),
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được thêm!');
    }

    /**
     * Form chỉnh sửa sản phẩm
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::active()->get();
        $suppliers = Supplier::active()->get();

        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|unique:products,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật!');
    }

    /**
     * Cập nhật tồn kho
     */
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);
        $oldStock = $product->stock_quantity;
        $newStock = $oldStock + $request->quantity;

        DB::beginTransaction();
        try {
            $product->update(['stock_quantity' => $newStock]);

            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $request->quantity,
                'quantity_before' => $oldStock,
                'quantity_after' => $newStock,
                'notes' => $request->notes ?? 'Nhập kho',
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return back()->with('success', 'Đã cập nhật tồn kho!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Sản phẩm đã được xóa!');
    }
}
