<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test product can be created
     */
    public function test_product_can_be_created(): void
    {
        $product = Product::factory()->create([
            'name' => 'Bút bi xanh',
            'price' => 5000,
            'stock_quantity' => 100,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Bút bi xanh',
            'price' => 5000,
        ]);
    }

    /**
     * Test product belongs to category
     */
    public function test_product_belongs_to_category(): void
    {
        $category = Category::factory()->create(['name' => 'Bút viết']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals('Bút viết', $product->category->name);
    }

    /**
     * Test product belongs to supplier
     */
    public function test_product_belongs_to_supplier(): void
    {
        $supplier = Supplier::factory()->create(['name' => 'Thiên Long']);
        $product = Product::factory()->create(['supplier_id' => $supplier->id]);

        $this->assertInstanceOf(Supplier::class, $product->supplier);
        $this->assertEquals('Thiên Long', $product->supplier->name);
    }

    /**
     * Test product has stock check method
     */
    public function test_product_has_stock_method(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $this->assertTrue($product->hasStock(5));
        $this->assertTrue($product->hasStock(10));
        $this->assertFalse($product->hasStock(11));
    }

    /**
     * Test product scope for active products
     */
    public function test_product_active_scope(): void
    {
        Product::factory()->count(3)->create(['is_active' => true]);
        Product::factory()->count(2)->create(['is_active' => false]);

        $activeProducts = Product::where('is_active', true)->get();

        $this->assertCount(3, $activeProducts);
    }

    /**
     * Test product scope for featured products
     */
    public function test_product_featured_scope(): void
    {
        Product::factory()->count(2)->create(['is_featured' => true]);
        Product::factory()->count(4)->create(['is_featured' => false]);

        $featuredProducts = Product::where('is_featured', true)->get();

        $this->assertCount(2, $featuredProducts);
    }

    /**
     * Test product price formatting
     */
    public function test_product_price_is_decimal(): void
    {
        $product = Product::factory()->create(['price' => 15000.50]);

        $this->assertEquals(15000.50, $product->price);
    }

    /**
     * Test product soft delete
     */
    public function test_product_can_be_soft_deleted(): void
    {
        $product = Product::factory()->create();
        $productId = $product->id;

        $product->delete();

        $this->assertSoftDeleted('products', ['id' => $productId]);
    }
}
