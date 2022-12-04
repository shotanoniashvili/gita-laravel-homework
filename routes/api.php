<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WallController;
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

Route::post('auth/register', [RegisterController::class, 'register'])->name('auth.register');
Route::post('auth/login', [LoginController::class, 'login'])->name('auth.login');

Route::get('wall/{username}', [WallController::class, 'wall']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('auth/verify/{id}/{hash}', [RegisterController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::get('auth/verify/resend', [RegisterController::class, 'resendVerification'])
        ->name('verification.send');
});
