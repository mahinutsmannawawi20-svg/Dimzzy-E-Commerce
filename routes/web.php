<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ScoreMinigameController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
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