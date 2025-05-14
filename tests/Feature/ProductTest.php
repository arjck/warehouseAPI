<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
    }

    /**
     * Проверяет получение списка продуктов
     *
     * @return void
     */
    public function test_can_get_list_of_products()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['id', 'name', 'price']
                 ]);
    }
}