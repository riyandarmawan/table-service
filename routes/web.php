<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailPesananController;

Route::get('/auth/login', [UserController::class, 'login'])->name('login');
Route::post('/auth/login', [UserController::class, 'loginProcess']);
Route::post('/auth/logout', [UserController::class, 'logout']);

Route::middleware('auth')->group(callback: function() {
    // dashboard
    Route::get('/', [DashboardController::class, 'index']);

    // pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::post('/pelanggan/create', [PelangganController::class, 'store']);
    Route::get('/pelanggan/choice/{id_pelanggan}', [PelangganController::class, 'choice']);
    Route::post('/pelanggan/update/{id_pelanggan}', [PelangganController::class, 'update']);
    Route::post('/pelanggan/delete/{id_pelanggan}', [PelangganController::class, 'destroy']);
    Route::get('/api/pelanggan/get/{id_pelanggan}', [PelangganController::class, 'get']);

    // meja
    Route::get('/meja', [MejaController::class, 'index']);
    Route::post('/meja/create', [MejaController::class, 'store']);
    Route::get('/meja/choice/{id_meja}', [MejaController::class, 'choice']);
    Route::post('/meja/update/{id_meja}', [MejaController::class, 'update']);
    Route::post('/meja/delete/{id_meja}', [MejaController::class, 'destroy']);
    Route::get('/api/meja/get/{id_meja}', [MejaController::class, 'get']);

    // menu
    Route::get('/menu', [MenuController::class, 'index']);
    Route::post('/menu/create', [MenuController::class, 'store']);
    Route::get('/menu/choice/{id_menu}', [MenuController::class, 'choice']);
    Route::post('/menu/update/{id_menu}', [MenuController::class, 'update']);
    Route::post('/menu/delete/{id_menu}', [MenuController::class, 'destroy']);
    Route::get('/api/menu/get/{id_menu}', [MenuController::class, 'get']);

    // pesanan
    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::get('/pesanan/create', [PesananController::class, 'create']);
    Route::post('/pesanan/create', [PesananController::class, 'store']);
    Route::get('/pesanan/detail/{id_pesanan}', [PesananController::class, 'detail']);
    Route::post('/pesanan/update/{id_pesanan}', [PesananController::class, 'update']);
    Route::post('/pesanan/delete/{id_pesanan}', [PesananController::class, 'destroy']);
    Route::get('/api/pesanan/get/{id_pesanan}', [PesananController::class, 'get']);

    // detail pesanan
    Route::get('/api/detail-pesanan/choosen-menu/{id_pesanan}', [DetailPesananController::class, 'chosenMenu']);

    // pesanan
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/create', [TransaksiController::class, 'create']);
    Route::post('/transaksi/create', [TransaksiController::class, 'store']);
    Route::get('/transaksi/detail/{id_transaksi}', [TransaksiController::class, 'detail']);
    Route::post('/transaksi/update/{id_transaksi}', [TransaksiController::class, 'update']);
    Route::post('/transaksi/delete/{id_transaksi}', [TransaksiController::class, 'destroy']);
});
