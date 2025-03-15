<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product');
    Route::post('/products/{id}', [ProductController::class, 'store'])->name('store-product');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
