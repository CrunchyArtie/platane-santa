<?php

use App\Helpers\Parameters;
use App\Http\Controllers\Api\ImageController;
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
        return $request->user()->load(['images', 'target.images']);
    });

    Route::controller(ImageController::class)->name('images')->group(function () {
        Route::post('/images', 'store');
        Route::delete('/images/{id}', 'destroy');
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

Route::get('/is-ready', function () {
    return response()->json(['is-ready' => Parameters::get('are_santa_ready')]);
});

Route::get('/is_registration_open', function () {
    return response()->json(['is_registration_open' => Parameters::get('is_registration_open')]);
});

