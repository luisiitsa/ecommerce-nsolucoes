<?php

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\AppController::class, 'home'])->name('app.home');

Route::get('/sales/{product}', [\App\Http\Controllers\SalesController::class, 'show'])->name('app.sales.product');

Route::get('/register', function () {
    return view('app.customers.register');
})->name('app.register');

Route::post('/customers', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'postal_code' => 'required|string|max:9',
        'address' => 'required|string|max:255',
        'number' => 'required|string|max:255',
        'complement' => 'nullable|string|max:255',
        'neighborhood' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:2',
        'cellphone' => 'required|string|max:15',
        'email' => 'required|email|unique:customers,email',
        'password' => 'required|string|min:6',
    ]);

    $validated['password'] = Hash::make($validated['password']);

    Customer::create($validated);

    return redirect('/');
});

Route::get('/customers/{customer}/edit', function (Customer $customer) {
    return view('app.customers.edit', ['customer' => $customer]);
})->name('app.customer.edit');

Route::put('/customers/{customer}', function (Request $request, Customer $customer) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'postal_code' => 'required|string|max:9',
        'address' => 'required|string|max:255',
        'number' => 'required|string|max:255',
        'complement' => 'nullable|string|max:255',
        'neighborhood' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:2',
        'cellphone' => 'required|string|max:15',
        'email' => 'required|email|unique:customers,email,' . $customer->id,
        'password' => 'nullable|string|min:6',
    ]);

    if ($request->filled('password')) {
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }

    $customer->update($validated);

    return redirect('/');
});

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
