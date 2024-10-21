<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\AppController::class, 'home'])->name('app.home');

Route::get('/sales/{product}', [\App\Http\Controllers\SalesController::class, 'show'])->name('app.sales.product');

Route::get('/register', [CustomerController::class, 'showRegistrationForm'])->name('app.register');
Route::post('/customers', [CustomerController::class, 'register'])->name('app.customers.store');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('app.customer.edit');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('app.customer.update');
Route::post('/customer/login', [CustomerController::class, 'login'])->name('app.customer.login');
Route::post('/customer/logout', [CustomerController::class, 'logout'])->name('app.customer.logout');

Route::get('/cart', [CartController::class, 'showCart'])->name('app.cart');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('app.cart.add');
Route::post('/cart/sale', [CartController::class, 'processSale'])->name('app.cart.sale');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('app.cart.remove');

Route::post('/order', [OrderController::class, 'store']);
