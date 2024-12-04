<?php

use App\Http\Controllers\Auth\Web\AuthWEBController;
use App\Http\Controllers\Category\Web\CategoryWebController;
use App\Http\Controllers\Dashboard\Web\DashBoardWebController;
use App\Http\Controllers\Products\Web\ProductWebController;
use App\Http\Controllers\Sales\Web\SalesWebController;
use App\Http\Controllers\Stocks\Web\StocksWebController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {

    Route::get('/', [AuthWEBController::class, 'index'])->name('loginView');
    Route::post('check-login', [AuthWEBController::class, 'validateLogin'])->name('login-check');
});
Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashBoardWebController::class, 'viewDashBoard']);
    //Proucts.
    Route::get('/products', [ProductWebController::class, 'index']);
    //category
    Route::get('/category', [CategoryWebController::class, 'index']);
    //Sales.
    Route::get('/sales', [SalesWebController::class, 'index']);
    //Stocks.
    Route::get('/stocks', [StocksWebController::class, 'index']);
});

Route::get('/images/{filename}', function ($filename) {
    return response()->file(public_path('images/' . $filename));
});
