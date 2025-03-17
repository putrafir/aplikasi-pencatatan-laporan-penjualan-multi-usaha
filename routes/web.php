<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserVerificationController;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['owner', 'auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('owner.dashboard');
    Route::get('/admin/verify-users', [UserVerificationController::class, 'index'])->name('admin.verify-users');
    Route::get('/admin/profile', [DashboardController::class, 'profile'])->name('admin.profile');

    // Management Users
    Route::post('/admin/verify-users/{user}', [UserVerificationController::class, 'verify'])->name('admin.verify-user');
    Route::post('/admin/delete-users/{user}', [UserVerificationController::class, 'deleteUser'])->name('admin.delete-user');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pegawai/dashboard', [PegawaiDashboardController::class, 'index'])->name('pegawai.dashboard');
});

require __DIR__ . '/auth.php';
