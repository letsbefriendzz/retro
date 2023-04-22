<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\RetroSessionController;
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

Route::get('/', fn() => auth()->user());

Route::get('/{sessionSlug}', [RetroSessionController::class, 'show']);
Route::get('/snickers/snickers', [RetroSessionController::class, 'snickers']);

Route::apiResource('notes', NoteController::class);

Route::prefix('login')->group(function () { // todo restructure this grouping yuckiness
    Route::prefix('github')->group(function () {
        Route::get('/', [LoginController::class, 'redirectToProvider']);
        Route::get('callback', [LoginController::class, 'handleProviderCallback']);
    });
});
