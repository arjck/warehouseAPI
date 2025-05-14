<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Warehouse;

class WarehouseFactory extends Factory
{
    protected $model = Warehouse::class;

    /**
     * Определение фабрики для склада
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company() . ' Warehouse',
        ];
    }
}