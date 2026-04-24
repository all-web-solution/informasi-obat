<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PemberianObatController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('pasiens', PasienController::class);
    Route::resource('obats', ObatController::class);
    Route::resource('pemberian_obats', PemberianObatController::class);

    Route::get('/get-obat-info/{id}', [PemberianObatController::class, 'getObatInfo'])
        ->name('obats.info');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

    Route::get('/cetak/pasien/{id}', [PasienController::class, 'cetak'])->name('pasiens.cetak');
    Route::get('/cetak/obat/{id}', [ObatController::class, 'cetak'])->name('obats.cetak');
    Route::get('/cetak/pemberian/{id}', [PemberianObatController::class, 'cetak'])->name('pemberian_obats.cetak');

    Route::get('/cetak/laporan-pasien', [LaporanController::class, 'cetakPasien'])->name('cetak.pasien');
    Route::get('/cetak/laporan-obat', [LaporanController::class, 'cetakObat'])->name('cetak.obat');
    Route::get('/cetak/laporan-pemberian', [LaporanController::class, 'cetakPemberian'])->name('cetak.pemberian');
    Route::get('/cetak/dashboard', [DashboardController::class, 'cetak'])->name('cetak.dashboard');
});
