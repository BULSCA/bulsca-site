<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\DashboardController;

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
    return view('competitions.index', ['season' => Season::where('from', '<=', now())->orderBy('to','desc')->first()]);
})->name('comps');

Route::get('/competitions/championships', [ChampionshipController::class, 'index'])->name('champs');

Route::get('/competitions/league', [SeasonController::class, 'currentSeason'])->name('league');
Route::get('/competitions/league/{sid}', [SeasonController::class, 'previousSeason'])->where('sid', '\d{4}\-\d{2}')->name('prev_season');

Route::Get('/get-involved', function () {
    return view('get-involved.index');
})->name('get-involved');

Route::Get('/get-involved/clubs', [ClubController::class, 'index'])->name('clubs');
Route::Get('/get-involved/clubs/create', function () {
    return view('get-involved.create');
})->name('create-club');
Route::Get('/get-involved/clubs/{cid}', [ClubController::class, 'get'])->where('cid', '([a-z]*[A-Z]*)*\.[0-9]*')->name('view-club');
Route::Get('/get-involved/clubs/{cid}/edit', [ClubController::class, 'edit'])->where('cid', '([a-z]*[A-Z]*)*\.[0-9]*')->name('edit-club');
Route::Post('/get-involved/clubs/{cid}/edit', [ClubController::class, 'update'])->where('cid', '([a-z]*[A-Z]*)*\.[0-9]*')->name('update-club');

Route::get('/resources', function () {
    return view('resources.index');
})->name('resources');
Route::get('/resources/governance', [ResourceController::class, 'governance'])->name('governance');
Route::get('/resources/view/{id}', [ResourceController::class, 'get'])->name('view-resource');
Route::post('/resources/upload', [ResourceController::class, 'upload'])->name('upload-resource');



Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/competitions/{cid}', [CompetitionController::class, 'view'])->name('lc-view');
Route::get('/competitions/{cid}/manage', [CompetitionController::class, 'manage'])->name('lc-manage');
Route::post('/competitions/{cid}/manage/upload-results', [CompetitionController::class, 'resultsUpload'])->name('lc-result-upload');
Route::get('/competitions/{cid}/manage/remove-results', [CompetitionController::class, 'resultsRemove'])->name('lc-result-remove');


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
