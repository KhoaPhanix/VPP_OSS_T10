<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user can be created
     */
    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'full_name' => 'Test User',
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Test user password is hashed
     */
    public function test_user_password_is_hashed(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /**
     * Test user has orders relationship
     */
    public function test_user_has_many_orders(): void
    {
        $user = User::factory()->create();
        Order::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->orders);
    }

    /**
     * Test user has cart relationship
     */
    public function test_user_has_many_cart_items(): void
    {
        $user = User::factory()->create();
        Cart::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->carts);
    }

    /**
     * Test admin check method
     */
    public function test_user_is_admin_method(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($customer->isAdmin());
    }

    /**
     * Test user soft delete
     */
    public function test_user_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertSoftDeleted('users', ['id' => $userId]);
    }

    /**
     * Test user hidden attributes
     */
    public function test_user_password_is_hidden(): void
    {
        $user = User::factory()->create();
        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }
}
