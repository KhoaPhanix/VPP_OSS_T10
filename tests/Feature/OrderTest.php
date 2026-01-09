<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Order $order;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        
        $this->product = Product::factory()->create([
            'name' => 'Bút bi xanh',
            'price' => 5000,
            'stock_quantity' => 100,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);

        $this->order = Order::factory()->create([
            'user_id' => $this->user->id,
            'order_number' => 'ORD-123456',
            'total_amount' => 25000,
            'status' => 'completed',
        ]);

        OrderDetail::factory()->create([
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'quantity' => 5,
            'price' => 5000,
            'subtotal' => 25000,
        ]);
    }

    /**
     * Test guest cannot view orders
     */
    public function test_guest_cannot_view_orders(): void
    {
        $response = $this->get('/orders');

        $response->assertRedirect('/login');
    }

    /**
     * Test user can view orders list
     */
    public function test_user_can_view_orders_list(): void
    {
        $response = $this->actingAs($this->user)->get('/orders');

        $response->assertStatus(200);
        $response->assertSee('ORD-123456');
    }

    /**
     * Test user can view order detail
     */
    public function test_user_can_view_order_detail(): void
    {
        $response = $this->actingAs($this->user)->get("/orders/{$this->order->id}");

        $response->assertStatus(200);
        $response->assertSee('ORD-123456');
        $response->assertSee('Bút bi xanh');
    }

    /**
     * Test user cannot view other user order
     */
    public function test_user_cannot_view_other_user_order(): void
    {
        $otherUser = User::factory()->create();
        $otherOrder = Order::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get("/orders/{$otherOrder->id}");

        $response->assertStatus(404);
    }

    /**
     * Test user can reorder completed order
     */
    public function test_user_can_reorder_completed_order(): void
    {
        $response = $this->actingAs($this->user)
            ->post("/orders/{$this->order->id}/reorder");

        $response->assertRedirect('/checkout');
        
        // Check cart has items from order
        $this->assertDatabaseHas('carts', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * Test user cannot reorder pending order
     */
    public function test_user_cannot_reorder_pending_order(): void
    {
        $pendingOrder = Order::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)
            ->post("/orders/{$pendingOrder->id}/reorder");

        $response->assertSessionHas('error');
    }

    /**
     * Test orders are paginated
     */
    public function test_orders_are_paginated(): void
    {
        Order::factory()->count(15)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get('/orders');

        $response->assertStatus(200);
    }

    /**
     * Test order shows correct status
     */
    public function test_order_shows_correct_status(): void
    {
        $pendingOrder = Order::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->get('/orders');

        $response->assertSee('Chờ duyệt');
    }
}
