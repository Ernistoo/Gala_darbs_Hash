<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\{
    ProfileController,
    PostController,
    CollectionController,
    CommentController,
    ChallengeController,
    SubmissionController,
    UserProfileController,
    SubmissionVoteController,
    LeaderboardController,
    CategoryController,
    FriendshipController,
    NotificationController,
    GoogleController,
    SearchController,
    ChatController
};

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    if (!Auth::user()?->hasRole('admin')) {
        abort(403);
    }
    return view('admin');
})->middleware(['auth', 'verified', 'role:admin'])->name('admin');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/admin/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
    Route::delete('/admin/challenges/{challenge}', [ChallengeController::class, 'destroy'])->name('challenges.destroy');

    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);
    Route::get('/posts/category/{category}', [PostController::class, 'byCategory'])->name('posts.byCategory');
    Route::post('posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::delete('posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/pin', [CommentController::class, 'pin'])->name('comments.pin');
});

Route::middleware('auth')->group(function () {
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::get('/collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');
    Route::put('/collections/{collection}', [CollectionController::class, 'update'])->name('collections.update');
    Route::delete('/collections/{collection}', [CollectionController::class, 'destroy'])->name('collections.destroy');
    Route::post('/posts/{post}/add-to-collection', [CollectionController::class, 'addPost'])->name('collections.addPost');
    Route::post('/collections/{collection}/remove-post/{post}', [CollectionController::class, 'removePost'])->name('collections.removePost');
});

Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');

Route::middleware('auth')->group(function () {
    Route::post('/challenges/{challenge}/submit', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/challenges/{challenge}/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
});

Route::post('/challenges/{challenge}/close', [ChallengeController::class, 'close'])
    ->middleware(['auth', 'role:admin'])
    ->name('challenges.close');

Route::middleware('auth')->group(function () {
    Route::post('/friends/{user}/send', [FriendshipController::class, 'send'])->name('friends.send');
    Route::post('/friends/{friendship}/accept', [FriendshipController::class, 'accept'])->name('friends.accept');
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');
    Route::delete('/friends/{user}/remove', [FriendshipController::class, 'remove'])->name('friends.remove');
});

Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');
Route::delete('/users/{user}', [UserProfileController::class, 'destroy'])->middleware('auth')->name('users.destroy');

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/api/search', [SearchController::class, 'ajax'])->name('search.ajax');

Route::get('/mentions/search', [App\Http\Controllers\MentionController::class, 'search'])
    ->middleware('auth')
    ->name('mentions.search');

Route::post('/submissions/{submission}/vote', [SubmissionVoteController::class, 'toggle'])
    ->middleware('auth')
    ->name('submissions.vote');

Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::post('/posts/{post}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');

require __DIR__ . '/auth.php';
