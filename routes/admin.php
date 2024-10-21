<?php

use App\Exports\OrdersExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', [OrderController::class, 'index'])->name('admin.home');

Route::get('/login', [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware([AuthAdmin::class])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/products', function () {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    })->name('admin.products.index');

    Route::get('/products/create', function () {
        return view('admin.products.create');
    })->name('admin.products.create');

    Route::post('/products', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
            'length' => 'required|numeric',
            'weight' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index');
    })->name('admin.products.store');

    Route::get('/products/{product}/edit', function (Product $product) {
        return view('admin.products.edit', compact('product'));
    })->name('admin.products.edit');

    Route::put('/products/{product}', function (Request $request, Product $product) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
            'length' => 'required|numeric',
            'weight' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index');
    })->name('admin.products.update');

    Route::delete('/products/{product}', function (Product $product) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index');
    })->name('admin.products.destroy');
});

Route::get('/orders/{order}', function (Order $order) {
    return view('admin.orders.show', compact('order'));
})->name('admin.orders.show');

Route::get('/orders/export/{format}', function ($format) {
    $orders = Order::all();

    if ($format === 'excel') {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    } elseif ($format === 'pdf') {
        $pdf = Pdf::loadView('admin.orders.pdf', compact('orders'));
        return $pdf->download('orders.pdf');
    }

    return back();
})->name('admin.orders.export');
