<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\OrderController as VendorOrderController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('vendor')
        ->name('vendor.')
        ->middleware(['role:vendor'])
        ->group(function () {
            Route::get('/pending', fn () => view('vendor.pending'))->name('pending');

            Route::middleware('vendor.approved')->group(function () {
                Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

                Route::get('/products', [VendorProductController::class, 'index'])->name('products.index');
                Route::get('/products/create', [VendorProductController::class, 'create'])->name('products.create');
                Route::post('/products', [VendorProductController::class, 'store'])->name('products.store');
                Route::get('/products/{product}/edit', [VendorProductController::class, 'edit'])->name('products.edit');
                Route::put('/products/{product}', [VendorProductController::class, 'update'])->name('products.update');
                Route::delete('/products/{product}', [VendorProductController::class, 'destroy'])->name('products.destroy');

                Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
                Route::patch('/order-items/{item}/status', [VendorOrderController::class, 'updateItemStatus'])->name('orders.update-item-status');
            });
        });

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:admin')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('/vendors', [AdminVendorController::class, 'index'])->name('vendors.index');
            Route::patch('/vendors/{vendor}/approve', [AdminVendorController::class, 'approve'])->name('vendors.approve');
            Route::patch('/vendors/{vendor}/reject', [AdminVendorController::class, 'reject'])->name('vendors.reject');

            Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

            Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
            Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
            Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
            Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

            Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
            Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
        });

    Route::get('/test-email', function () {
        Mail::raw('If you received this email, Bazaar mail is working!', function ($message) {
            $message->to('bazaar.bd.project@gmail.com')
                    ->subject('Bazaar Email Test');
        });

        return 'Email sent!';
    });
});
