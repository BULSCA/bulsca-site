<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DynamicResourcePageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UniversityController;
use App\Models\League;
use App\Models\Season;
use App\Services\ImageService;

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
    return view('competitions.index', ['season' => Season::current()]);
})->name('comps');

Route::get('/competitions/championships', [ChampionshipController::class, 'index'])->name('champs');

Route::get('/competitions/league', [SeasonController::class, 'currentSeason'])->name('league');
Route::get('/competitions/league/{sid}', [SeasonController::class, 'previousSeason'])->where('sid', '\d{4}\-\d{2}')->name('prev_season');

Route::Get('/get-involved', function () {
    return view('get-involved.index');
})->name('get-involved');
Route::Get('/get-involved/committee', function () {
    return view('get-involved.committee');
})->name('get-involved.committee');

Route::Get('/get-involved/clubs', [ClubController::class, 'index'])->name('clubs');
Route::Get('/get-involved/clubs/create', function () {
    return view('get-involved.create');
})->name('create-club');
Route::Get('/get-involved/clubs/{cid}', [ClubController::class, 'get'])->where('cid', '([a-z]*[A-Z]*)*\.[0-9]*')->name('view-club');
Route::Get('/get-involved/clubs/{cid}/edit', [ClubController::class, 'edit'])->where('cid', '([a-z]*[A-Z]*)*\.[0-9]*')->name('edit-club');
Route::Post('/get-involved/clubs/{cid}/edit', [ClubController::class, 'update'])->where('cid', '([a-z]*[A-Z]*)*\.[0-9]*')->name('update-club');

Route::get('/resources', [DynamicResourcePageController::class, 'index'])->name('resources');
Route::get('/resources/{page}', [DynamicResourcePageController::class, 'view'])->name('resources.page.view');
Route::get('/resources/view/{id}', [ResourceController::class, 'get'])->name('view-resource');
Route::post('/resources/upload', [ResourceController::class, 'upload'])->name('upload-resource');

Route::get('/about', function () {
    return view('about.index');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('privacy');
Route::get('/terms-of-service', function () {
    return view('legal.cookies');
})->name('tos');
Route::get('/cookies', function () {
    return view('legal.cookies');
})->name('cookies');



Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/competitions/{cid}', [CompetitionController::class, 'view'])->name('lc-view');
Route::get('/competitions/{cid}/manage', [CompetitionController::class, 'manage'])->name('lc-manage');
Route::post('/competitions/{cid}/manage/upload-results', [CompetitionController::class, 'resultsUpload'])->name('lc-result-upload');
Route::get('/competitions/{cid}/manage/remove-results', [CompetitionController::class, 'resultsRemove'])->name('lc-result-remove');

Route::post('/img/upload', [ImageController::class, 'upload'])->middleware(['auth', 'role:admin|super_admin'])->name('image.upload');
Route::get('/img/{path}', [ImageController::class, 'get'])->where('path', '.*')->name('image');

Route::post('/university/updatePhoto', [UniversityController::class, 'updateUniPhoto'])->name('university.updatePhoto');


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';


Route::get('/editor', function () {
    return view('editor');
});
