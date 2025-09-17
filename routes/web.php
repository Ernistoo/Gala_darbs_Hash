<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SubmissionVoteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::get('/admin', function () {
    if (!Auth::user()?->hasRole('admin')) {
        abort(403);
    }
    return view('admin');
})->middleware(['auth', 'verified'])->name('admin');

/*
|--------------------------------------------------------------------------
| Profile routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Posts routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);

    // Like/unlike
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/like', [PostController::class, 'unlike'])->name('posts.unlike');

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

/*
|--------------------------------------------------------------------------
| Collections routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::post('/collections/{collection}/add-post/{post}', [CollectionController::class, 'addPost'])->name('collections.addPost');
});

/*
|--------------------------------------------------------------------------
| Challenges routes
|--------------------------------------------------------------------------
*/
// Challenges index & show (public, bet var būt auth)
Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');

// Challenge submissions (auth required)
Route::middleware('auth')->group(function () {
    Route::post('/challenges/{challenge}/submit', [SubmissionController::class, 'store'])->name('submissions.store');

    // Šeit padod Challenge objektu index metodei
    Route::get('/challenges/{challenge}/submissions', [SubmissionController::class, 'index'])
        ->name('submissions.index');
});

Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');

Route::post('/submissions/{submission}/vote', [SubmissionVoteController::class, 'toggle'])
    ->middleware('auth')
    ->name('submissions.vote');

    Route::delete('/users/{user}', [UserProfileController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('users.destroy');

require __DIR__ . '/auth.php';
