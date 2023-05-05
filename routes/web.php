<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SessionController;
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

Route::prefix('login')->group(function () { // todo restructure this grouping yuckiness
    Route::prefix('github')->group(function () {
        Route::get('callback', [LoginController::class, 'handleProviderCallback'])
            ->name('login.github.callback');
        Route::get('/', [LoginController::class, 'redirectToProvider'])
            ->name('login.github');
    });
    Route::get('/', [LoginController::class, 'redirect'])
        ->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [LogoutController::class, 'logout']);

    Route::apiResource('columns', ColumnController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::apiResource('notes', NoteController::class)->only(['store', 'show', 'update', 'destroy']);

    Route::get('/{sessionSlug}', [SessionController::class, 'show']);

});

Route::get('/', [HomepageController::class, 'show'])->name('home');
