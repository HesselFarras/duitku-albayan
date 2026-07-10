<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController; 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiInsightController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');

Route::get('/laporan', [TransactionController::class, 'laporan'])->name('laporan.index');

Route::get('/kegiatan', [ActivityController::class, 'index'])->name('activities.index');


// 2. Rute Autentikasi (Harus Login) - Khusus Operasional Pengurus / Admin DKM

Route::middleware(['auth'])->group(function () {

    // CRUD Transaksi
    Route::resource('transaksi', TransactionController::class)->except(['index']);

    // CRUD Agenda Kegiatan
    Route::prefix('kegiatan')->name('activities.')->group(function () {
        Route::get('/tambah', [ActivityController::class, 'create'])->name('create');
        Route::post('/simpan', [ActivityController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ActivityController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ActivityController::class, 'update'])->name('update');
        Route::delete('/{id}/hapus', [ActivityController::class, 'destroy'])->name('destroy');
    });

    // Fitur AI Insight Analisis Kas
    Route::get('/ai-insight', [AiInsightController::class, 'index'])->name('ai.index');


    // Pengelolaan Kategori Transaksi
    Route::resource('categories', CategoryController::class);

    // Manajemen Profil Pengurus
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

require __DIR__.'/auth.php';