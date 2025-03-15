<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    Route::get('/product', [ProductController::class, 'create'])->name('create');
    Route::post('/product', [ProductController::class, 'store'])->name('create-product');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::patch('/product/{id}', [ProductController::class, 'update'])->name('edit-product');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('delete-product');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
