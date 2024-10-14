<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::controller(DashboardController::class)->name('dashboard')->group(function () {
        Route::get('/dashboard', 'index');
        Route::patch('/dashboard', 'update')->name('.update');
    });

    if(env('IS_SANTA_PANEL_ACCESSIBLE')) {
        Route::controller(SantasController::class)->name('santas')->group(function () {
            Route::get('/santas', 'index');
            Route::get('/shuffle', 'shuffle')->name('.shuffle');
        });
    }
});

