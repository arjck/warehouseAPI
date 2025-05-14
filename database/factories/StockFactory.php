<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stock;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    /**
     * Определение фабрики для запасов товара
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'warehouse_id' => Warehouse::factory(),
            'stock' => $this->faker->numberBetween(0, 200),
        ];
    }
}
