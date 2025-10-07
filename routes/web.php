<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SubmissionVoteController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GoogleController;

use App\Http\Controllers\ChatController;
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

//Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Admin
Route::get('/admin', function () {
    if (!Auth::user()?->hasRole('admin')) {
        abort(403);
    }
    return view('admin');
})->middleware(['auth', 'verified'])->name('admin');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/admin/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
    Route::delete('/admin/challenges/{challenge}', [ChallengeController::class, 'destroy'])->name('challenges.destroy');
});

//Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Posts

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);

    Route::get('/categories/{category}', [PostController::class, 'byCategory'])->name('posts.byCategory');

    Route::post('posts/{post}/like', [PostController::class, 'like'])->name('posts.like')->middleware('auth');
Route::delete('posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike')->middleware('auth');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});


//Challenges
Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');

//Store challenge(auth)
Route::middleware('auth')->group(function () {
    Route::post('/challenges/{challenge}/submit', [SubmissionController::class, 'store'])->name('submissions.store');

    //padod challenge index
    Route::get('/challenges/{challenge}/submissions', [SubmissionController::class, 'index'])
        ->name('submissions.index');
});

//User profile show

Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');

//Submissions vote

Route::post('/submissions/{submission}/vote', [SubmissionVoteController::class, 'toggle'])
    ->middleware('auth')
    ->name('submissions.vote');

Route::delete('/users/{user}', [UserProfileController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('users.destroy');



Route::middleware('auth')->group(function () {
    //Collections index + store
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');

    //Uno collection
    Route::get('/collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');

    //Update delete
    Route::put('/collections/{collection}', [CollectionController::class, 'update'])->name('collections.update');
    Route::delete('/collections/{collection}', [CollectionController::class, 'destroy'])->name('collections.destroy');

    //Add/remove
    Route::post('/posts/{post}/add-to-collection', [CollectionController::class, 'addPost'])->name('collections.addPost');
    Route::post('/collections/{collection}/remove-post/{post}', [CollectionController::class, 'removePost'])->name('collections.removePost');
});

//Chat

Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);
});
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
});

//Leaderboard

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
require __DIR__ . '/auth.php';

//Comment

Route::post('/comments/{comment}/pin', [CommentController::class, 'pin'])->name('comments.pin');

Route::middleware('auth')->group(function () {
    Route::post('/friends/{user}/send', [FriendshipController::class, 'send'])->name('friends.send');
    Route::post('/friends/{friendship}/accept', [FriendshipController::class, 'accept'])->name('friends.accept');
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');
});



Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});


Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/mentions/search', [App\Http\Controllers\MentionController::class, 'search'])
    ->middleware('auth')
    ->name('mentions.search');