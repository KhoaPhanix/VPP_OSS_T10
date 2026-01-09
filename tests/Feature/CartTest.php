<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
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
    }

    /**
     * Test guest cannot access cart
     */
    public function test_guest_cannot_access_cart(): void
    {
        $response = $this->get('/cart');

        $response->assertRedirect('/login');
    }

    /**
     * Test user can view cart
     */
    public function test_user_can_view_cart(): void
    {
        $response = $this->actingAs($this->user)->get('/cart');

        $response->assertStatus(200);
    }

    /**
     * Test user can add product to cart
     */
    public function test_user_can_add_product_to_cart(): void
    {
        $response = $this->actingAs($this->user)
            ->post("/cart/add/{$this->product->id}", [
                'quantity' => 2,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('carts', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);
    }

    /**
     * Test adding same product increases quantity
     */
    public function test_adding_same_product_increases_quantity(): void
    {
        // Add product first time
        $this->actingAs($this->user)
            ->post("/cart/add/{$this->product->id}", ['quantity' => 2]);

        // Add same product again
        $this->actingAs($this->user)
            ->post("/cart/add/{$this->product->id}", ['quantity' => 3]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 5,
        ]);
    }

    /**
     * Test cannot add more than stock
     */
    public function test_cannot_add_more_than_stock(): void
    {
        $response = $this->actingAs($this->user)
            ->post("/cart/add/{$this->product->id}", [
                'quantity' => 150, // More than stock (100)
            ]);

        $response->assertSessionHas('error');
    }

    /**
     * Test user can update cart quantity
     */
    public function test_user_can_update_cart_quantity(): void
    {
        $cart = Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)
            ->put("/cart/update/{$cart->id}", [
                'quantity' => 5,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'quantity' => 5,
        ]);
    }

    /**
     * Test user can remove item from cart
     */
    public function test_user_can_remove_item_from_cart(): void
    {
        $cart = Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)
            ->delete("/cart/remove/{$cart->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    /**
     * Test user can clear cart
     */
    public function test_user_can_clear_cart(): void
    {
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)->delete('/cart/clear');

        $response->assertRedirect();
        $this->assertDatabaseMissing('carts', ['user_id' => $this->user->id]);
    }

    /**
     * Test cart shows correct total
     */
    public function test_cart_shows_correct_total(): void
    {
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 3,
        ]);

        $response = $this->actingAs($this->user)->get('/cart');

        $response->assertStatus(200);
        // Total should be 3 * 5000 = 15000
        $response->assertSee('15.000');
    }
}
