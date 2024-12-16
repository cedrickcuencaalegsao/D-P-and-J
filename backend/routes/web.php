<?php

use App\Http\Controllers\Auth\WEB\AuthWEBController;
use App\Http\Controllers\Category\WEB\CategoryWEBController;
use App\Http\Controllers\Dashboard\WEB\DashboardWEBController;
use App\Http\Controllers\Product\WEB\ProductWEBController;
use App\Http\Controllers\Reports\WEB\ReportsWEBController;
use App\Http\Controllers\Sales\WEB\SalesWEBController;
use App\Http\Controllers\Stocks\WEB\StockWEBController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthWEBController::class, 'viewLogin'])->name('login');
    Route::post('/valdiatelogin', [AuthWEBController::class, 'validateLogin'])->name('validateLogin');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardWEBController::class, 'viewDashBoard']);
    //Proucts.
    Route::get('/products', [ProductWEBController::class, 'index'])->name('products');
    Route::post('/add/product', [ProductWEBController::class, 'addProduct'])->name('addProduct');
    Route::post('/update/product', [ProductWEBController::class, 'updateProduct'])->name('updateProduct');
    //category
    Route::get('/category', [CategoryWEBController::class, 'index'])->name('category');
    Route::post('/update/category', [CategoryWEBController::class, 'updateCategory'])->name('updateCategory');
    //Sales.
    Route::get('/sales', [SalesWEBController::class, 'index']);
    //Stocks.
    Route::get('/stocks', [StockWEBController::class, 'index'])->name('stocks');
    Route::post('/product/buy', [StockWEBController::class, 'buyProduct'])->name('buyProduct'   );
    Route::post('/update/stock', [StockWEBController::class, 'updateStock'])->name('updateStock');
    //Reports.
    Route::get('/reports', [ReportsWEBController::class, 'index'])->name('reports');
    //Logout.
    Route::get('/logout', [AuthWEBController::class, 'logout'])->name('logout');
});

Route::get('/images/{filename}', function ($filename) {
    return response()->file(public_path('images/' . $filename));
});
