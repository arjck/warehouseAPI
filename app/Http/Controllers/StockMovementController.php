<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovement;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::query();

        // Фильтры
        if ($request->has('warehouse_id')) {
            $query->where('warehouse_id', $request->input('warehouse_id'));
        }

        if ($request->has('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        if ($request->has('date_from')) {
            $query->where('created_at', '>=', $request->input('date_from'));
        }

        if ($request->has('date_to')) {
            $query->where('created_at', '<=', $request->input('date_to'));
        }

        // Пагинация
        $perPage = $request->input('per_page', 20);
        $movements = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($movements);
    }
}