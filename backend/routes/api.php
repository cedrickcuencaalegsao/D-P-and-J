<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\API\ProductAPIController;
use App\Http\Controllers\Category\API\CategoryAPIController;
use App\Http\Controllers\Reports\API\ReportsAPIController;
use App\Http\Controllers\Sales\API\SalesAPIController;
use App\Http\Controllers\Stocks\API\StocksAPIController;

// Products
Route::get('/products', [ProductAPIController::class, 'getAll']);
Route::get('/product/{product_id}', [ProductAPIController::class, 'getByProductID']);
Route::post('/product/add', [ProductAPIController::class, 'addProduct']);
Route::put('/product/update/{product_id}', [ProductAPIController::class, 'updateProduct']);

Route::get('/categories', [CategoryAPIController::class, 'getAll']);
Route::get('/reports', [ReportsAPIController::class, 'getALL']);
Route::get('/sales', [SalesAPIController::class, 'getAll']);
Route::get('/stocks', [StocksAPIController::class, 'getAll']);
