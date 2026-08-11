<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\ProductFreshnessChangeRequestController as AdminProductFreshnessChangeRequestController;

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
use App\Http\Controllers\Vendor\ProductFreshnessChangeRequestController as VendorProductFreshnessChangeRequestController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{product:slug}', [ProductController::class, 'show'])
    ->name('products.show');

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {


    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add/{product}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::patch('/cart/update/{product}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])
        ->name('cart.remove');

    Route::delete('/cart/clear', [CartController::class, 'clear'])
        ->name('cart.clear');

    Route::middleware('verified')->group(function () {

        Route::get('/checkout', [CheckoutController::class, 'show'])
            ->name('checkout.show');

        Route::post('/checkout', [CheckoutController::class, 'store'])
            ->name('checkout.store');

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');
    });



    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::prefix('vendor')
        ->name('vendor.')
        ->middleware(['role:vendor'])
        ->group(function () {


            Route::get('/pending', fn () => view('vendor.pending'))
                ->name('pending');

            Route::middleware(['verified', 'vendor.approved'])->group(function () {

                Route::get('/dashboard', [VendorDashboardController::class, 'index'])
                    ->name('dashboard');


                Route::get('/products', [VendorProductController::class, 'index'])
                    ->name('products.index');

                Route::get('/products/create', [VendorProductController::class, 'create'])
                    ->name('products.create');

                Route::post('/products', [VendorProductController::class, 'store'])
                    ->name('products.store');

                Route::get('/products/{product}/edit', [VendorProductController::class, 'edit'])
                    ->name('products.edit');

                Route::put('/products/{product}', [VendorProductController::class, 'update'])
                    ->name('products.update');

                Route::delete('/products/{product}', [VendorProductController::class, 'destroy'])
                    ->name('products.destroy');



                Route::post(
                    '/products/{product}/freshness-request',
                    [VendorProductFreshnessChangeRequestController::class, 'store']
                )->name('products.freshness-request.store');


                Route::get('/orders', [VendorOrderController::class, 'index'])
                    ->name('orders.index');

                Route::patch(
                    '/order-items/{item}/status',
                    [VendorOrderController::class, 'updateItemStatus']
                )->name('orders.update-item-status');
            });
        });


    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:admin')
        ->group(function () {


            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');


            Route::get('/vendors', [AdminVendorController::class, 'index'])
                ->name('vendors.index');

            Route::patch('/vendors/{vendor}/approve', [AdminVendorController::class, 'approve'])
                ->name('vendors.approve');

            Route::patch('/vendors/{vendor}/reject', [AdminVendorController::class, 'reject'])
                ->name('vendors.reject');



            Route::get('/categories', [AdminCategoryController::class, 'index'])
                ->name('categories.index');

            Route::post('/categories', [AdminCategoryController::class, 'store'])
                ->name('categories.store');

            Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])
                ->name('categories.update');

            Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])
                ->name('categories.destroy');


    

            Route::get('/products', [AdminProductController::class, 'index'])
                ->name('products.index');

            Route::post('/products', [AdminProductController::class, 'store'])
                ->name('products.store');

            Route::put('/products/{product}', [AdminProductController::class, 'update'])
                ->name('products.update');

            Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])
                ->name('products.destroy');



            Route::get('/orders', [AdminOrderController::class, 'index'])
                ->name('orders.index');

            Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])
                ->name('orders.update');


        
            Route::get(
                '/freshness-requests',
                [AdminProductFreshnessChangeRequestController::class, 'index']
            )->name('freshness-requests.index');

            Route::patch(
                '/freshness-requests/{freshnessRequest}/approve',
                [AdminProductFreshnessChangeRequestController::class, 'approve']
            )->name('freshness-requests.approve');

            Route::patch(
                '/freshness-requests/{freshnessRequest}/deny',
                [AdminProductFreshnessChangeRequestController::class, 'deny']
            )->name('freshness-requests.deny');
        });



    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })
        ->middleware('auth')
        ->name('verification.notice');


    Route::get('/email/verify/{id}/{hash}', function (
        EmailVerificationRequest $request
    ) {

        $request->fulfill();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'Your email has been verified successfully.'
            );
    })
        ->middleware(['auth', 'signed'])
        ->name('verification.verify');


    Route::post('/email/verification-notification', function (
        Request $request
    ) {

        $request->user()->sendEmailVerificationNotification();

        return back()->with(
            'success',
            'Verification email sent.'
        );
    })
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');
});