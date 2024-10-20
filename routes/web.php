<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::all();

    return view('app.home', ['products' => $products]);
});

Route::get('/sales/{product}', function (Product $product) {
    return view('app.sale', compact('product'));
})->name('app.sales.product');
