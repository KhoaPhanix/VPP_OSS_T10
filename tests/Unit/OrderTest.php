<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test order can be created
     */
    public function test_order_can_be_created(): void
    {
        $order = Order::factory()->create([
            'order_number' => 'ORD-123456',
            'total_amount' => 150000,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('orders', [
            'order_number' => 'ORD-123456',
            'status' => 'pending',
        ]);
    }

    /**
     * Test order belongs to user
     */
    public function test_order_belongs_to_user(): void
    {
        $user = User::factory()->create(['full_name' => 'Nguyễn Văn A']);
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals('Nguyễn Văn A', $order->user->full_name);
    }

    /**
     * Test order has many order details
     */
    public function test_order_has_many_order_details(): void
    {
        $order = Order::factory()->create();
        OrderDetail::factory()->count(3)->create(['order_id' => $order->id]);

        $this->assertCount(3, $order->orderDetails);
    }

    /**
     * Test order status methods
     */
    public function test_order_status_methods(): void
    {
        $pendingOrder = Order::factory()->create(['status' => 'pending']);
        $approvedOrder = Order::factory()->create(['status' => 'approved']);
        $completedOrder = Order::factory()->create(['status' => 'completed']);
        $rejectedOrder = Order::factory()->create(['status' => 'rejected']);

        $this->assertTrue($pendingOrder->isPending());
        $this->assertTrue($approvedOrder->isApproved());
        $this->assertTrue($completedOrder->isCompleted());
        $this->assertTrue($rejectedOrder->isRejected());
    }

    /**
     * Test order total calculation
     */
    public function test_order_total_amount(): void
    {
        $order = Order::factory()->create(['total_amount' => 250000]);

        $this->assertEquals(250000, $order->total_amount);
    }

    /**
     * Test order number is unique
     */
    public function test_order_number_generation(): void
    {
        $order1 = Order::factory()->create();
        $order2 = Order::factory()->create();

        $this->assertNotEquals($order1->order_number, $order2->order_number);
    }

    /**
     * Test order filter by status scope
     */
    public function test_order_filter_by_status(): void
    {
        Order::factory()->count(3)->create(['status' => 'pending']);
        Order::factory()->count(2)->create(['status' => 'completed']);

        $pendingOrders = Order::where('status', 'pending')->get();
        $completedOrders = Order::where('status', 'completed')->get();

        $this->assertCount(3, $pendingOrders);
        $this->assertCount(2, $completedOrders);
    }
}
