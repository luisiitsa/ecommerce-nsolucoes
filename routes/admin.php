<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'admin';
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', function () {
        if (auth()->user()->isAdmin()) {
            $users = User::whereNull('deleted_at')->get();
            return view('users.index', compact('users'));
        }
        return abort(403);
    });

    Route::get('/users/create', function () {
        if (auth()->user()->isAdmin()) {
            return view('users.create');
        }
        return abort(403);
    });

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
    });

    Route::get('/users/{id}/edit', function ($id) {
        if (auth()->user()->is_admin) {
            $user = User::findOrFail($id);
            return view('users.edit', compact('user'));
        }
        return abort(403);
    });

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
    });
});
