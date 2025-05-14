<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Warehouse;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Определение фабрики для заказа
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer' => $this->faker->name(),
            'warehouse_id' => Warehouse::factory(),
            'status' => 'active',
            'created_at' => $this->faker->dateTimeBetween('-1 months', 'now'),
            'completed_at' => null,
        ];
    }
}
