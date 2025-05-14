<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class OrderHelper
{
    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $status = array_key_exists('status', $data) ? $data['status'] : null;
            $orderItems = array_key_exists('order_items', $data) ? $data['order_items'] : null;


            $order = Order::create([
                'customer' => $data['customer'],
                'warehouse_id' => $data['warehouse_id'],
                'status' => $status ?: 'active',
                'created_at' => now(),
            ]);

            if (isset($orderItems)) {
                $this->processOrderItems($order, $orderItems);
            }

            return $order->load('orderItems.product');
        });
    }

    public function updateOrder(Order $order, array $data): Order
    {
        $orderItems = array_key_exists('order_items', $data) ? $data['order_items'] : null;

        return DB::transaction(function () use ($order, $data) {
            $this->restoreStock($order->orderItems);
            $order->update(['customer' => $data['customer'] ?? $order->customer]);
            $order->orderItems()->delete();

            if (isset($orderItems)) {
                $this->processOrderItems($order, $orderItems);
            }

            return $order->load('orderItems.product');
        });
    }

    public function cancelOrder(Order $order, array $data)
    {
        $orderItems = array_key_exists('order_items', $data) ? $data['order_items'] : null;

        return DB::transaction(function () use ($order, $data) {
            if (isset($orderItems)) {
                $this->restoreStock($order->orderItems);;
            }
            $order->update(['status' => Order::STATUS_CANCELED]);
        });
    }

    public function resumeOrder(Order $order, array $data)
    {
        $orderItems = array_key_exists('order_items', $data) ? $data['order_items'] : null;
        $warehouseId = array_key_exists('warehouse_id', $data) ? $data['warehouse_id'] : null;

        return DB::transaction(function () use ($order) {
            if (isset($orderItems) && isset($warehouseId)) {
                $this->checkStockForOrderItems($order->orderItems, $order->warehouse_id);
            }

            if (isset($orderItems)) {
                $this->decrementStock($order->orderItems);
            }
            
            $order->update(['status' => Order::STATUS_ACTIVE]);
        });
    }

    public function completeOrder(Order $order)
    {
        if ($order->status !== Order::STATUS_ACTIVE) {
            throw new \Exception('Order not active');
        }
        $order->update(['status' => Order::STATUS_COMPLETED, 'completed_at' => now()]);
    }

    // Внутренние методы для работы с остатками

    private function processOrderItems(Order $order, array $items)
    {
        $this->checkStockForOrderItems($items, $order->warehouse_id);

        foreach ($items as $item) {
            $stock = Stock::where('product_id', $item['product_id'])
                ->where('warehouse_id', $order->warehouse_id)
                ->lockForUpdate()
                ->first();

            if (!$stock || $stock->stock < $item['count']) {
                throw new \Exception('Недостаточно товара на складе');
            }

            $stock->decrement('stock', $item['count']);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'count' => $item['count'],
            ]);
        }
    }

    private function restoreStock($orderItems)
    {
        foreach ($orderItems as $item) {
            $stock = Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $item->order->warehouse_id)
                ->lockForUpdate()
                ->first();

            if ($stock) {
                $stock->increment('stock', $item->count);
            }
        }
    }

    private function checkStockForOrderItems(array $items, int $warehouseId)
    {
        foreach ($items as $item) {
            $stock = Stock::where('product_id', $item['product_id'])
                ->where('warehouse_id', $warehouseId)
                ->lockForUpdate()
                ->first();

            if (!$stock || $stock->stock < $item['count']) {
                throw new \Exception('Недостаточно товара на складе');
            }
        }
    }

    private function decrementStock($orderItems)
    {
        foreach ($orderItems as $item) {
            $stock = Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $item->order->warehouse_id)
                ->lockForUpdate()
                ->first();

            $stock->decrement('stock', $item->count);
        }
    }
}