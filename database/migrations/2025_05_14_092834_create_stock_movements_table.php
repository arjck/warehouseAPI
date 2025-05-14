<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    /**
     * Запуск миграции
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            // Связи
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('product_id');

            // Количество изменения
            $table->integer('quantity_change');

            // Тип движения
            $table->enum('type', ['increase', 'decrease'])->nullable();

            // Метка времени
            $table->timestamp('created_at')->useCurrent();

            // Внешние ключи
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Индексы для фильтрации
            $table->index('warehouse_id');
            $table->index('product_id');
            $table->index('created_at');
        });
    }

    /**
     * Откат миграции
     */
    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
};
