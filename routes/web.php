<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ToppingController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Kasir\KasirDashboardController;
use App\Http\Controllers\Kasir\OrderController as KasirOrderController;
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

    Route::resources([
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'toppings' => ToppingController::class,
        'variants' => VariantController::class,
        'users' => UserController::class,
    ]);
 
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']); 
    
    
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::controller(SettingController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });
});


    Route::prefix('kasir')->name('kasir.')->middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('dashboard');

    Route::controller(KasirOrderController::class)->name('orders.')->group(function () {
        Route::get('/history', 'index')->name('index'); 
        Route::get('/pos', 'create')->name('create');
        Route::post('/pos', 'store')->name('store');
        Route::get('/transaction/{order}', 'show')->name('show');
        Route::get('/transaction/{order}/receipt', 'receipt')->name('receipt');
        Route::patch('/transaction/{order}/status', 'updateStatus')->name('updateStatus');
    });
});

    Route::prefix('pengguna')->name('pengguna.')->middleware(['auth', 'role:pengguna'])->group(function () {

    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{product}', [MenuController::class, 'show'])->name('menu.show');

    Route::get('/pesanan-saya', [PenggunaOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [PenggunaOrderController::class, 'show'])->name('orders.show');

    
    Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/add', 'add')->name('add');
        Route::patch('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'remove')->name('remove');
        Route::delete('/', 'clear')->name('clear');
    });
    
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
});

require __DIR__.'/auth.php';