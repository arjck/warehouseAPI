<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Модель остатка товаров на складе(запасов)
 */
class Stock extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'stocks';
    protected $primaryKey = ['product_id', 'warehouse_id'];
    protected $fillable = ['product_id', 'warehouse_id', 'stock'];

    /**
     * Связь с товаром
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Связь со складом
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
