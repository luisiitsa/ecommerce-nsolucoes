<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::all();

    return view('app.home', ['products' => $products]);
})->name('app.home');

Route::get('/sales/{product}', function (Product $product) {
    return view('app.sale', compact('product'));
})->name('app.sales.product');

Route::get('/register', function () {
    return view('app.register');
})->name('app.register');
