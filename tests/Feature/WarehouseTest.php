<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Warehouse;

class WarehouseTest extends TestCase
{
    use RefreshDatabase;
    protected $warehouse;

    protected function setUp(): void
    {
        parent::setUp();

        $this->warehouse = Warehouse::factory()->create();
    }

    /**
     * Проверяет получение списка складов
     *
     * @return void
     */
    public function test_can_get_list_of_warehouses()
    {
        $response = $this->get('/api/warehouses');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['id', 'name']
                 ]);
    }
}