<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Dashboard route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Customer CRUD
Route::resource('customers', CustomerController::class);

// Product CRUD
Route::resource('products', ProductController::class);
Route::post('products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.stock.update');

// Sales CRUD
Route::resource('sales', SalesController::class);
// Fetch customer's pre-selected product(s) for sales form
Route::get('sales/customer-products/{customer}', [SalesController::class, 'customerProducts'])
    ->name('sales.customer-products');
