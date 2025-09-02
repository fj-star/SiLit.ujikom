<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\TreatmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//pelanggan admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('pelanggans', PelangganController::class);
});

//layanans admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('layanans', LayananController::class);
});

//treatmens
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('treatments', TreatmentController::class);
});

//transaksi

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('transaksi', TransaksiController::class);
});

Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth', 'role:pelanggan'])->get('/pelanggan/dashboard', [PelangganController::class, 'index'])->name('pelanggan.dashboard');

require __DIR__.'/auth.php';