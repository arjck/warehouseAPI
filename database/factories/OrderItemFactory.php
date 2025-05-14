<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * Определение фабрики для заказа (сводная таблица)
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'count' => $this->faker->numberBetween(1, 10),
        ];
    }
}
