<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users/{user}', function (User $user) {
        return response()->json($user);
    })->name('api.users.show');
});
