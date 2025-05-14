<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Модель товара
 */
class Product extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'products';
    protected $fillable = ['name', 'price'];

    /**
     * Связь с запасами
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }

    /**
     * Связь с заказами
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
