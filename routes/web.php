<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ToppingController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Kasir\KasirDashboardController;
use App\Http\Controllers\Kasir\OrderController as KasirOrderController;
use App\Http\Controllers\Pengguna\HomeController;
use App\Http\Controllers\Pengguna\MenuController;
use App\Http\Controllers\Pengguna\CartController;
use App\Http\Controllers\Pengguna\OrderController as PenggunaOrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('toppings', ToppingController::class);
    Route::resource('variants', VariantController::class);
    Route::resource('users', UserController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});

Route::prefix('kasir')->name('kasir.')->middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [KasirOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [KasirOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [KasirOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [KasirOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [KasirOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::patch('/orders/{order}/mark-as-paid', [KasirOrderController::class, 'markAsPaid'])->name('orders.markAsPaid');
    Route::get('/orders/{order}/receipt', [KasirOrderController::class, 'receipt'])->name('orders.receipt');
});

Route::prefix('pengguna')->name('pengguna.')->middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{product}', [MenuController::class, 'show'])->name('menu.show');
    Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::patch('/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/', [CartController::class, 'clear'])->name('clear');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });
    Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/orders', [PenggunaOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [PenggunaOrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';