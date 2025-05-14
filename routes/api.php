<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;

// Часть 1
Route::get('/warehouses', [WarehouseController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/orders', [OrderController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{order}', [OrderController::class, 'update']);
Route::post('/orders/{order}/complete', [OrderController::class, 'complete']);
Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel']);
Route::post('/orders/{order}/resume', [OrderController::class, 'resume']);

// Часть 2
Route::get('/stock-movements', [StockMovementController::class, 'index']);