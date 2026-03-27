<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', PostController::class);

    Route::get('/admin', function () {
        Gate::authorize('is-admin');
        return "Welcome to the Admin Dashboard!";
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';

/*

    - Log in as **Author**: Verify they can edit their own posts but not others'.
    - Log in as **Admin**: Verify they can access an "Admin Only" section via Gate.
    - Log in as **Regular User**: Verify they can only view posts.

*/
