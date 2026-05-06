<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;

// =============================================================
// 1. HALAMAN LOGIN (Akses Umum)
// =============================================================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// =============================================================
// 2. AREA ADMIN (Middleware: auth / Default Web Guard)
// =============================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Kelola Data Kios & Petugas
    Route::get('/admin/data-kios', [AdminController::class, 'dataKios']);
    Route::post('/admin/data-kios/store', [AdminController::class, 'storeKios']);
    Route::put('/admin/data-kios/{id}', [AdminController::class, 'updateKios']);
    Route::delete('/admin/data-kios/{id}', [AdminController::class, 'destroyKios']);
    Route::put('/admin/data-kios/{id}/reset-password', [AdminController::class, 'resetPasswordKios']);

    Route::post('/admin/data-petugas/store', [AdminController::class, 'storePetugas']);
    Route::put('/admin/data-petugas/{id}', [AdminController::class, 'updatePetugas']);
    Route::delete('/admin/data-petugas/{id}', [AdminController::class, 'destroyPetugas']);
    Route::put('/admin/data-petugas/{id}/reset-password', [AdminController::class, 'resetPasswordPetugas']);

    // Iuran & Laporan
    Route::get('/admin/kelola-iuran', [AdminController::class, 'kelolaIuran']);
    Route::get('/admin/laporan', [AdminController::class, 'laporan']);
    Route::post('/admin/iuran/update-tarif', [AdminController::class, 'updateTarif']);

    // Profil
    Route::get('/admin/profil', [AdminController::class, 'profil']);
    Route::put('/admin/profil/update', [AdminController::class, 'updateProfil']);
});

// =============================================================
// 3. AREA PETUGAS (Middleware: auth:petugas)
// =============================================================
Route::middleware(['auth:petugas'])->prefix('petugas')->group(function () {
    // Dashboard (PASTIKAN MENGARAH KE CONTROLLER)
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');

    // Penagihan
    Route::get('/penagihan', [PetugasController::class, 'penagihan']);
    Route::post('/penagihan/bayar', [PetugasController::class, 'prosesBayar']);
    Route::post('/penagihan/batal', [PetugasController::class, 'batalkanBayar']);
});
// routes/web.php

Route::middleware(['auth:petugas'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    Route::get('/penagihan', [PetugasController::class, 'penagihan']);
    Route::post('/penagihan/bayar', [PetugasController::class, 'prosesBayar']);

    // ROUTE BARU: Halaman Riwayat Setoran
    Route::get('/riwayat-setoran', [PetugasController::class, 'riwayatSetoran']);
});
// =============================================================
// 3. AREA PETUGAS (Gunakan Satu Grup Saja)
// =============================================================
Route::middleware(['auth:petugas'])->prefix('petugas')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');

    // Penagihan
    Route::get('/penagihan', [PetugasController::class, 'penagihan'])->name('petugas.penagihan');
    Route::post('/penagihan/bayar', [PetugasController::class, 'prosesBayar']);
    Route::post('/penagihan/batal', [PetugasController::class, 'batalkanBayar']);

    // Riwayat Setoran
    Route::get('/riwayat-setoran', [PetugasController::class, 'riwayatSetoran'])->name('petugas.riwayat_setoran');

    // Profil (Sudah diperbaiki jalurnya)
    Route::get('/profil', [PetugasController::class, 'profil'])->name('petugas.profil');
    Route::put('/profil/update', [PetugasController::class, 'updateProfil'])->name('petugas.update_profil');
});

// =============================================================
// 4. AREA PEDAGANG (Middleware: auth:pedagang)
// =============================================
Route::middleware(['auth:pedagang'])->prefix('pedagang')->group(function () {
    Route::get('/dashboard', function () {
        return view('pedagang.dashboard');
    })->name('pedagang.dashboard');
});
