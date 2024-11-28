<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\API\ProductAPIController;
use App\Http\Controllers\Category\API\CategoryAPIController;
use App\Http\Controllers\Dashboard\API\DashBoardAPIController;
use App\Http\Controllers\Reports\API\ReportsAPIController;
use App\Http\Controllers\Sales\API\SalesAPIController;
use App\Http\Controllers\Stocks\API\StocksAPIController;
use App\Http\Middleware\CheckApiAccess;
use App\Http\Controllers\Auth\API\AuthAPIController;
use App\Http\Controllers\Auth\AuthController;


//Authentication api.
Route::controller(AuthAPIController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->name('login');
    // Route::post('logout', 'logout');
});

// Products API endpoints.
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/products', [ProductAPIController::class, 'getAll']);
    Route::post('/logout', [AuthAPIController::class, 'logout']);

    // Route::get('/products', ProductAPIController::class, 'getAll');
});
// Route::get('/products', [ProductAPIController::class, 'getAll']);
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
Route::post('/product/buy', [StocksAPIController::class, 'buyProduct']);
Route::get('/stocks', [StocksAPIController::class, 'getAll']);
Route::post('/restock', [StocksAPIController::class, 'reStocks']);

// Dashboard API endpoints.
Route::get('/alldata', [DashBoardAPIController::class, 'getAllData']);

Route::get('/images/{filename}', function ($filename) {
    return response()->file(public_path('images/' . $filename));
});

// Route::middleware([CheckApiAccess::class])->group(function () {
//     Route::post('/login', [AuthAPIController::class, 'login']);
//     Route::middleware('auth:api')->group(function () {
//         Route::get('/user-profile', [AuthAPIController::class, 'profile']);
//     });
// });


// Route::post('/login', [AuthAPIController::class, 'login']);
// Route::post('/logout', [AuthAPIController::class, 'logout'])->middleware('auth:api');


// Route::middleware('api.auth')->group(function () {
//     Route::get('/user-profile', [AuthAPIController::class, 'profile']);
// });

Route::get('/search', [DashBoardAPIController::class, 'search']);
