<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BigUpload;
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
use App\Models\Competition;
use App\Models\League;
use App\Models\Season;
use App\Services\ImageService;
use Carbon\Carbon;

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

    $nearComp = Competition::whereBetween(DB::raw('DATEDIFF(competitions.when, NOW())'), [-1, 7])->orderBy(DB::raw('DATEDIFF(competitions.when, NOW())'), 'desc')->first();



    return view('index', ['nearComp' => $nearComp]);
})->name('home');

Route::get('/competitions', function () {
    return view('competitions.index', ['season' => Season::current()]);
})->name('comps');

Route::get('/competitions/championships', [ChampionshipController::class, 'index'])->name('champs');
Route::get('/competitions/championships/2023', function () {
    return view('competitions.championships.info-2023');
})->name('champs.2023');

Route::get('/competitions/championships/2024', function () {
    return view('competitions.championships.info-2024');
})->name('champs.2024');

Route::get('/competitions/league', [SeasonController::class, 'currentSeason'])->name('league');
Route::get('/competitions/league/{sid}', [SeasonController::class, 'previousSeason'])->where('sid', '\d{4}\-\d{2}')->name('prev_season');
Route::get('/competitions/previous-leagues', [SeasonController::class, 'previous'])->name('league.previous');

Route::Get('/get-involved', function () {
    return view('get-involved.index');
})->name('get-involved');
Route::Get('/get-involved/committee', function () {

    $currentTime = Carbon::now()->timezone('Europe/London')->setHours(24)->setDate(0, 0, 0);

    $fourThirty = Carbon::now()->timezone('Europe/London')->setHours(24)->setMinutes(0)->setSeconds(0)->setDate(0, 0, 0);
    $fourThirtyFive = Carbon::now()->timezone('Europe/London')->setHours(24)->setMinutes(5)->setSeconds(0)->setDate(0, 0, 0);

    $isBetween = $currentTime->lessThan($fourThirtyFive) && $currentTime->greaterThan($fourThirty);

    return view('get-involved.committee', ['time' => $isBetween]);
})->name('get-involved.committee');

Route::Get('/get-involved/clubs', [ClubController::class, 'index'])->name('clubs');
Route::Get('/get-involved/clubs/create', function () {
    return view('get-involved.create');
})->name('create-club');
Route::Get('/get-involved/clubs/{cid}', [ClubController::class, 'get'])->where('cid', '([a-z]*[A-Z]*)*\.[0-9]*')->name('view-club');
Route::Get('/get-involved/clubs/{cid}/edit', [ClubController::class, 'edit'])->where('cid', '([a-z]*[A-Z]*)*\.[0-9]*')->name('edit-club');
Route::Post('/get-involved/clubs/{cid}/edit', [ClubController::class, 'update'])->where('cid', '([a-z]*[A-Z]*)*\.[0-9]*')->name('update-club');

Route::get('/resources/forms', function () {
    return view('resources.forms');
})->name('resources.forms');
Route::get('/resources', [DynamicResourcePageController::class, 'index'])->name('resources');
Route::get('/resources/{page}', [DynamicResourcePageController::class, 'view'])->name('resources.page.view');
Route::get('/resources/view/{id}', [ResourceController::class, 'get'])->name('view-resource');
Route::post('/resources/upload', [ResourceController::class, 'upload'])->name('upload-resource');
Route::get('/resources/search/{search}', [DynamicResourcePageController::class, 'search'])->middleware('throttle:10000,1')->name('resource-search');

Route::get('/about', function () {
    return view('about.index');
})->name('about');
Route::get('/about/records', function () {
    return view('about.records');
})->name('about.records');
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

Route::get('/settings', function () {
    return view('settings');
})->name('settings')->middleware('auth');


Route::get('/latest', [ArticleController::class, 'index'])->name('latest');
Route::get('/article/create', function () {
    return view('articles.create');
})->middleware(['auth', 'role:admin|super_admin|committee'])->name('article.create');
Route::post('/article/create', [ArticleController::class, 'create'])->middleware(['auth', 'role:admin|super_admin|committee'])->name('article.create.post');
Route::get('/article/{slug}/edit', [ArticleController::class, 'editView'])->middleware(['auth', 'role:admin|super_admin|committee'])->name('article.edit');
Route::post('/article/{slug}/edit', [ArticleController::class, 'edit'])->middleware(['auth', 'role:admin|super_admin|committee'])->name('article.edit.post');
Route::delete(('/article/{slug}/delete'), [ArticleController::class, 'delete'])->middleware(['auth', 'role:admin|super_admin|committee'])->name('article.delete');
Route::get('/article/{slug}', [ArticleController::class, 'view'])->name('article.view');

Route::post('/article/rating', [ArticleController::class, 'ratingChange'])->name('article.rating')->middleware('throttle:10,1');


// ========= WELFARE =========
Route::get('/welfare', function () {
    return view('welfare.index');
})->name('welfare');

Route::get('/welfare/help-and-reporting', function () {
    return view('welfare.help-and-reporting');
})->name('welfare.help-and-reporting');

Route::get('/welfare/inclusion-and-accessibility', function () {
    return view('welfare.inclusion-and-accessibility');
})->name('welfare.inclusion-and-accessibility');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/competitions/{cid}', [CompetitionController::class, 'view'])->name('lc-view');
Route::get('/competitions/{cid}/manage', [CompetitionController::class, 'manage'])->middleware(['auth'])->name('lc-manage');
Route::post('/competitions/{cid}/manage', [CompetitionController::class, 'update'])->middleware(['auth'])->name('lc-manage-update');
Route::post('/competitions/{cid}/manage/upload-results', [CompetitionController::class, 'resultsUpload'])->middleware(['auth'])->name('lc-result-upload');
Route::get('/competitions/{cid}/manage/remove-results', [CompetitionController::class, 'resultsRemove'])->middleware(['auth'])->name('lc-result-remove');
Route::post('/competitions/{cid}/manage/upload-pack', [CompetitionController::class, 'packUpload'])->middleware(['auth'])->name('lc-pack-upload');
Route::get('/competitions/{cid}/manage/remove-pack', [CompetitionController::class, 'packRemove'])->middleware(['auth'])->name('lc-pack-remove');

Route::post('/img/upload', [ImageController::class, 'upload'])->middleware(['auth', 'role:admin|super_admin'])->name('image.upload');
Route::get('/img/{path}', [ImageController::class, 'get'])->where('path', '.*')->name('image');

Route::post('/university/updatePhoto', [UniversityController::class, 'updateUniPhoto'])->name('university.updatePhoto');


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';


Route::get('/editor', function () {
    return view('editor');
});
