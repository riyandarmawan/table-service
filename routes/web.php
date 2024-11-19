<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/login', [UserController::class, 'login'])->name('login');
Route::post('/auth/login', [UserController::class, 'loginProcess']);
Route::get('/auth/logout', [UserController::class, 'logout']);
