<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграции для заказа и склада
 */
class CreateOrdersTable extends Migration
{
    /**
     * Запуск миграции
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id'); // PK id заказа
            $table->string('customer', 255); // пользователь
            $table->unsignedBigInteger('warehouse_id'); // FK id склада
            $table->enum('status', ["active", "completed", "canceled"])->default('active'); // статус
            $table->timestamp('created_at')->useCurrent(); // создано
            $table->timestamp('completed_at')->nullable(); // завершено
        });

        // создание FK склада
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('warehouse_id')
                  ->references('id')->on('warehouses')
                  ->onDelete('restrict');
        });
    }

    /**
     * Откат миграции
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
