<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Модель заказа (cводная таблица)
 */
class OrderItem extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'count'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
