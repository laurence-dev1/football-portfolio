<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']);

Route::get('/search/{search?}', [\App\Http\Controllers\SearchController::class, 'index'])
    ->whereIn('search', ['teams', 'matches', 'competitions', 'persons']);

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index');
    Route::post('/login', 'store');
    Route::delete('/logout', 'destroy');
});

Route::controller(MatchController::class)->group(function () {
    Route::get('/matches/recent/', 'index');
    Route::get('/matches/{matchId}', 'show')->whereNumber('matchId');
    Route::get('/matches/filter', 'filter');
});
