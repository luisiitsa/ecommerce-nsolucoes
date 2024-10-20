<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('/customer/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('customer')->attempt($credentials)) {
        return redirect()->back();
    }

    return back()->withErrors([
        'credenciais' => 'As credenciais fornecidas não correspondem aos nossos registros.',
    ]);
})->name('app.customer.login');

Route::post('/customer/logout', function () {
    Auth::guard('customer')->logout();

    return redirect(route('app.home'));
})->name('app.customer.logout');
