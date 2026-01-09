<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test cart item can be created
     */
    public function test_cart_item_can_be_created(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);
    }

    /**
     * Test cart belongs to user
     */
    public function test_cart_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $cart->user);
        $this->assertEquals($user->id, $cart->user->id);
    }

    /**
     * Test cart belongs to product
     */
    public function test_cart_belongs_to_product(): void
    {
        $product = Product::factory()->create(['name' => 'Bút bi']);
        $cart = Cart::factory()->create(['product_id' => $product->id]);

        $this->assertInstanceOf(Product::class, $cart->product);
        $this->assertEquals('Bút bi', $cart->product->name);
    }

    /**
     * Test cart quantity update
     */
    public function test_cart_quantity_can_be_updated(): void
    {
        $cart = Cart::factory()->create(['quantity' => 3]);

        $cart->update(['quantity' => 10]);

        $this->assertEquals(10, $cart->fresh()->quantity);
    }

    /**
     * Test cart item can be deleted
     */
    public function test_cart_item_can_be_deleted(): void
    {
        $cart = Cart::factory()->create();
        $cartId = $cart->id;

        $cart->delete();

        $this->assertDatabaseMissing('carts', ['id' => $cartId]);
    }

    /**
     * Test get cart items for user
     */
    public function test_get_cart_items_for_user(): void
    {
        $user = User::factory()->create();
        Cart::factory()->count(4)->create(['user_id' => $user->id]);

        $cartItems = Cart::where('user_id', $user->id)->get();

        $this->assertCount(4, $cartItems);
    }

    /**
     * Test cart subtotal calculation
     */
    public function test_cart_subtotal(): void
    {
        $product = Product::factory()->create(['price' => 10000]);
        $cart = Cart::factory()->create([
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $subtotal = $cart->quantity * $cart->product->price;

        $this->assertEquals(50000, $subtotal);
    }
}
