<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграции для склада
 */
class CreateWarehousesTable extends Migration
{
    /**
     * Запуск миграции
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id'); // PK id склада
            $table->string('name', 255); // название
        });
    }

    /**
     * Откат миграции
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
};
