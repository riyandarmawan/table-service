<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;

Route::get('/auth/login', [UserController::class, 'login'])->name('login');
Route::post('/auth/login', [UserController::class, 'loginProcess']);
Route::post('/auth/logout', [UserController::class, 'logout']);

Route::middleware('auth')->group(callback: function() {
    // dashboard
    Route::get('/', [DashboardController::class, 'index']);

    // menu
    Route::get('/menu', [MenuController::class, 'index']);
    Route::post('/menu/create', [MenuController::class, 'store']);
    Route::get('/menu/choice/{id_menu}', [MenuController::class, 'choice']);
    Route::post('/menu/update/{id_menu}', [MenuController::class, 'update']);
    Route::post('/menu/delete/{id_menu}', [MenuController::class, 'destroy']);

    // pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::post('/pelanggan/create', [PelangganController::class, 'store']);
    Route::get('/pelanggan/choice/{id_menu}', [PelangganController::class, 'choice']);
    Route::post('/pelanggan/update/{id_menu}', [PelangganController::class, 'update']);
    Route::post('/pelanggan/delete/{id_menu}', [PelangganController::class, 'destroy']);
});
