<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

Route::prefix('shop')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('shop.index');
    Route::get('/{product:slug}', [ProductController::class, 'show'])->name('shop.show');
});

/*
|--------------------------------------------------------------------------
| Cart Routes (no auth required so guests can browse)
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

/*
|--------------------------------------------------------------------------
| Auth Required Routes (Customers)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

    // Payment (Payhere)
    Route::get('/payment/{order}/pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/return', [PaymentController::class, 'return'])->name('payment.return');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

    // Test Payment Gateway (local simulation)
    Route::get('/payment/{order}/test', [PaymentController::class, 'testPage'])->name('payment.test');
    Route::post('/payment/{order}/test-process', [PaymentController::class, 'testProcess'])->name('payment.test.process');

    // Customer Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [DashboardController::class, 'orderShow'])->name('orders.show');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [DashboardController::class, 'profileUpdate'])->name('profile.update');
        Route::get('/wishlist', [DashboardController::class, 'wishlist'])->name('wishlist');
        Route::post('/wishlist/{product}', [DashboardController::class, 'wishlistToggle'])->name('wishlist.toggle');
        Route::post('/review/{product}', [DashboardController::class, 'storeReview'])->name('review.store');
    });

    // Breeze Profile Routes
    Route::get('/settings/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Payhere Notify (no CSRF — exempt in bootstrap/app.php)
|--------------------------------------------------------------------------
*/
Route::post('/payment/notify', [PaymentController::class, 'notify'])->name('payment.notify');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('home');

    // Products
    Route::resource('products', Admin\ProductController::class);

    // Categories
    Route::resource('categories', Admin\CategoryController::class);

    // Orders
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Contact Messages
    Route::get('/messages', [Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [Admin\ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');
    Route::patch('/messages/{message}/read', [Admin\ContactMessageController::class, 'markAsRead'])->name('messages.markAsRead');
});

require __DIR__.'/auth.php';
