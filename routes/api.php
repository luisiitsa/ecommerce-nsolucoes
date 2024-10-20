<?php

use App\Http\Middleware\AuthAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware([AuthAdmin::class, 'web'])->group(function () {
    Route::get('/users/{user}', function (User $user) {
        return response()->json($user);
    })->name('api.users.show');
});
