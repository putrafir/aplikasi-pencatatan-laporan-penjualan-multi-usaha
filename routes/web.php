<?php

use App\Models\Category;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ManageMenuController;
use App\Http\Controllers\ManageStokController;
use App\Http\Controllers\Pegawai\MissController;
use App\Http\Controllers\Pegawai\PisgorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CatatanTransaksiController;
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
    Route::get('/admin/miss/laporan', [CatatanTransaksiController::class, 'missView'])->name('admin.miss');
    Route::get('/admin/pisgor/laporan', [CatatanTransaksiController::class, 'pisgorView'])->name('admin.pisgor');

    // Management Users
    Route::post('/admin/unverify-users/{user}', [UserVerificationController::class, 'inverify'])->name('admin.inverify-user');
    Route::post('/admin/verify-users/{user}', [UserVerificationController::class, 'verify'])->name('admin.verify-user');
    Route::post('/admin/delete-users/{user}', [UserVerificationController::class, 'deleteUser'])->name('admin.delete-user');

    // Management Menu
    Route::get('/admin/manage-menu', [ManageMenuController::class, 'index'])->name('admin.manage-menu');
    Route::delete('/admin/menus/{id}', [ManageMenuController::class, 'destroy'])->name('admin.menus.destroy');
    Route::put('/admin/menus/{id}', [ManageMenuController::class, 'update'])->name('admin.menus.update');
    Route::post('/admin/menu/add', [ManageMenuController::class, 'store'])->name('admin.menu.add');

    // Management Kategori
    Route::get('/admin/manage-category', [CategoryController::class, 'index'])->name('admin.manage-category');
    Route::post('/admin/kategori/add', [ManageMenuController::class, 'categoryStore'])->name('admin.kategori.add');
    Route::delete('/admin/kategori/{id}', [CategoryController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::put('/admin/kategori/{id}', [CategoryController::class, 'update'])->name('admin.kategori.update');
    Route::get('/admin/kategori/by-business/{id}', [ManageMenuController::class, 'getKategoriByBusiness']);

    // Management Size/Ukuran
    Route::get('/admin/manage-size', [SizeController::class, 'index'])->name('admin.manage-size');
    Route::post('/admin/ukuran/add', [SizeController::class, 'store'])->name('admin.ukuran.add');
    Route::delete('/admin/size/{id}', [sizeController::class, 'destroy'])->name('admin.size.destroy');
    Route::put('/admin/size/{id}', [SizeController::class, 'update'])->name('admin.size.update');

    // Management Stock
    Route::get('/admin/manage-bahan', [ManageStokController::class, 'index'])->name('admin.manage-bahan');
    Route::delete('/admin/bahan/{id}', [ManageStokController::class, 'destroy'])->name('admin.bahan.destroy');
    Route::put('/admin/bahan/{id}', [ManageStokController::class, 'update'])->name('admin.bahan.update');
    Route::post('/admin/bahan/add', [ManageStokController::class, 'store'])->name('admin.bahan.add');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pegawai/update_stoke', [\App\Http\Controllers\Pegawai\DashboardController::class, 'UpdetStok'])->name('pegawai.UpdetStok');
    Route::get('/pegawai/profile', [\App\Http\Controllers\Pegawai\DashboardController::class, 'profile'])->name('pegawai.profile');
    // Route::get('/pegawai/miss/home', [MissController::class, 'index'])->name('pegawai.miss.home');
    
    // Management Usaha Miss
    Route::get('/pegawai/miss/home', [MissController::class, 'index'])->name('pegawai.miss.home');
    Route::get('/pegawai/miss/get-categories/{superKategoriId}', [MissController::class, 'getCategories']);
    Route::get('/pegawai/miss/get-menus/{kategoriId}', [MissController::class, 'getMenus']);
    Route::get('/pegawai/miss/get-menus-super/{superKategoriId}', [MissController::class, 'getMenusBySuperKategori']);

    Route::get('/pegawai/miss/keranjang', [MissController::class, 'viewCart'])->name('pegawai.miss.keranjang.view');
    Route::post('/pegawai/miss/keranjang/add', [MissController::class, 'addToCart'])->name('pegawai.miss.keranjang.add');
    Route::delete('/pegawai/keranjang/{id}', [MissController::class, 'removeFromCart'])->name('pegawai.keranjang.remove');
    Route::post('/pegawai/keranjang/checkout', [MissController::class, 'checkout'])->name('pegawai.keranjang.checkout');
    Route::post('/pegawai/keranjang/update-quantity/{id}', [MissController::class, 'updateQuantity'])->name('pegawai.keranjang.updateQuantity');
    
    // Management Usaha Pisgor
    Route::get('/pegawai/pisgor/home', [PisgorController::class, 'index'])->name('pegawai.pisgor.home');
    // Route::get('/pegawai/pisgor/get-menus', [PisgorController::class, 'getMenus']);
    // Route::post('/pegawai/pisgor/keranjang/add', [PisgorController::class, 'addToCart'])->name('pegawai.pisgor.keranjang.add');

    Route::get('/pegawai/pisgor/keranjang', [PisgorController::class, 'viewCart'])->name('pegawai.pisgor.keranjang.view');
    Route::post('/pegawai/pisgor/keranjang/add', [PisgorController::class, 'addToCart'])->name('pegawai.pisgor.keranjang.add');
    
    Route::post('/pegawai/keranjang/update-quantity/{id}', [PisgorController::class, 'updateQuantity'])->name('pegawai.keranjang.updateQuantity');
});




Route::get('/admin/transaksi/{id}', [CatatanTransaksiController::class, 'getTransaksiDetail'])->name('admin.transaksi.detail');



require __DIR__ . '/auth.php';
