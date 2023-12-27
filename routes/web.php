<?php

use App\Http\Controllers\User\UserOAuthController;
use App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\Bookmark\BookmarkMatchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Service\MatchController;
use App\Http\Controllers\User\UserSettingsController;
use App\Http\Middleware\NotThirdPartyUser;
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

Route::middleware('auth')->group(function () {
    Route::delete('/logout', [UserLoginController::class, 'destroy']);

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/settings', [UserSettingsController::class, 'index']);
    Route::patch('/settings/info', [UserSettingsController::class, 'updateInfo']);
    Route::patch('/settings/password', [UserSettingsController::class, 'updatePassword'])->middleware(NotThirdPartyUser::class);

    Route::get('/bookmarks/matches', [BookmarkMatchController::class, 'index']);
    Route::post('/bookmarks/matches', [BookmarkMatchController::class, 'store']);
    Route::delete('/bookmarks/matches', [BookmarkMatchController::class, 'destroy']);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserLoginController::class, 'index'])->name('login');
    Route::post('/login', [UserLoginController::class, 'store']);

    Route::get('/register', [UserRegisterController::class, 'index']);
    Route::post('/register', [UserRegisterController::class, 'store']);

    Route::get('/oauth/{provider}', [UserOAuthController::class, 'login']);
    Route::get('/oauth/{provider}/callback', [UserOAuthController::class, 'callback']);
});


Route::get('/search/{search?}', [\App\Http\Controllers\SearchController::class, 'index'])
    ->whereIn('search', ['teams', 'matches', 'competitions', 'persons']);

Route::controller(MatchController::class)->group(function () {
    Route::get('/matches/recent/', 'index');
    Route::get('/matches/{matchId}', 'show')->whereNumber('matchId');
    Route::get('/matches/filter', 'filter');
});
