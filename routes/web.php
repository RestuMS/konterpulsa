<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- TAMBAHKAN INI (Import Controller Baru) ---
// Pastikan file controller-nya sudah dibuat ya (php artisan make:controller ...)
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Mengganti route '/' welcome menjadi redirect ke login
Route::get('/', fn() => redirect('/login'));

// SEMUA ROUTE YANG BUTUH LOGIN
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Common Routes
    Route::resource('products', ProductController::class);
    Route::get('/transactions/unpaid', [TransactionController::class, 'unpaid'])->name('transactions.unpaid'); // New Kasbon Route
    Route::resource('transactions', TransactionController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');

    // 🔐 KHUSUS ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Group khusus ROLE KASIR
    Route::middleware('role:kasir')->group(function () {
        Route::resource('expenses', ExpenseController::class);
    });
});

// 3. Route Profile Bawaan (Penting untuk Edit Profile/Password)
// Saya letakkan di luar 'active' middleware agar user masih bisa logout/edit profil meski tidak aktif, 
// tapi kalau mau dikunci juga, masukkan ke dalam group di atas.
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. File Auth Bawaan (Login, Register, dll)
require __DIR__.'/auth.php';