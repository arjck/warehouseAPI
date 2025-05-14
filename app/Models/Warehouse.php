<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Модель склада
 */
class Warehouse extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'warehouses';
    protected $fillable = ['name'];

    /**
     * Связь с запасами
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Связь с позициями заказа
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
