<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Warehouse;

class StockMovementSeeder extends Seeder
{
    /**
     * Наполням таблицу StockMovement тестовыми данными
     */
    public function run()
    {
        // Создание (при отсутствии) продуктов и складов
        if (!Product::exists()) {
            Product::factory()->count(10)->create();
        }

        if (!Warehouse::exists()) {
            Warehouse::factory()->count(5)->create();
        }

        // Генерируем данные для истории движений
        StockMovement::factory()->count(25)->create();
    }
}
