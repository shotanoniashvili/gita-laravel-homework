<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TweetController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function() {
    Route::get('/auth/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {
        Route::get('me', [UserController::class, 'me']);
        Route::get('me/following', [UserController::class, 'following']);
        Route::get('me/follows', [UserController::class, 'follows']);

        Route::group(['prefix' => 'tweets'], function() {
            Route::resource('/', TweetController::class)->only(['index', 'store', 'show']);

            Route::get('{tweet_id}/replies', [TweetController::class, 'replies']);
            Route::post('{tweet_id}/reply', [TweetController::class, 'storeReply']);

            Route::post('/{tweet_id}/like', [TweetController::class, 'like']);
            Route::delete('/{tweet_id}/unlike', [TweetController::class, 'unlike']);
        });
    });
});
