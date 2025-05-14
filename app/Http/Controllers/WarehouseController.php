<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    /**
     * Просмотреть список складов
     */
    public function index()
    {
        $warehouses = Warehouse::all();
        return response()->json($warehouses);
    }
}