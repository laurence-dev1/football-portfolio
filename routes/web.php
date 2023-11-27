<?php

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

Route::get('/matches/recent/', [MatchController::class, 'index']);
Route::get('/matches/{matchId}', [MatchController::class, 'show'])->whereNumber('matchId');
Route::get('/matches/filter', [MatchController::class, 'filter']);
