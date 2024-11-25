<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/auth/login', [UserController::class, 'login'])->name('login');
Route::post('/auth/login', [UserController::class, 'loginProcess']);
Route::post('/auth/logout', [UserController::class, 'logout']);

Route::middleware('auth')->group(callback: function() {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/menu', [MenuController::class, 'index']);
    Route::post('/menu/create', [MenuController::class, 'store']);
    Route::get('/menu/choice/{id_menu}', [MenuController::class, 'choice']);
    Route::post('/menu/update/{id_menu}', [MenuController::class, 'update']);
    Route::post('/menu/delete/{id_menu}', [MenuController::class, 'destroy']);
});
