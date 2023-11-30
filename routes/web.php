<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Service\MatchController;
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
    Route::get('/', [DashboardController::class, 'index']);

    Route::delete('/logout', [LoginController::class, 'destroy']);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('/register', [RegisterController::class, 'store']);
});


Route::get('/search/{search?}', [\App\Http\Controllers\SearchController::class, 'index'])
    ->whereIn('search', ['teams', 'matches', 'competitions', 'persons']);

Route::controller(MatchController::class)->group(function () {
    Route::get('/matches/recent/', 'index');
    Route::get('/matches/{matchId}', 'show')->whereNumber('matchId');
    Route::get('/matches/filter', 'filter');
});
