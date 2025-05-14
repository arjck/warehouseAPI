<?php

namespace App\DataFilters;

use Illuminate\Http\Request;
use App\Protocols\OrderFilterInterface;

class OrderFilter implements OrderFilterInterface
{
    /**
     * Фильтры (по статусу, покупателю, дате)
     */
    public function apply($query, Request $request)
    {
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('customer')) {
            $query->where('customer', 'like', '%' . $request->input('customer') . '%');
        }
        if ($request->has('created_after')) {
            $query->where('created_at', '>=', $request->input('created_after'));
        }
        if ($request->has('created_before')) {
            $query->where('created_at', '<=', $request->input('created_before'));
        }

        return $query;
    }
}