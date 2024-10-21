<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\AppController::class, 'home'])->name('app.home');

Route::get('/sales/{product}', [\App\Http\Controllers\SalesController::class, 'show'])->name('app.sales.product');

Route::get('/register', [CustomerController::class, 'showRegistrationForm'])->name('app.register');
Route::post('/customers', [CustomerController::class, 'register'])->name('app.customers.store');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('app.customer.edit');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('app.customer.update');
Route::post('/customer/login', [CustomerController::class, 'login'])->name('app.customer.login');
Route::post('/customer/logout', [CustomerController::class, 'logout'])->name('app.customer.logout');

Route::get('/cart', function () {
    $cart = session()->get('cart', []);

    return view('app.cart', compact('cart'));
})->name('app.cart');

Route::post('/cart/add', function (Request $request) {
    $cart = session()->get('cart', []);

    $productId = $request->input('product_id');
    $productName = $request->input('product_name');
    $productPrice = $request->input('product_price');
    $productWeight = $request->input('product_weight');
    $productLength = $request->input('product_length');
    $productHeight = $request->input('product_height');
    $productWidth = $request->input('product_width');

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity']++;
    } else {
        $cart[$productId] = [
            'name' => $productName,
            'price' => $productPrice,
            'weight' => $productWeight,
            'length' => $productLength,
            'height' => $productHeight,
            'width' => $productWidth,
            'quantity' => 1
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
})->name('app.cart.add');

Route::post('/cart/sale', function (Request $request) {
    $cart = session()->get('cart', []);

    $productId = $request->input('product_id');
    $productName = $request->input('product_name');
    $productPrice = $request->input('product_price');
    $productWeight = $request->input('product_weight');
    $productLength = $request->input('product_length');
    $productHeight = $request->input('product_height');
    $productWidth = $request->input('product_width');

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity']++;
    } else {
        $cart[$productId] = [
            'name' => $productName,
            'price' => $productPrice,
            'weight' => $productWeight,
            'length' => $productLength,
            'height' => $productHeight,
            'width' => $productWidth,
            'quantity' => 1
        ];
    }

    session()->put('cart', $cart);

    return redirect(route('app.cart'))->with('success', '');
})->name('app.cart.sale');

Route::post('/cart/remove', function (Request $request) {
    $cart = session()->get('cart', []);

    $productId = $request->input('product_id');

    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Produto removido do carrinho!');
})->name('app.cart.remove');
