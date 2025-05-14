<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для заказа (cводная таблица)
 */
class CreateOrderItemsTable extends Migration
{
    /**
     * Запуск миграции
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id'); // PK id заказа (сводного)
            $table->unsignedBigInteger('order_id'); // FK id заказа
            $table->unsignedBigInteger('product_id'); // FK id товара
            $table->integer('count'); // количество заказа

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); // создание FK заказа
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict'); // создание FK товара
        });
    }

    /**
     * Откат миграции
     */
    public function down()
    {
        // удаление FK
        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropForeign('product_id'); 
        //     $table->dropForeign('order_id');
        // });
        Schema::dropIfExists('order_items');
    }
};
