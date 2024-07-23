<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PemasokController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('login', [FrontController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'auth'])->name('auth');

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name("logout");

    Route::middleware('notCustomer')->group(function() {
        Route::get('/home', [HomeController::class, 'home'])->name("home");

        Route::prefix("pemasok")->group(function() {
            Route::get('list/{search?}', [PemasokController::class, 'index'])->name("pemasok");
            Route::get('show/{id?}', [PemasokController::class, 'show'])->name("pemasok-show");
            Route::post('simpan/{id?}', [PemasokController::class, 'simpan'])->name("pemasok-simpan");
            Route::post('hapus', [PemasokController::class, 'hapus'])->name("pemasok-hapus");
        });
    });
});
