<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\Order;
use App\Models\OrderItem;

class TestDataSeeder extends Seeder
{
    /**
     * Наполням бд тестовыми данными
     *
     * @return void
     */
    public function run()
    {
        // Создаем 5 складов
        $warehouses = Warehouse::factory()->count(5)->create();

        // Создаем 20 товаров
        $products = Product::factory()->count(20)->create();

        // Создаем запасы товаров на складах
        $stocksData = [];
        foreach ($products as $product) {
            foreach ($warehouses as $warehouse) {
                // Запас для каждого товара на каждом складе
                Stock::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'stock' => rand(0, 30), // случайное количество
                ]);
            }
        }
        Stock::insert($stocksData);

        // Создаем заказы
        for ($i = 0; $i < 30; $i++) {
            $warehouse = $warehouses->random();

            $order = Order::factory()->create([
                'warehouse_id' => $warehouse->id,
                'status' => 'active',
                'created_at' => now()->subDays(rand(0, 60)),
                'completed_at' => null,
            ]);
        }
    }
}