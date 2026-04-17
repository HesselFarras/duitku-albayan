<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController; // Pastikan nama Controller sesuai
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Transaksi (Gunakan Resource agar Edit, Update, Delete otomatis terdaftar)
    // Kita pakai nama 'transaksi' supaya sinkron dengan view kamu
    Route::resource('transaksi', TransactionController::class);

    // 3. Fitur Lain (AI, Laporan, Kegiatan)
    Route::get('/ai-insight', function () {
        return view('ai.index');
    })->name('ai.index');

    Route::get('/laporan', function () {
        return view('reports.index');
    })->name('laporan.index');

    Route::get('/kegiatan', function () {
        return view('activities.index');
    })->name('activities.index');

    // 4. Categories
    Route::resource('categories', CategoryController::class);

    // 5. Profile Management
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';