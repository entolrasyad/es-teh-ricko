<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect()->route('menus.index'));
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/stock', [MenuController::class, 'index'])->name('stock.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');
    Route::get('/orders/{order}/receipt', [ReceiptController::class, 'show'])->name('orders.receipt');
     // Show stock list / edit page
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    // Handle the update
    Route::put('/stock/{menu}', [StockController::class, 'update'])->name('stock.update');
});