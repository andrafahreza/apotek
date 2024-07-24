<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengaturanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('login', [FrontController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'auth'])->name('auth');

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name("logout");

    Route::middleware('notCustomer')->group(function() {
        Route::get('/home', [HomeController::class, 'home'])->name("home");

        Route::prefix("pembelian")->group(function() {
            Route::get('list/{search?}', [PembelianController::class, 'index'])->name("pembelian");
            Route::get('show/{id?}', [PembelianController::class, 'show'])->name("pembelian-show");
            Route::post('simpan/{id?}', [PembelianController::class, 'simpan'])->name("pembelian-simpan");
        });

        Route::prefix("pemasok")->group(function() {
            Route::get('list/{search?}', [PemasokController::class, 'index'])->name("pemasok");
            Route::get('show/{id?}', [PemasokController::class, 'show'])->name("pemasok-show");
            Route::post('simpan/{id?}', [PemasokController::class, 'simpan'])->name("pemasok-simpan");
            Route::post('hapus', [PemasokController::class, 'hapus'])->name("pemasok-hapus");
        });

        Route::prefix("obat")->group(function() {
            Route::get('list/{search?}', [ObatController::class, 'index'])->name("obat");
            Route::get('stok/{id?}', [ObatController::class, 'stok'])->name("obat-stok");
            Route::get('show/{id?}', [ObatController::class, 'show'])->name("obat-show");
            Route::post('simpan/{id?}', [ObatController::class, 'simpan'])->name("obat-simpan");
            Route::post('hapus', [ObatController::class, 'hapus'])->name("obat-hapus");
        });

        Route::prefix("pengaturan")->group(function() {
            Route::get('/', [PengaturanController::class, 'index'])->name("pengaturan");
            Route::post('simpan', [PengaturanController::class, 'simpan'])->name("pengaturan-simpan");
        });
    });
});
