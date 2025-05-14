<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для запасов
 */
class CreateStocksTable extends Migration
{
    /**
     * Запуск миграции
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id'); // FK id товара
            $table->unsignedBigInteger('warehouse_id'); // FK id склада
            $table->integer('stock'); // количество в запасе

            $table->primary(['product_id', 'warehouse_id']); // PK

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); // создание FK товара
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade'); // создание FK склада

        });
    }

    /**
     * Откат миграции
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
