<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::all(['name', 'price', 'image']);

    return view('app.home', ['products' => $products]);
});
