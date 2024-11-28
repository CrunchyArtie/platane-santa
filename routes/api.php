<?php

use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\QuestionController as ApiQuestionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user()->load(['images', 'target.images', 'questions']);
    });

    Route::controller(ImageController::class)->name('images')->group(function () {
        Route::post('/images', 'store');
        Route::delete('/images/{id}', 'destroy');
    });

    Route::controller(ApiQuestionController::class)->name('questions')->group(function () {
        Route::post('/questions/{question}/response', 'storeResponse');
    });
});

Route::controller(ImageController::class)->name('images')->group(function () {
    Route::get('/images/{id}', 'show');
});


Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);


Route::get('/is-ready', function () {
    return response()->json(['is-ready' => env('ARE_SANTA_READY')]);
});

Route::get('/is-registration-open', function () {
    return response()->json(['is-registration-open' => env('IS_REGISTRATION_OPEN')]);
});

Route::get('/is-image-mode-active', function () {
    return response()->json(['is-image-mode-active' => env('IS_IMAGE_MODE_ACTIVE')]);
});

Route::get('/santa-joke-target', function () {
    return response()->json(['santa-joke-target' => env('SANTA_JOKE_TARGET')]);
});

Route::get('/is-image-and-question-mode-active', function () {
    return response()->json(['is-image-and-question-mode-active' => env('IS_IMAGE_AND_QUESTION')]);
});

