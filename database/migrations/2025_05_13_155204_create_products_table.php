<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для товара
 */
class CreateProductsTable extends Migration
{
    /**
     * Запуск миграции
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID продукта
            $table->string('name', 255); // название продукта
            $table->float('price', 8, 2); // цена
        });
    }

    /**
     * Откат миграции
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('products');
    }
};
