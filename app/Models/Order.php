<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Модель заказа
 */
class Order extends Model
{
    use HasFactory;

    // Константы статусов
    public const STATUS_ACTIVE = 'active';
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'cancelled';

    public $timestamps = false;
    protected $table = 'orders';
    protected $fillable = ['customer', 'warehouse_id', 'status', 'created_at', 'completed_at'];

    /**
     * Связь с заказами
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Связь со складом
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
