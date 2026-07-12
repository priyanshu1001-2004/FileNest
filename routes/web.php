<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductFileController;
use App\Http\Controllers\Admin\SellerController as AdminSellerController;
use App\Http\Controllers\buyer\BuyerController;
use App\Http\Controllers\buyer\BuyerProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\seller\SellerController;
use App\Http\Controllers\seller\SellerProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BuyerMiddleware;
use App\Http\Middleware\SellerMiddleware;
use Illuminate\Support\Facades\Route;



// 1. Public Routes (Anyone can see these - Guest or Logged In)
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

//global functions
Route::post('/users/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
Route::post('/toggle-status', [UserController::class, 'toggleStatus']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('download/file/{file}', [ProductFileController::class, 'download'])->name('product.file.download');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware([AdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // DASHBOARD
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            // USERS MANAGEMENT
            Route::get('/users', [AdminController::class, 'users'])->name('users.index');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

            // PROFILE
            Route::get('/profile', [AdminController::class, 'profile'])->name('profile.show');

            // CATEGORIES - Full CRUD (Admin Setup)
            Route::resource('categories', CategoryController::class);

            // PRODUCTS - Admin Review Only (No Create/Edit)
            Route::resource('products', ProductController::class)->only(['index', 'show', 'destroy']);

            // Product Approval Routes
            Route::post('products/{product}/approve', [ProductController::class, 'approve'])->name('products.approve');
            Route::post('products/{product}/reject', [ProductController::class, 'reject'])->name('products.reject');
            Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');

            // PRODUCT ATTRIBUTES - Admin View Only (Read-Only)
            Route::get('products/{product}/attributes', [ProductAttributeController::class, 'index'])->name('products.attributes.index');

            // PRODUCT FILES - Admin View Only (Read-Only)
            Route::get('products/{product}/files', [ProductFileController::class, 'index'])->name('products.files.index');

            // SELLER MANAGEMENT - Admin Manage Sellers
            Route::resource('sellers', AdminSellerController::class)->only(['index', 'show']);

            Route::controller(AdminSellerController::class)
                ->prefix('sellers')
                ->name('sellers.')
                ->group(function () {
                    // Quick Fix - Create seller detail
                    Route::post('/{user}/create-detail', 'createDetail')->name('create-detail');

                    // Verification
                    Route::post('/{sellerDetail}/verify', 'verify')->name('verify');
                    Route::post('/{sellerDetail}/unverify', 'unverify')->name('unverify');

                    // Suspension
                    Route::post('/{sellerDetail}/suspend', 'suspend')->name('suspend');
                    Route::post('/{sellerDetail}/unsuspend', 'unsuspend')->name('unsuspend');

                    // Feature
                    Route::post('/{sellerDetail}/toggle-feature', 'toggleFeature')->name('toggle-feature');
                });
        });

    Route::middleware([SellerMiddleware::class])->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [SellerProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile/update', [SellerProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware([BuyerMiddleware::class])->prefix('buyer')->name('buyer.')->group(function () {
        Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [BuyerProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile/update', [BuyerProfileController::class, 'update'])->name('profile.update');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
