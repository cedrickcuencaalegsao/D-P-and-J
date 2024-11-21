<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\Web\CategoryWebController;
use App\Http\Controllers\Dashboard\Web\DashBoardWebController;
use App\Http\Controllers\Products\Web\ProductWebController;
use App\Http\Controllers\Sales\Web\SalesWebController;
use App\Http\Controllers\Stocks\Web\StocksWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'ViewAuth']);
Route::get('/dashboard', [DashBoardWebController::class, 'viewDashBoard']);
//Proucts.
Route::get('/products', [ProductWebController::class, 'index']);
//category
Route::get('/category', [CategoryWebController::class, 'index']);
//Sales.
Route::get('/sales', [SalesWebController::class, 'index']);
//Stocks.
Route::get('/stocks', [StocksWebController::class, 'index']);
