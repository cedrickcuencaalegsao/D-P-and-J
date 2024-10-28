<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\API\ProductAPIController;
use App\Http\Controllers\Category\API\CategoryAPIController;
use App\Http\Controllers\Dashboard\API\DashBoardAPIController;
use App\Http\Controllers\Reports\API\ReportsAPIController;
use App\Http\Controllers\Sales\API\SalesAPIController;
use App\Http\Controllers\Stocks\API\StocksAPIController;

// Products API endpoints.
Route::get('/products', [ProductAPIController::class, 'getAll']);
Route::get('/product/{product_id}', [ProductAPIController::class, 'getByProductID']);
Route::post('/product/add', [ProductAPIController::class, 'addProduct']);
Route::put('/product/update/{product_id}', [ProductAPIController::class, 'updateProduct']);
Route::get('/products/search', [ProductAPIController::class, 'searchProduct']);

// Category API endpoints.
Route::get('/categories', [CategoryAPIController::class, 'getAll']);
Route::get('/category/{product_id}', [CategoryAPIController::class, 'getByProductID']);
Route::get('/category/search', [CategoryAPIController::class, 'search']);

// Report API endpoints.
Route::get('/reports', [ReportsAPIController::class, 'getALL']);
Route::get('/sales', [SalesAPIController::class, 'getAll']);
Route::get('/stocks', [StocksAPIController::class, 'getAll']);

// Dashboard API endpoints.
Route::get('/alldata', [DashBoardAPIController::class, 'getAllData']);
