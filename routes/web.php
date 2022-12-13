<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TweetLikeController;
use App\Http\Controllers\TweetReplyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TweetController;
use App\Models\User;
use App\Notifications\AggregatedWeeklyInformationNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/test', function() {
    $user = User::first();
    foreach ($user->notifications()->whereNull('read_at')->get() as $n) {
        dump($n->data);
    }
});


Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/', [TweetController::class, 'index'])->name('home');

    Route::group(['prefix' => 'tweets', 'as' => 'tweets.'], function() {
        Route::get('/saved', [TweetController::class, 'saved'])->name('saved');

        Route::post('/{id}/save', [TweetController::class, 'save'])->name('save');
        Route::post('/{id}/forget', [TweetController::class, 'forget'])->name('forget');

        Route::post('/{id}/like', [TweetLikeController::class, 'like'])->name('like');
        Route::post('/{id}/unlike', [TweetLikeController::class, 'unlike'])->name('unlike');

        Route::post('/{id}/reply', [TweetReplyController::class, 'reply'])->name('reply');

        Route::get('/', [TweetController::class, 'index'])->name('index');
        Route::get('/{id}', [TweetController::class, 'show'])->name('show');
        Route::post('/', [TweetController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TweetController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [TweetController::class, 'update'])->name('update');
        Route::delete('/{id}', [TweetController::class, 'destroy'])->name('destroy');
    });

    Route::get('/users/{id}/follow', [UserController::class, 'follow'])->name('users.follow');
    Route::get('/users/{id}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');

    Route::get('/profile', [UserController::class, 'me'])->name('me');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile/edit', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::get('/connections', [UserController::class, 'connections'])->name('my-connections');

    Route::get('/notifications/read/{id?}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

Route::get('/search', [UserController::class, 'search'])->name('search');
Route::get('/{username}', [UserController::class, 'profile'])->name('profile');

