<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Warehouse;

class StockMovementFactory extends Factory
{
    protected $model = StockMovement::class;

    /**
     * Определение фабрики для движения товара
     *
     * @return array
     */
    public function definition()
    {
        // Из уже существующих product и warehouse
        $productId = Product::inRandomOrder()->value('id') ?? 1;
        $warehouseId = Warehouse::inRandomOrder()->value('id') ?? 1;

        // Cлучайное изменение количества
        $quantityChange = $this->faker->numberBetween(-10, 10);

        return [
            'warehouse_id' => $warehouseId,
            'product_id' => $productId,
            'quantity_change' => $quantityChange,
            'type' =>  $this->faker->randomElement(['increase', 'decrease']),
            'created_at' => $this->faker->dateTimeBetween('-1 months', 'now'),
        ];
    }
}
