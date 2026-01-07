<?php

use App\Models\Products;

Route::get('/', function () {
    $products = Products::all();
    return view('welcome', compact('products'));
});

Route::get('/tentang-kami', function () {
    return view('about');
});

Route::get('/produk', [ProductsController::class, 'index']);

Route::get('/pingpong', function () {
    return view('games.pingpong');
});

Route::get('/dimzzsnake', function () {
    return view('games.dimzzsnake');
});

Route::view('/minigames', 'minigames')->name('minigames');

// Score & Coupon Generation
Route::post('/save-score', [ScoreMinigameController::class, 'store']);

// Coupon Routes
Route::post('/coupons/generate', [CouponController::class, 'generate'])->name('coupons.generate');
Route::get('/my-coupons', [CouponController::class, 'myCoupons'])->name('coupons.index');
Route::post('/coupons/validate', [CouponController::class, 'validate'])->name('coupons.validate');
Route::post('/coupons/apply', [CouponController::class, 'apply'])->name('coupons.apply');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

// Payment Routes
Route::get('/checkout', [PaymentController::class, 'showCheckout'])->name('checkout.show');
Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::get('/payment/check-status/{orderId}', [PaymentController::class, 'checkStatus'])->name('payment.checkStatus');
Route::get('/payment/success/{orderId}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Admin Routes
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCouponController;

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // Products
        Route::resource('products', AdminProductController::class)->names('admin.products');
        
        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::put('/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
        
        // Coupons
        Route::resource('coupons', AdminCouponController::class)->names('admin.coupons');
    });
});