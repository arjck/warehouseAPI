<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Просмотреть список товаров с их остатками по складам
     */
    public function index()
    {
        $products = Product::with('stocks.warehouse')->get()->map(function ($product) {
            $stockData = $product->stocks->map(function ($stock) {
                return [
                    'warehouse' => $stock->warehouse->name,
                    'stock' => $stock->stock,
                ];
            });
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stocks' => $stockData,
            ];
        });
        return response()->json($products);
    }
}