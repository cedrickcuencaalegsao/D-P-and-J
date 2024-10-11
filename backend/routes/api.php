<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Products\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/hello-world', function () {
    return response()->json("Hello World!");
});

Route::get('/getallusers', [AuthController::class, 'getAllUsers']);

Route::get('/getallproducts', [ProductController::class, 'getAllProdutcs']);
