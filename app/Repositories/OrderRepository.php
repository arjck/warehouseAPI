<?php 

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Protocols\OrderFilterInterface;

class OrderRepository
{
    protected $filter;

    public function __construct(OrderFilterInterface $filter)
    {
        $this->filter = $filter;
    }

    public function getFilteredOrders(Request $request)
    {
        $query = Order::query();

        // применяем фильтр
        $query = $this->filter->apply($query, $request);

        // параметры пагинации
        $perPage = $request->input('per_page', 15);
        $page = $request->input('page', 1);

        // возвращаем пагинированный результат
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}