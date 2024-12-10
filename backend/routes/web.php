<?php

use App\Http\Controllers\Auth\WEB\AuthWEBController;
use App\Http\Controllers\Category\WEB\CategoryWEBController;
use App\Http\Controllers\Dashboard\WEB\DashboardWEBController;
use App\Http\Controllers\Product\WEB\ProductWEBController;
use App\Http\Controllers\Sales\WEB\SalesWEBController;
use App\Http\Controllers\Stocks\WEB\StockWEBController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthWEBController::class, 'viewLogin'])->name('login');
Route::post('/valdiatelogin', [AuthWEBController::class, 'validateLogin'])->name('validateLogin');

Route::get('/dashboard', [DashboardWEBController::class, 'viewDashBoard']);
//Proucts.
Route::get('/products', [ProductWEBController::class, 'index']);
//category
Route::get('/category', [CategoryWEBController::class, 'index']);
//Sales.
Route::get('/sales', [SalesWEBController::class, 'index']);
//Stocks.
Route::get('/stocks', [StockWEBController::class, 'index']);
// });

Route::get('/images/{filename}', function ($filename) {
    return response()->file(public_path('images/' . $filename));
});
