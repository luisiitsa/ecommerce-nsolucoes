<?php

use App\Http\Middleware\AuthAdmin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    if (Auth::check()) {
        return view('admin.home');
    }
    return redirect('admin/login');
})->name('admin.home');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('admin/');
    }
    return view('admin.login');
})->name('admin.login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'login' => 'required|string',
        'password' => 'required|string',
    ]);

    $loginType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'cpf';

    $user = User::where($loginType, $credentials['login'])->first();

    if ($user && Hash::check($credentials['password'], $user->password)) {
        Auth::login($user);

        return redirect('admin/');
    }

    return back()->withErrors([
        'credenciais' => 'Credenciais inválidas.',
    ])->withInput();
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('admin/login');
});

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
