<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->customer = User::factory()->create(['role' => 'customer']);
    }

    /**
     * Test guest cannot access admin dashboard
     */
    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Test customer cannot access admin dashboard
     */
    public function test_customer_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->customer)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    /**
     * Test admin can access dashboard
     */
    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test admin can view products list
     */
    public function test_admin_can_view_products_list(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/products');

        $response->assertStatus(200);
    }

    /**
     * Test admin can create product
     */
    public function test_admin_can_create_product(): void
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($this->admin)->post('/admin/products', [
            'code' => 'SP001',
            'name' => 'Test Product',
            'slug' => 'test-product',
            'price' => 10000,
            'stock_quantity' => 50,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'unit' => 'cái',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('products', [
            'code' => 'SP001',
            'name' => 'Test Product',
        ]);
    }

    /**
     * Test admin can update product
     */
    public function test_admin_can_update_product(): void
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/products/{$product->id}", [
            'code' => $product->code,
            'name' => 'Updated Product Name',
            'slug' => $product->slug,
            'price' => 15000,
            'stock_quantity' => 100,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'unit' => 'cái',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name',
            'price' => 15000,
        ]);
    }

    /**
     * Test admin can delete product
     */
    public function test_admin_can_delete_product(): void
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/products/{$product->id}");

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    /**
     * Test admin can view orders
     */
    public function test_admin_can_view_orders(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/orders');

        $response->assertStatus(200);
    }

    /**
     * Test admin can approve order
     */
    public function test_admin_can_approve_order(): void
    {
        $order = Order::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin)->post("/admin/orders/{$order->id}/approve");

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'approved',
        ]);
    }

    /**
     * Test admin can reject order
     */
    public function test_admin_can_reject_order(): void
    {
        $order = Order::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin)->post("/admin/orders/{$order->id}/reject", [
            'reject_reason' => 'Hết hàng',
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'rejected',
        ]);
    }

    /**
     * Test admin can complete order
     */
    public function test_admin_can_complete_order(): void
    {
        $order = Order::factory()->create(['status' => 'approved']);

        $response = $this->actingAs($this->admin)->post("/admin/orders/{$order->id}/complete");

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
        ]);
    }

    /**
     * Test admin can view reports
     */
    public function test_admin_can_view_revenue_report(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/reports/revenue');

        $response->assertStatus(200);
    }

    /**
     * Test admin can view categories
     */
    public function test_admin_can_view_categories(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/categories');

        $response->assertStatus(200);
    }
}
