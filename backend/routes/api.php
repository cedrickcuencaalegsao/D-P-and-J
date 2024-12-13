<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\API\AuthAPIController;
use App\Http\Controllers\Category\API\CategoryAPIController;
use App\Http\Controllers\Dashboard\API\DashboardAPIController;
use App\Http\Controllers\Product\API\ProductAPIController;
use App\Http\Controllers\Reports\API\ReportsAPIController;
use App\Http\Controllers\Sales\API\SalesAPIController;
use App\Http\Controllers\Stocks\API\StockAPIController;

Route::controller(AuthAPIController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->name('login');
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthAPIController::class, 'logout']);

    Route::get('/products', [ProductAPIController::class, 'getAll']);
    Route::get('/product/{product_id}', [ProductAPIController::class, 'getByProductID']);
    Route::post('/product/add', [ProductAPIController::class, 'addProduct']);
    Route::post('/product/updates', [ProductAPIController::class, 'updateProduct']);
    Route::get('/products/search', [ProductAPIController::class, 'searchProduct']);

    // Category API endpoints.
    Route::get('/categories', [CategoryAPIController::class, 'getAll']);
    Route::get('/category/{product_id}', [CategoryAPIController::class, 'getByProductID']);
    Route::get('/category/search', [CategoryAPIController::class, 'search']);
    Route::post('/category/edit', [CategoryAPIController::class, 'editCategory']);
    // Report API endpoints.
    Route::get('/reports', [ReportsAPIController::class, 'getALL']);
    // Sales API endpoints.
    Route::get('/sales', [SalesAPIController::class, 'getAll']);

    // Stocks API Endpoints.
    Route::post('/product/buy', [StockAPIController::class, 'buyProduct']);
    Route::get('/stocks', [StockAPIController::class, 'getAll']);
    Route::post('/restock', [StockAPIController::class, 'reStocks']);

    // Dashboard API endpoints.
    Route::get('/alldata', [DashboardAPIController::class, 'getAllData']);

    // serch api endpoints
    Route::get('/search', [DashBoardAPIController::class, 'search']);
});

Route::get('/images/{filename}', function ($filename) {
    return response()->file(public_path('images/' . $filename));
});
