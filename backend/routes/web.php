<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\Web\DashBoardWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'ViewAuth']);
Route::get('/dashboard', [DashBoardWebController::class, 'viewDashBoard']);
