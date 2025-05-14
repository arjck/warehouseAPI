<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockMovement;

class StockMovementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
        $this->warehouse = Warehouse::factory()->create();

        // Создаем "движения товара" по складу
        StockMovement::factory()->count(3)->create([
            'product_id' => $this->product->id,
            'warehouse_id' => $this->warehouse->id,
        ]);
    }

    /**
     * Проверяет получение списка движений по складу
     *
     * @return void
     */
    public function test_can_get_list_of_stock_movements()
    {
        $response = $this->get('/api/stock-movements');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'data' => [ 
                        '*' => ['id', 'product_id', 'warehouse_id', 'type', 'quantity_change', 'created_at']
                    ]
                 ]);
    }
}