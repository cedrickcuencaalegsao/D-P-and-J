<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Products\API\ProductAPIController;
use App\Http\Controllers\Products\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductAPIController::class, 'getAll']);
