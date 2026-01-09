<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create categories and suppliers for products
        Category::factory()->count(3)->create();
        Supplier::factory()->count(2)->create();
    }

    /**
     * Test home page can be rendered
     */
    public function test_home_page_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test products page can be rendered
     */
    public function test_products_page_can_be_rendered(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    /**
     * Test products are displayed on products page
     */
    public function test_products_are_displayed(): void
    {
        $category = Category::first();
        $supplier = Supplier::first();

        Product::factory()->create([
            'name' => 'Bút bi Thiên Long',
            'price' => 5000,
            'is_active' => true,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Bút bi Thiên Long');
    }

    /**
     * Test product detail page can be rendered
     */
    public function test_product_detail_page_can_be_rendered(): void
    {
        $category = Category::first();
        $supplier = Supplier::first();

        $product = Product::factory()->create([
            'name' => 'Vở ô ly',
            'slug' => 'vo-o-ly',
            'price' => 15000,
            'is_active' => true,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);

        $response = $this->get("/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee('Vở ô ly');
        $response->assertSee('15.000');
    }

    /**
     * Test can filter products by category
     */
    public function test_can_filter_products_by_category(): void
    {
        $category = Category::factory()->create(['name' => 'Bút viết', 'slug' => 'but-viet']);
        $supplier = Supplier::first();

        Product::factory()->create([
            'name' => 'Bút bi xanh',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'is_active' => true,
        ]);

        $response = $this->get('/products?category=' . $category->slug);

        $response->assertStatus(200);
        $response->assertSee('Bút bi xanh');
    }

    /**
     * Test can search products
     */
    public function test_can_search_products(): void
    {
        $category = Category::first();
        $supplier = Supplier::first();

        Product::factory()->create([
            'name' => 'Thước kẻ 30cm',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'is_active' => true,
        ]);

        $response = $this->get('/products?search=thước');

        $response->assertStatus(200);
        $response->assertSee('Thước kẻ 30cm');
    }

    /**
     * Test inactive products are not shown
     */
    public function test_inactive_products_are_not_shown(): void
    {
        $category = Category::first();
        $supplier = Supplier::first();

        Product::factory()->create([
            'name' => 'Sản phẩm ẩn',
            'is_active' => false,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);

        $response = $this->get('/products');

        $response->assertDontSee('Sản phẩm ẩn');
    }

    /**
     * Test featured products are shown on home page
     */
    public function test_featured_products_on_home_page(): void
    {
        $category = Category::first();
        $supplier = Supplier::first();

        Product::factory()->create([
            'name' => 'Sản phẩm nổi bật',
            'is_active' => true,
            'is_featured' => true,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test products pagination
     */
    public function test_products_are_paginated(): void
    {
        $category = Category::first();
        $supplier = Supplier::first();

        Product::factory()->count(20)->create([
            'is_active' => true,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    /**
     * Test 404 for non-existent product
     */
    public function test_404_for_non_existent_product(): void
    {
        $response = $this->get('/products/non-existent-product');

        $response->assertStatus(404);
    }
}
