<?php

use App\Http\Controllers\LogoutController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Models\Note;

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
Route::get('logout', [LogoutController::class, 'logout']);

Route::get('/{sessionSlug}', [SessionController::class, 'show']);
Route::get('/snickers/snickers', [SessionController::class, 'snickers']);

Route::apiResource('notes', NoteController::class);

Route::prefix('login')->group(function () { // todo restructure this grouping yuckiness
    Route::prefix('github')->group(function () {
        Route::get('/', [LoginController::class, 'redirectToProvider'])->name('login.github');
        Route::get('callback', [LoginController::class, 'handleProviderCallback'])
            ->name('login.github.callback');
    });
});

Route::get('/', fn() => auth()->user())->name('home');
