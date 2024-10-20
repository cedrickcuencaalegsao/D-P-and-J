<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\API\ProductAPIController;
use App\Http\Controllers\Category\API\CategoryAPIController;
use App\Http\Controllers\Reports\API\ReportsAPIController;
use App\Http\Controllers\Sales\API\SalesAPIController;
use App\Http\Controllers\Stocks\API\StocksAPIController;

Route::get('/products', [ProductAPIController::class, 'getAll']);
Route::get('/categories', [CategoryAPIController::class, 'getAll']);
Route::get('/reports', [ReportsAPIController::class, 'getALL']);
Route::get('/sales', [SalesAPIController::class, 'getAll']);
Route::get('/stocks', [StocksAPIController::class, 'getAll']);
