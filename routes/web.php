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
use App\Http\Controllers\SERC\CasualtyController;
use App\Http\Controllers\SERC\SERCController;
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


// Route::get('/', function () {
// 
//     $nearComp = Competition::whereBetween(DB::raw('DATEDIFF(competitions.when, NOW())'), [-1, 7])->orderBy(DB::raw('DATEDIFF(competitions.when, NOW())'), 'desc')->first();
//     return view('index', ['nearComp' => $nearComp]);
// })->name('home');

Route::redirect('/', 'forms')->name('home');

Route::get('/freshers', function () {
    return view('freshers.index');
})->name('freshers');

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

Route::get('/competitions/championships/2025', function () {
    return view('competitions.championships.info-2025');
})->name('champs.2025');

Route::get('/competitions/league', [SeasonController::class, 'currentSeason'])->name('league');
Route::get('/competitions/league/{sid}', [SeasonController::class, 'previousSeason'])->where('sid', '\d{4}\-\d{2}')->name('prev_season');
Route::get('/competitions/previous-leagues', [SeasonController::class, 'previous'])->name('league.previous');

Route::get('/competitions/rlss', function () {
    return view('competitions.rlss');
})->name('rlss-comps');

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
Route::get('/resources/sercs', [SERCController::class, 'publicSERCs'])->name('resources.sercs');
Route::get('/resources/sercs/search', [SERCController::class, 'publicSearch'])->name('resources.sercs.search');
Route::get('/resources/sercs/{serc}', [SERCController::class, 'getSerc'])->name('resources.sercs.get');

Route::get('/resources/casualties', [CasualtyController::class, 'publicCasualties'])->name('resources.casualties');
Route::get('/resources/casualties/search', [CasualtyController::class, 'publicSearch'])->name('resources.casualties.search');
Route::get('/resources/casualties/{slug}', [CasualtyController::class, 'publicView'])->where('casualty', '([a-z]*[A-Z]*)*\.[0-9]*')->name('resources.casualties.get');

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

Route::get('/welfare/support-and-reporting', function () {
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
Route::post('/img-ck/upload', [ImageController::class, 'ckUpload'])->middleware(['auth'])->name('image.ck-upload');
Route::get('/img/{path}', [ImageController::class, 'get'])->where('path', '.*')->name('image');

Route::post('/university/updatePhoto', [UniversityController::class, 'updateUniPhoto'])->name('university.updatePhoto');


Route::namespace('Form')->group(function () {
    Route::get('forms/{form}/view', 'FormController@viewForm')->name('forms.view');
    Route::post('forms/{form}/responses', 'ResponseController@store')->name('forms.responses.store');
});

Route::middleware(['auth', 'verified'])->namespace('Form')->group(function () {
    //Form Routes
    Route::get('forms', 'FormController@index')->name('forms.index');
    Route::get('forms/create', 'FormController@create')->name('forms.create');
    Route::post('forms', 'FormController@store')->name('forms.store');
    Route::get('forms/{form}', 'FormController@show')->name('forms.show');
    Route::get('forms/{form}/edit', 'FormController@edit')->name('forms.edit');
    Route::put('forms/{form}', 'FormController@update')->name('forms.update');
    Route::delete('forms/{form}', 'FormController@destroy')->name('forms.destroy');

    Route::post('forms/{form}/draft', 'FormController@draftForm')->name('forms.draft');
    Route::get('forms/{form}/preview', 'FormController@previewForm')->name('forms.preview');
    Route::post('forms/{form}/open', 'FormController@openFormForResponse')->name('forms.open');
    Route::post('forms/{form}/close', 'FormController@closeFormToResponse')->name('forms.close');

    Route::post('forms/{form}/share-via-email', 'FormController@shareViaEmail')->name('form.share.email');
    Route::post('forms/{form}/form-availability', 'FormAvailabilityController@save')->name('form.availability.save');
    Route::delete('forms/{form}/form-availability/reset', 'FormAvailabilityController@reset')->name('form.availability.reset');

    //Form Field Routes
    Route::post('forms/{form}/fields/add', 'FieldController@store')->name('forms.fields.store');
    Route::post('forms/{form}/fields/delete', 'FieldController@destroy')->name('forms.fields.destroy');

    //Form Response Routes
    Route::get('forms/{form}/responses', 'ResponseController@index')->name('forms.responses.index');
    Route::get('forms/{form}/responses/download', 'ResponseController@export')->name('forms.response.export');
    Route::delete('forms/{form}/responses', 'ResponseController@destroyAll')->name('forms.responses.destroy.all');
    Route::delete('forms/{form}/responses/{response}', 'ResponseController@destroy')->name('forms.responses.destroy.single');

    //Form Collaborator Routes
    Route::post('forms/{form}/collaborators', 'CollaboratorController@store')->name('form.collaborators.store');
    Route::delete('forms/{form}/collaborators/{collaborator}', 'CollaboratorController@destroy')->name('form.collaborator.destroy');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';


Route::get('/editor', function () {
    return view('editor');
});
