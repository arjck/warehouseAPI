<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Старт общего класса наполнения бд fake-данными
     */
    public function run(): void
    {
        $this->call([
            TestDataSeeder::class,
            StockMovementSeeder::class
        ]);
    }
}
