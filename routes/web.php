<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Baris ini wajib ada!
use App\Http\Controllers\AdminController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::get('/petugas/dashboard', function () { return view('petugas.dashboard'); })->name('petugas.dashboard');
    Route::get('/pedagang/dashboard', function () { return view('pedagang.dashboard'); })->name('pedagang.dashboard');
    Route::get('/admin/data-kios', [AdminController::class, 'dataKios']);
    // CRUD Data Kios
    Route::post('/admin/data-kios/store', [AdminController::class, 'storeKios']);
    Route::put('/admin/data-kios/{id}', [AdminController::class, 'updateKios']);
    Route::delete('/admin/data-kios/{id}', [AdminController::class, 'destroyKios']);
    Route::put('/admin/data-kios/{id}/reset-password', [AdminController::class, 'resetPasswordKios']);
});     