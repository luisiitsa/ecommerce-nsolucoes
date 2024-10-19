<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'admin';
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', function () {
        if (auth()->user()->is_admin) {
            $users = User::whereNull('deleted_at')->get();
            return view('users.index', compact('users'));
        }
        return abort(403);
    });
});
