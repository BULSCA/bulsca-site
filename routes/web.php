<?php

use App\Http\Controllers\SeasonController;use Illuminate\Support\Facades\Route;

use App\Models\League;
use App\Models\Season;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/competitions', function () {
    return view('competitions.index', ['season' => Season::orderBy('to','desc')->first()]);
})->name('comps');

Route::get('/competitions/league', [SeasonController::class, 'currentSeason'])->name('league');
Route::get('/competitions/league/{sid}', [SeasonController::class, 'previousSeason'])->where('sid', '\d{4}\-\d{2}')->name('prev_season');