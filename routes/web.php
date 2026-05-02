<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
Route::middleware(['auth:petugas'])->prefix('petugas')->group(function () {
    // Pastikan mengarah ke PetugasController dan method dashboard
    Route::get('/petugas/dashboard', [PetugasController::class, 'dashboard'])->middleware('auth:petugas');
    Route::get('/penagihan', [PetugasController::class, 'penagihan']);
    Route::post('/penagihan/batal', [PetugasController::class, 'batalkanBayar']);

    // Jalur untuk mengeksekusi pembayaran (BARU)
    Route::post('/penagihan/bayar', [PetugasController::class, 'prosesBayar']);
});
Route::middleware(['auth:petugas'])->prefix('petugas')->group(function () {
    // HARUS SEPERTI INI:
    Route::get('/dashboard', [PetugasController::class, 'dashboard']);
});

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware(['auth:petugas'])->prefix('petugas')->group(function () {

    // Halaman Dashboard
    Route::get('/dashboard', [PetugasController::class, 'dashboard']);

    // Halaman Penagihan (BARU)
    Route::get('/penagihan', [PetugasController::class, 'penagihan']);

});
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');
    Route::get('/pedagang/dashboard', function () {
        return view('pedagang.dashboard');
    })->name('pedagang.dashboard');
    Route::get('/admin/data-kios', [AdminController::class, 'dataKios']);
    // CRUD Data Kios
    Route::post('/admin/data-kios/store', [AdminController::class, 'storeKios']);
    Route::put('/admin/data-kios/{id}', [AdminController::class, 'updateKios']);
    Route::delete('/admin/data-kios/{id}', [AdminController::class, 'destroyKios']);
    Route::put('/admin/data-kios/{id}/reset-password', [AdminController::class, 'resetPasswordKios']);
    // CRUD Data Petugas
    Route::post('/admin/data-petugas/store', [AdminController::class, 'storePetugas']);
    Route::put('/admin/data-petugas/{id}', [AdminController::class, 'updatePetugas']);
    Route::delete('/admin/data-petugas/{id}', [AdminController::class, 'destroyPetugas']);
    Route::put('/admin/data-petugas/{id}/reset-password', [AdminController::class, 'resetPasswordPetugas']);
    Route::get('/admin/kelola-iuran', [AdminController::class, 'kelolaIuran']);
    // Halaman Laporan Iuran
    Route::get('/admin/laporan', [AdminController::class, 'laporan']);
    // Halaman Profil Admin
    Route::get('/admin/profil', [AdminController::class, 'profil']);
    Route::put('/admin/profil/update', [AdminController::class, 'updateProfil']);

});