<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiInsightController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK / UMUM (Bisa Diakses Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// Halaman Ringkasan Umum (Read-Only untuk Publik/Jamaah)
Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
Route::get('/laporan', [TransactionController::class, 'laporan'])->name('laporan.index');
Route::get('/kegiatan', [ActivityController::class, 'index'])->name('activities.index');


/*
|--------------------------------------------------------------------------
| 2. RUTE PROTECTED (Wajib Login - Khusus Operasional Pengurus)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // --- 🟢 SEKSI MUTASI INTERNAL KAS (ANTI TABRAKAN) ---
    // Wajib ditaruh DI ATAS Route::resource agar tidak tertukar dengan parameter {id}
    Route::get('/transaksi/mutasi', [TransactionController::class, 'mutasiCreate'])->name('transaksi.mutasi.create');
    Route::post('/transaksi/mutasi', [TransactionController::class, 'mutasiStore'])->name('transaksi.mutasi.store');

    // --- CRUD TRANSAKSI KAS ---
    // Mengamankan proses Create, Edit, Update, Delete transaksi keuangan
    Route::resource('transaksi', TransactionController::class)->except(['index']);

    // --- CRUD AGENDA KEGIATAN ---
    Route::prefix('kegiatan')->name('activities.')->group(function () {
        Route::get('/tambah', [ActivityController::class, 'create'])->name('create');
        Route::post('/simpan', [ActivityController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ActivityController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ActivityController::class, 'update'])->name('update');
        Route::delete('/{id}/hapus', [ActivityController::class, 'destroy'])->name('destroy');
    });

    // --- PENGELOLAAN MASTER KATEGORI TRANSAKSI ---
    Route::resource('categories', CategoryController::class);

    // --- FITUR AI INSIGHT (DIBERSIHKAN DARI DUPLIKASI) ---
    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('/', [AiInsightController::class, 'index'])->name('index');
        Route::post('/chat', [AiInsightController::class, 'chat'])->name('chat');
    });

    // --- MANAJEMEN PROFIL PENGURUS ---
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

});

/*
|--------------------------------------------------------------------------
| 3. RUTE OTENTIKASI BAWAAN (Breeze / Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';