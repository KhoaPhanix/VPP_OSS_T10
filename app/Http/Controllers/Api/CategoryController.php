<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Get all categories
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get category by slug
     * 
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy danh mục',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }

    /**
     * Get products by category
     * 
     * @param string $slug
     * @param Request $request
     * @return JsonResponse
     */
    public function products(string $slug, Request $request): JsonResponse
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy danh mục',
            ], 404);
        }

        $products = $category->products()
            ->where('is_active', true)
            ->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
                'products' => $products,
            ],
        ]);
    }
}
