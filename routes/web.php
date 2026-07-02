<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\buyer\BuyerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\seller\SellerController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BuyerMiddleware;
use App\Http\Middleware\SellerMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//global functions
Route::post('/users/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
Route::post('/toggle-status', [UserController::class, 'toggleStatus']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    //  ADMIN ONLY ROUTES
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users.index');
        Route::put('admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    //  SELLER ONLY ROUTES
    Route::middleware([SellerMiddleware::class])->group(function () {
        Route::get('seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    });

    //  BUYER ONLY ROUTES
    Route::middleware([BuyerMiddleware::class])->group(function () {
        Route::get('buyer/dashboard', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
