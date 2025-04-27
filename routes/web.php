<?php

use App\Http\Controllers\Admin\CatatanTransaksiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserVerificationController;

use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ManageMenuController;
use App\Http\Controllers\Pegawai\MissController;
use App\Http\Controllers\Pegawai\PisgorController;
use App\Models\Category;
use App\Models\Transaksi;

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
    Route::get('/admin/miss/laporan', [CatatanTransaksiController::class, 'missView'])->name('admin.miss');
    Route::get('/admin/pisgor/laporan', [CatatanTransaksiController::class, 'pisgorView'])->name('admin.pisgor');

    // Management Users
    Route::post('/admin/unverify-users/{user}', [UserVerificationController::class, 'inverify'])->name('admin.inverify-user');
    Route::post('/admin/verify-users/{user}', [UserVerificationController::class, 'verify'])->name('admin.verify-user');
    Route::post('/admin/delete-users/{user}', [UserVerificationController::class, 'deleteUser'])->name('admin.delete-user');

    Route::get('/admin/manage-menu', [\App\Http\Controllers\ManageMenuController::class, 'index'])->name('admin.manage-menu');
    Route::post('/admin/menu/add', [ManageMenuController::class, 'store'])->name('admin.menu.add');
    Route::post('/admin/kategori/add', [ManageMenuController::class, 'categoryStore'])->name('admin.kategori.add');
    Route::post('/admin/ukuran/add', [ManageMenuController::class, 'ukuranStore'])->name('admin.ukuran.add');

    Route::get('/admin/kategori/by-business/{id}', [ManageMenuController::class, 'getKategoriByBusiness']);
});

Route::middleware(['auth'])->group(function () {

    Route::get('/pegawai/miss/home', [MissController::class, 'index'])->name('pegawai.miss.home');
    Route::get('/pegawai/pisgor/home', [PisgorController::class, 'index'])->name('pegawai.pisgor.home');

    Route::post('/pegawai/miss/keranjang/add', [MissController::class, 'addToCart'])->name('pegawai.miss.keranjang.add');
    Route::get('/pegawai/miss/keranjang', [MissController::class, 'viewCart'])->name('pegawai.miss.keranjang.view');
    Route::delete('/pegawai/keranjang/{id}', [MissController::class, 'removeFromCart'])->name('pegawai.keranjang.remove');
    Route::post('/pegawai/keranjang/checkout', [MissController::class, 'checkout'])->name('pegawai.keranjang.checkout');
    Route::get('/pegawai/miss/menu', [MissController::class, 'index'])->name('pegawai.miss.menu');
    Route::post('/pegawai/keranjang/update-quantity/{id}', [MissController::class, 'updateQuantity'])->name('pegawai.keranjang.updateQuantity');


    Route::post('/pegawai/pisgor/keranjang/add', [PisgorController::class, 'addToCart'])->name('pegawai.pisgor.keranjang.add');
    Route::get('/pegawai/pisgor/keranjang', [PisgorController::class, 'viewCart'])->name('pegawai.pisgor.keranjang.view');
    Route::delete('/pegawai/keranjang/{id}', [MissController::class, 'removeFromCart'])->name('pegawai.keranjang.remove');
    Route::post('/pegawai/keranjang/checkout', [MissController::class, 'checkout'])->name('pegawai.keranjang.checkout');
    Route::get('/pegawai/pisgor/menu', [PisgorController::class, 'index'])->name('pegawai.pisgor.menu');
    Route::post('/pegawai/keranjang/update-quantity/{id}', [PisgorController::class, 'updateQuantity'])->name('pegawai.keranjang.updateQuantity');
});




Route::get('/admin/transaksi/{id}', [CatatanTransaksiController::class, 'getTransaksiDetail'])->name('admin.transaksi.detail');



require __DIR__ . '/auth.php';
