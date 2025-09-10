<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/clubs', function () {
    return view('clubs');
})->middleware(['auth', 'verified'])->name('clubs');

Route::get('/collections', function () {
    return view('collections');
})->middleware(['auth', 'verified'])->name('collections');

/**
 * Admin routes – tikai tiem, kam ir "admin" loma
 */
Route::get('/admin', function () {
    if (!Auth::user()?->hasRole('admin')) {
        abort(403);
    }
    return view('admin');
})->middleware('auth')->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', PostController::class);
});

require __DIR__.'/auth.php';
