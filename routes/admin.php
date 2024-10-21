<?php

use App\Exports\OrdersExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AuthAdmin;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', [OrderController::class, 'index'])->name('admin.home');

Route::get('/login', [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware([AuthAdmin::class])->group(function () {
    Route::get('/users', function (Request $request) {
        if (auth()->user()->isAdmin()) {
            $query = User::query();

            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            $users = $query->paginate(10);

            return view('admin.users.index', compact('users'));
        }
        return abort(403);
    })->name('admin.users.index');

    Route::get('/users/create', function () {
        if (auth()->user()->isAdmin()) {
            return view('admin.users.create');
        }
        return abort(403);
    })->name('admin.users.create');

    Route::post('/users', function (Request $request) {
        if (auth()->user()->isAdmin()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'cpf' => 'required|string|digits:11|unique:users,cpf',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            User::create([
                'name' => $request->name,
                'cpf' => $request->cpf,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect('/admin/users');
        }
        return abort(403);
    })->name('admin.users.store');

    Route::get('/users/{id}/edit', function ($id) {
        if (auth()->user()->is_admin) {
            $user = User::findOrFail($id);
            return view('admin.users.edit', compact('user'));
        }
        return abort(403);
    })->name('admin.users.edit');

    Route::put('/users/{id}', function (Request $request, $id) {
        if (auth()->user()->is_admin) {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'string|max:255',
                'cpf' => 'digits:11|unique:users,cpf,'.$user->id,
                'email' => 'string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'string|min:8|confirmed',
            ]);

            $user->update([
                'name' => $request->name,
                'cpf' => $request->cpf,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect('/admin/users');
        }
        return abort(403);
    })->name('admin.users.update');

    Route::delete('/users/{id}', function ($id) {
        if (auth()->user()->is_admin) {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect('admin/users');
        }
        return abort(403);
    })->name('admin.users.destroy');

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
