<?php

use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CategoryController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\DashboardController;
use App\Http\Controllers\Store\OrderController as DashboardOrderController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\SettingsController;
use App\Http\Controllers\Store\StorefrontController;
use App\Http\Controllers\Store\VoucherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| E-commerce by Conweb — Route Modul "Conweb Store"
|--------------------------------------------------------------------------
| Di-load dari bootstrap/app.php (closure `then`) dengan middleware `web`.
| Admin Conweb dikelola lewat Filament (App\Filament\Resources), bukan di sini.
*/

// ---------------------------------------------------------------------------
// Owner Dashboard — pemilik UMKM mengelola tokonya sendiri.
// Dijaga: login + email terverifikasi + memiliki toko (middleware store.owner).
// ---------------------------------------------------------------------------
Route::prefix('store-dashboard')->name('store-dashboard.')
    ->middleware(['auth', 'verified.otp', 'store.owner'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // Produk (Phase 3)
        Route::resource('products', ProductController::class)->except(['show']);

        // Kategori (Phase 3)
        Route::resource('categories', CategoryController::class)->except(['show']);

        // Pesanan (Phase 6) — owner tidak membuat order, hanya kelola.
        Route::get('orders', [DashboardOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [DashboardOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [DashboardOrderController::class, 'updateStatus'])->name('orders.status');

        // Voucher (Phase 6)
        Route::resource('vouchers', VoucherController::class)->except(['show']);

        // Pengaturan toko (Phase 2)
        Route::get('settings', [SettingsController::class, 'edit'])->name('settings');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    });

// ---------------------------------------------------------------------------
// Public Storefront — toko publik per UMKM.
// {store:slug} -> route key slug. {product:slug} scoped otomatis ke toko induk.
// Hanya toko aktif yang bisa diakses (dijaga di controller).
// ---------------------------------------------------------------------------
Route::prefix('store/{store:slug}')->name('store.')->scopeBindings()->group(function () {
    Route::get('/', [StorefrontController::class, 'home'])->name('home');
    Route::get('/products', [StorefrontController::class, 'products'])->name('products');
    Route::get('/products/{product:slug}', [StorefrontController::class, 'product'])->name('product');

    // Keranjang (session, tanpa login)
    Route::get('/cart', [CartController::class, 'show'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/voucher', [CartController::class, 'applyVoucher'])->name('cart.voucher');
    Route::delete('/cart/voucher', [CartController::class, 'removeVoucher'])->name('cart.voucher.remove');

    // Checkout via WhatsApp
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order-success/{orderCode}', [CheckoutController::class, 'success'])->name('order-success');
});
