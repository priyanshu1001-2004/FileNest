<?php

use App\Http\Controllers\admin\AdminController;
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


Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware([AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile.show');
    });

    Route::middleware([SellerMiddleware::class])->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [SellerProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile/update', [SellerProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware([BuyerMiddleware::class])->prefix('buyer')->name('buyer.')->group(function () {
        Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [BuyerProfileController::class, 'index'])->name('profile.index');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
