<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::post('search', [FrontController::class, 'search'])->name('search');
Route::get('login', [FrontController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'auth'])->name('auth');
Route::get('register', [FrontController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'regis'])->name('regis');

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name("logout");
    Route::get('/profile-customer', [FrontController::class, 'profile'])->name("profile-customer");
    Route::get('/pemesanan', [FrontController::class, 'pemesanan'])->name("pemesanan-customer");
    Route::post('/pemesanan', [FrontController::class, 'pemesanan_customer'])->name("pemesanan-customer-action");
    Route::get('/riwayat', [FrontController::class, 'riwayat'])->name("riwayat-pembelian-customer");
    Route::get('/beli/{id?}', [FrontController::class, 'beli'])->name("beli");
    Route::get('/pesan/{id?}', [FrontController::class, 'pesan'])->name("pesan");
    Route::post('/pembayaran-customer', [FrontController::class, 'pembayaran'])->name("pembayaran-customer");
    Route::post('profile-admin', [ProfileController::class, 'simpan_profile_admin'])->name("profile-admin-simpan");
    Route::post('profile-admin/ganti-password', [ProfileController::class, 'ganti_password'])->name("ganti-password");

    Route::get('lihat-obat/{id?}', [FrontController::class, 'lihat_obat'])->name("lihat-obat");
    Route::post('tambah-keranjang', [FrontController::class, 'tambah_keranjang'])->name("tambah-keranjang");
    Route::post('hapus-isi-keranjang', [FrontController::class, 'hapus_isi_keranjang'])->name("hapus-isi-keranjang");
    Route::get('isi-keranjang', [FrontController::class, 'lihat_keranjang'])->name("lihat-keranjang");
    Route::post('konfirmasi-pembelian', [FrontController::class, 'konfirmasi_pembelian'])->name("konfirmasi-pembelian");
    Route::get('cetak-struk/{id?}', [LaporanController::class, 'cetak_struk'])->name("cetak-struk");

    Route::middleware('notCustomer')->group(function() {
        Route::get('/home', [HomeController::class, 'home'])->name("home");

        Route::prefix("profile-admin")->group(function() {
            Route::get('/', [ProfileController::class, 'profile_admin'])->name("profile-admin");
        });

        Route::prefix("pembelian")->group(function() {
            Route::get('list/{search?}', [PembelianController::class, 'index'])->name("pembelian");
            Route::get('show/{id?}', [PembelianController::class, 'show'])->name("pembelian-show");
            Route::post('simpan/{id?}', [PembelianController::class, 'simpan'])->name("pembelian-simpan");
        });

        Route::prefix("penjualan")->group(function() {
            Route::get('/', [PenjualanController::class, 'index'])->name("penjualan");
            Route::post('/', [PenjualanController::class, 'jual'])->name("jual");
        });

        Route::prefix("transaksi")->group(function() {
            Route::get('pembelian/{search?}', [PenjualanController::class, 'transaksi_pembelian'])->name("transaksi-pembelian");
            Route::get('penjualan/{search?}', [PenjualanController::class, 'transaksi_penjualan'])->name("transaksi-penjualan");
        });

        Route::prefix("validasi-penjualan")->group(function() {
            Route::get('/', [PenjualanController::class, 'validasi_penjualan'])->name("validasi-penjualan");
            Route::post('tolak', [PenjualanController::class, 'validasi_tolak'])->name("validasi-tolak");
            Route::post('terima', [PenjualanController::class, 'validasi_terima'])->name("validasi-terima");
            Route::post('kemas', [PenjualanController::class, 'validasi_kemas'])->name("validasi-kemas");
            Route::post('antar', [PenjualanController::class, 'validasi_antar'])->name("validasi-antar");
        });

        Route::prefix("validasi-pemesanan")->group(function() {
            Route::get('/', [PemesananController::class, 'validasi_pemesanan'])->name("validasi-pemesanan");
            Route::post('tolak', [PemesananController::class, 'validasi_tolak'])->name("validasi-pemesanan-tolak");
            Route::post('terima', [PemesananController::class, 'validasi_terima'])->name("validasi-pemesanan-terima");

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
            Route::get('show-stok/{id?}', [ObatController::class, 'show_stok'])->name("obat-show-stok");
            Route::post('simpan/{id?}', [ObatController::class, 'simpan'])->name("obat-simpan");
            Route::post('hapus', [ObatController::class, 'hapus'])->name("obat-hapus");
        });

        Route::prefix("pengaturan")->group(function() {
            Route::get('/', [PengaturanController::class, 'index'])->name("pengaturan");
            Route::post('simpan', [PengaturanController::class, 'simpan'])->name("pengaturan-simpan");
        });

        Route::prefix("rekening")->group(function() {
            Route::get('/', [RekeningController::class, 'index'])->name("rekening");
            Route::get('show/{id?}', [RekeningController::class, 'show'])->name("rekening-show");
            Route::post('hapus', [RekeningController::class, 'hapus'])->name("rekening-hapus");
            Route::post('simpan/{id?}', [RekeningController::class, 'simpan'])->name("rekening-simpan");
        });

        Route::prefix("akun")->group(function() {
            Route::get('list/{search?}', [UserController::class, 'index'])->name("akun");
            Route::get('show/{id?}', [UserController::class, 'show'])->name("akun-show");
            Route::get('reset-password/{id?}', [UserController::class, 'reset'])->name("akun-reset");
            Route::post('hapus', [UserController::class, 'hapus'])->name("akun-hapus");
            Route::post('simpan/{id?}', [UserController::class, 'simpan'])->name("akun-simpan");
        });

        Route::prefix("laporan")->group(function() {
            Route::get('cetak-laporan/{from?}/{to?}/{jenis?}', [LaporanController::class, 'cetak'])->name("cetak-laporan");
            Route::get('data-obat', [LaporanController::class, 'obat'])->name("laporan-obat");
            Route::get('data-pembelian', [LaporanController::class, 'pembelian'])->name("laporan-pembelian");
            Route::get('data-penjualan', [LaporanController::class, 'penjualan'])->name("laporan-penjualan");
        });
    });
});
