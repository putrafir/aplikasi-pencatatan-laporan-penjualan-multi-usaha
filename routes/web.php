<?php

use App\Http\Controllers\Admin\BusinessController;
use App\Models\Category;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ManageMenuController;
use App\Http\Controllers\ManageStockController;
use App\Http\Controllers\Pegawai\PisgorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CatatanTransaksiController;
use App\Http\Controllers\Admin\KelolaBisnisController;
use App\Http\Controllers\Admin\UserVerificationController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ManageCategoryController;
use App\Http\Controllers\Pegawai\KeranjangController;
use App\Http\Controllers\Pegawai\PegawaiTransaksiController;
use App\Http\Controllers\RiwayatStockController;
use App\Models\Menu;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

// Route::middleware('guest')->group(function () {
//     Route::get('/login', function () {
//         return view('auth.login');
//     });
// });


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['owner', 'auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('owner.dashboard');
    Route::get('/admin/verify-users', [UserVerificationController::class, 'index'])->name('admin.verify-users');
    Route::get('/admin/profile', [DashboardController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/miss/laporan', [CatatanTransaksiController::class, 'index'])->name('admin.miss');
    Route::get('/admin/kelola-bisnis', [KelolaBisnisController::class, 'index'])->name('admin.kelola-bisnis');
    Route::get('/admin/kelola-bisnis/{id}', [KelolaBisnisController::class, 'kelola'])->name('admin.kelola-bisnis.kelola');
    Route::get('/admin/pisgor/laporan', [CatatanTransaksiController::class, 'pisgorView'])->name('admin.pisgor');

    // Management Users
    Route::post('/admin/unverify-users/{user}', [UserVerificationController::class, 'inverify'])->name('admin.inverify-user');
    Route::post('/admin/verify-users/{user}', [UserVerificationController::class, 'verify'])->name('admin.verify-user');
    Route::post('/admin/delete-users/{user}', [UserVerificationController::class, 'deleteUser'])->name('admin.delete-user');
    Route::post('/admin/add-users', [UserVerificationController::class, 'addUser'])->name('admin.add-user');

    // Management Menu
    Route::get('/admin/manage-menu', [ManageMenuController::class, 'index'])->name('admin.manage-menu');
    Route::delete('/admin/menus/{id}', [ManageMenuController::class, 'destroy'])->name('admin.menus.destroy');
    Route::put('/admin/menus/{id}', [ManageMenuController::class, 'update'])->name('admin.menus.update');
    Route::post('/admin/menu/add', [ManageMenuController::class, 'store'])->name('admin.menu.add');

    // Management Kategori
    Route::get('/admin/manage-category', [CategoryController::class, 'index'])->name('admin.manage-category');
    Route::post('/admin/kategori/add', [ManageCategoryController::class, 'store'])->name('admin.category.add');
    Route::delete('/admin/kategori/{id}', [CategoryController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::put('/admin/kategori/{id}', [CategoryController::class, 'update'])->name('admin.kategori.update');
    Route::get('/admin/kategori/by-business/{id}', [ManageMenuController::class, 'getKategoriByBusiness']);

    // Management Size/Ukuran
    Route::get('/admin/manage-size', [SizeController::class, 'index'])->name('admin.manage-size');
    Route::post('/admin/ukuran/add', [SizeController::class, 'store'])->name('admin.ukuran.add');
    Route::delete('/admin/size/{id}', [sizeController::class, 'destroy'])->name('admin.size.destroy');
    Route::put('/admin/size/{id}', [SizeController::class, 'update'])->name('admin.size.update');

    // Management laporan
    Route::get('/admin/business/{id}/stocks', [LaporanController::class, 'getStocks']);
    Route::get('/admin/manage-stock', [ManageStockController::class, 'index'])->name('admin.manage-stock');
    Route::post('/admin/stock/add', [ManageStockController::class, 'store'])->name('admin.stock.add');
    Route::put('/admin/stock/{id}', [ManageStockController::class, 'update'])->name('admin.stock.update');
    Route::delete('/admin/stock/{id}', [ManageStockController::class, 'destroy'])->name('admin.stock.destroy');
    Route::get('/admin/laporan/{id}/detail', [LaporanController::class, 'detailLaporan'])->name('admin.laporan.detailLaporan');
    Route::get('/admin/laporan/pegawai/{id}', [LaporanController::class, 'laporanPegawai'])->name('admin.laporan.pegawai');

    //riwywatan stock
    Route::get('/admin/riwayat-stock', [RiwayatStockController::class, 'index'])->name('admin.riwayat-stock');

    // Management Jumlah Stock
    Route::get('/items/stock/add/jumlah-stock', [ManageStockController::class, 'addJumlahStok'])->name('admin.stock.add.jumlah_stok');
    Route::post('/items/stock/store/jumlah-stock', [ManageStockController::class, 'increaseStock'])->name('admin.stock.store.jumlah_stok');


    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/admin/laporan/data', [LaporanController::class, 'getData'])->name('laporan.data');
});


Route::middleware(['pegawai', 'auth'])->group(function () {
    Route::get('/pegawai/update_stoke', [\App\Http\Controllers\Pegawai\DashboardController::class, 'updetStok'])->name('pegawai.UpdetStok');
    Route::get('/pegawai/profile', [\App\Http\Controllers\Pegawai\DashboardController::class, 'profile'])->name('pegawai.profile');

    // Management Usaha Miss
    // Route::get('/pegawai/miss/home', [MissController::class, 'index'])->name('pegawai.miss.home');
    // Route::get('/pegawai/miss/get-categories/{superKategoriId}', [MissController::class, 'getCategories']);
    // Route::get('/pegawai/miss/get-menus/{kategoriId}', [MissController::class, 'getMenus']);
    // Route::get('/pegawai/miss/get-menus-super/{superKategoriId}', [MissController::class, 'getMenusBySuperKategori']);

    // Route::post('/pegawai/miss/keranjang/add', [MissController::class, 'addToCart'])->name('pegawai.miss.keranjang.add');
    // Route::get('/pegawai/miss/keranjang', [MissController::class, 'viewCart'])->name('pegawai.miss.keranjang.view');
    // Route::delete('/pegawai/keranjang/{id}', [MissController::class, 'removeFromCart'])->name('pegawai.keranjang.remove');
    // Route::post('/pegawai/miss/keranjang/checkout', [MissController::class, 'checkout'])->name('pegawai.miss.keranjang.checkout');
    // Route::post('/pegawai/miss/keranjang/update-quantity/{id}', [MissController::class, 'updateQuantity']);

    Route::post('/items/stock/store/input-sisa-stock', [ManageStockController::class, 'reduceStock'])->name('pegawai.update.stock');

    // Management Usaha Pisgor
    // Route::get('/pegawai/pisgor/home', [PisgorController::class, 'index'])->name('pegawai.pisgor.home');
    // Route::get('/pegawai/pisgor/get-menus/{kategoriId}', [PisgorController::class, 'getMenus']);
    // Route::get('/pegawai/pisgor/get-all-menus', [PisgorController::class, 'getAllMenusPisgor']);

    // Semua menu sesuai business pegawai login
    Route::get('/pegawai/get-all-menus', [PegawaiTransaksiController::class, 'getAllMenus']);

    // Menu berdasarkan kategori
    Route::get('/pegawai/get-menus/{categoryId}', [PegawaiTransaksiController::class, 'getMenus']);


    // Route::post('/pegawai/pisgor/keranjang/add', [PisgorController::class, 'addToCart'])->name('pegawai.pisgor.keranjang.add');
    // Route::get('/pegawai/pisgor/keranjang', [PisgorController::class, 'viewCart'])->name('pegawai.pisgor.keranjang.view');
    // Route::delete('/pegawai/keranjang/{id}', [PisgorController::class, 'removeFromCart'])->name('pegawai.keranjang.remove');
    // Route::post('/pegawai/pisgor/keranjang/checkout', [PisgorController::class, 'checkout'])->name('pegawai.pisgor.keranjang.checkout');
    // Route::post('/pegawai/pisgor/keranjang/update-quantity/{id}', [PisgorController::class, 'updateQuantity']);

    Route::get('/pegawai/transaksi', [PegawaiTransaksiController::class, 'index'])->name('pegawai.transaksi.index');
    Route::post('/pegawai/keranjang/add', [KeranjangController::class, 'addToCart'])->name('pegawai.keranjang.add');
    Route::post('/pegawai/keranjang/update-quantity/{id}', [KeranjangController::class, 'updateQuantity'])->name('pegawai.keranjang.update-quantity');
    Route::delete('/pegawai/keranjang/{id}', [KeranjangController::class, 'removeFromCart'])->name('pegawai.keranjang.remove');
    Route::get('/pegawai/keranjang', [KeranjangController::class, 'viewCart'])->name('pegawai.keranjang');
    Route::post('/pegawai/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('pegawai.keranjang.checkout');
});




Route::get('/admin/transaksi/{id}', [CatatanTransaksiController::class, 'getTransaksiDetail'])->name('admin.transaksi.detail');



require __DIR__ . '/auth.php';
