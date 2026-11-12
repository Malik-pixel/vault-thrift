<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Public Storefront Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/tersimpan', [HomeController::class, 'saved'])->name('saved');
Route::get('/tersimpan/lookup', [HomeController::class, 'savedLookup'])->name('saved.lookup');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Products Management
        Route::get('/produk', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/produk/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/produk', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/produk/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/produk/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::patch('/produk/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::post('/produk/bulk', [AdminProductController::class, 'bulkAction'])->name('products.bulk');
        Route::delete('/produk/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/produk-export', [AdminProductController::class, 'exportCsv'])->name('products.export');

        // Orders & WA Log Management
        Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/poll', [AdminOrderController::class, 'poll'])->name('orders.poll');
        Route::post('/pesanan', [AdminOrderController::class, 'storeManual'])->name('orders.store');
        Route::post('/pesanan/{order}/confirm-paid', [AdminOrderController::class, 'confirmPaid'])->name('orders.confirm-paid');
        Route::patch('/pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/pesanan/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/pesanan-export', [AdminOrderController::class, 'exportCsv'])->name('orders.export');

        // Categories CRUD
        Route::get('/kategori', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/kategori', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/kategori/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/kategori/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Settings & Bank Accounts
        Route::get('/pengaturan', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/pengaturan', [SettingController::class, 'update'])->name('settings.update');
    });
});
