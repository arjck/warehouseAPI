<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use App\Protocols\OrderFilterInterface;
use App\Repositories\OrderRepository;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $order;
    protected $filteredOrders;

    protected function setUp(): void
    {
        parent::setUp();

        $this->warehouse = Warehouse::factory()->create();
        $this->product = Product::factory()->create();
        $this->order = Order::factory()->create([
            'warehouse_id' => $this->warehouse->id,
        ]);
    }

    /**
     * Проверяет получение списка заказов
     *
     * @return void
     */
    public function test_can_get_list_of_orders()
    {
        $response = $this->get('/api/orders');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'data' => [
                         '*' => ['id', 'customer', 'warehouse_id', 'status', 'created_at', 'completed_at']
                     ]
                 ]);
    }

    /**
     * Проверяет создание нового заказа
     *
     * @return void
     */
    public function test_can_create_order()
    {
        $payload = [
            'warehouse_id' => $this->warehouse->id,
            'product_id' => $this->product->id,
            'quantity' => 5,
            'customer' => 'abc',
            'status' => 'active'
        ];

        $response = $this->post('/api/orders', $payload);
        
        $response->assertStatus(201)
                 ->assertJsonFragment(['warehouse_id' => $this->warehouse->id]);
    }

    /**
     * Проверяет обновление заказа
     *
     * @return void
     */
    public function test_can_update_order()
    {
        $payload = [
            'quantity' => 10
        ];

        $response = $this->put('/api/orders/'.$this->order->id, $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $this->order->id]);
    }

    /**
     * Проверяет завершение заказа
     *
     * @return void
     */
    public function test_can_complete_order()
    {
        $response = $this->post('/api/orders/'.$this->order->id.'/complete');

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'completed']);
    }

    /**
     * Проверяет отмену заказа
     *
     * @return void
     */
    public function test_can_cancel_order()
    {
        $response = $this->post('/api/orders/'.$this->order->id.'/cancel');

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'cancelled']);
    }

    /**
     * Проверяет возобновление заказа
     *
     * @return void
     */
    public function test_can_resume_order()
    {
        // Предположим, что заказ уже отменен
        $this->order->update(['status' => 'cancelled']);

        $response = $this->post('/api/orders/'.$this->order->id.'/resume');

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'active']);
    }
}
