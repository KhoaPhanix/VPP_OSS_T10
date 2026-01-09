<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'full_name' => 'Test User',
            'phone' => '0901234567',
            'address' => '123 Test Street',
        ]);
        
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        
        $this->product = Product::factory()->create([
            'name' => 'Bút bi xanh',
            'price' => 5000,
            'stock_quantity' => 100,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);
    }

    /**
     * Test guest cannot access checkout
     */
    public function test_guest_cannot_access_checkout(): void
    {
        $response = $this->get('/checkout');

        $response->assertRedirect('/login');
    }

    /**
     * Test user with empty cart cannot checkout
     */
    public function test_user_with_empty_cart_cannot_checkout(): void
    {
        $response = $this->actingAs($this->user)->get('/checkout');

        $response->assertRedirect('/cart');
    }

    /**
     * Test user can view checkout page
     */
    public function test_user_can_view_checkout_page(): void
    {
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)->get('/checkout');

        $response->assertStatus(200);
        $response->assertSee('Thanh toán');
    }

    /**
     * Test user can place order
     */
    public function test_user_can_place_order(): void
    {
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)->post('/checkout', [
            'full_name' => 'Test User',
            'phone' => '0901234567',
            'shipping_address' => '123 Test Street',
            'payment_method' => 'cod',
            'notes' => 'Giao hàng giờ hành chính',
        ]);

        $response->assertRedirect();
        
        // Check order created
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        // Check order details created
        $order = Order::where('user_id', $this->user->id)->first();
        $this->assertDatabaseHas('order_details', [
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        // Check cart is cleared
        $this->assertDatabaseMissing('carts', ['user_id' => $this->user->id]);
    }

    /**
     * Test checkout reduces stock
     */
    public function test_checkout_reduces_stock(): void
    {
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 10,
        ]);

        $this->actingAs($this->user)->post('/checkout', [
            'full_name' => 'Test User',
            'phone' => '0901234567',
            'shipping_address' => '123 Test Street',
            'payment_method' => 'cod',
        ]);

        $this->product->refresh();
        $this->assertEquals(90, $this->product->stock_quantity);
    }

    /**
     * Test checkout validation
     */
    public function test_checkout_validation(): void
    {
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)->post('/checkout', [
            'full_name' => '',
            'phone' => '',
            'shipping_address' => '',
        ]);

        $response->assertSessionHasErrors(['full_name', 'phone', 'shipping_address']);
    }

    /**
     * Test cannot checkout with insufficient stock
     */
    public function test_cannot_checkout_with_insufficient_stock(): void
    {
        // Create cart with more quantity than stock
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 200, // More than available (100)
        ]);

        $response = $this->actingAs($this->user)->post('/checkout', [
            'full_name' => 'Test User',
            'phone' => '0901234567',
            'shipping_address' => '123 Test Street',
            'payment_method' => 'cod',
        ]);

        $response->assertSessionHas('error');
    }
}
