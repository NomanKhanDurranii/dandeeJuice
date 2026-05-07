<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyOrdersController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/catering', [HomeController::class, 'catering'])->name('catering');
Route::get('/privacy-policy', fn () => view('privacy-policy'))->name('privacy-policy');
Route::get('/refund-policy', fn () => view('refund-policy'))->name('refund-policy');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('product.show');

// OTP Auth
Route::middleware('guest')->group(function () {
    Route::get('login', fn () => view('auth.login'))->name('login');
});

Route::post('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

// Profile completion (new users after first OTP login)
Route::middleware(['auth'])->group(function () {
    Route::get('complete-profile', fn () => view('auth.complete-profile'))->name('profile.complete');
});

// Checkout, Orders & Account (Phase 4+)
Route::middleware(['auth'])->group(function () {
    Route::get('checkout', fn () => view('checkout'))->name('checkout');
    Route::get('order/{id}', [OrderController::class, 'confirmation'])->name('order.confirmation');
    Route::get('my-orders', [MyOrdersController::class, 'index'])->name('my-orders');
    Route::get('dashboard', fn () => redirect()->route('my-orders'))->name('dashboard');
});
