<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Helpers\OrderHelper;
use App\Protocols\OrderFilterInterface;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    protected $orderHelper;
    protected $filterRepository;

    public function __construct(OrderHelper $orderHelper, OrderFilterInterface $filter)
    {
        $this->orderHelper = $orderHelper;
        $this->filterRepository = new OrderRepository($filter);
    }

    /**
     * Получить список заказов (с фильтрацией и пагинацией)
     */
    public function index(Request $request)
    {
        // Получаем фильтр через репозиторий
        $orders = $this->filterRepository->getFilteredOrders($request);

        return response()->json($orders);
    }

    /**
     * Создать заказ
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer' => 'required|string|max:255',
            'warehouse_id' => 'required|exists:warehouses,id',
            'order_items' => 'nullable|array|min:1',
            'order_items.*.product_id' => 'nullable|exists:products,id',
            'order_items.*.count' => 'nullable|integer|min:1',
        ]);

        try {
            $order = $this->orderHelper->createOrder($validated);
            return response()->json($order, 201);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Обновить заказ
     */
    public function update($orderId, Request $request)
    {
        $order = Order::findOrFail($orderId);
        $validated = $request->validate([
            'customer' => 'sometimes|string|max:255',
            'order_items' => 'nullable|array|min:1',
            'order_items.*.product_id' => 'nullable|exists:products,id',
            'order_items.*.count' => 'nullable|integer|min:1',
        ]);

        try {
            $updatedOrder = $this->orderHelper->updateOrder($order, $validated);
            return response()->json($updatedOrder);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * * Завершить заказ
     */
    public function complete($orderId)
    {
        $order = Order::findOrFail($orderId);
        try {
            $this->orderHelper->completeOrder($order);
            return response()->json(['status' => Order::STATUS_COMPLETED]);
        } catch (\Throwable $e) {
            dd($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * * Отменить заказ
     */
    public function cancel($orderId, Request $request)
    {
        $order = Order::findOrFail($orderId);
        $validated = $request->validate([
            'customer' => 'sometimes|string|max:255',
            'order_items' => 'nullable|array|min:1',
            'order_items.*.product_id' => 'nullable|exists:products,id',
            'order_items.*.count' => 'nullable|integer|min:1',
        ]);
        try {
            $this->orderHelper->cancelOrder($order, $validated);
            return response()->json(['status' => Order::STATUS_CANCELED]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Возобновить заказ
     */
    public function resume($orderId, Request $request)
    {
        $order = Order::findOrFail($orderId);
        $validated = $request->validate([
            'customer' => 'sometimes|string|max:255',
            'order_items' => 'nullable|array|min:1',
            'order_items.*.product_id' => 'nullable|exists:products,id',
            'order_items.*.count' => 'nullable|integer|min:1',
        ]);
        try {
            $this->orderHelper->resumeOrder($order, $validated);
            return response()->json(['status' => Order::STATUS_ACTIVE]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}