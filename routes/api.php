<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('uni-logo/{uni_name}', 'App\Http\Controllers\UniversityController@getLogo');

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('presentation', [\App\Http\Controllers\Api\V1\PresentationController::class, 'presentation']);
    Route::get('notice', [\App\Http\Controllers\Api\V1\PresentationController::class, 'notice']);
    Route::get('social/posts', [\App\Http\Controllers\Api\V1\PresentationController::class, 'social']);
    Route::get('clubs', [\App\Http\Controllers\Api\V1\PeopleController::class, 'clubs']);
    Route::get('clubs/{slug}', [\App\Http\Controllers\Api\V1\PeopleController::class, 'club']);
    Route::get('committees', [\App\Http\Controllers\Api\V1\PeopleController::class, 'committees']);
    Route::get('committees/{season}', [\App\Http\Controllers\Api\V1\PeopleController::class, 'committee']);
    Route::get('committees/{season}/members/{slug}', [\App\Http\Controllers\Api\V1\PeopleController::class, 'member']);
    Route::get('homepage/highlights', [\App\Http\Controllers\Api\V1\CompetitionController::class, 'highlights']);
    Route::get('competitions', [\App\Http\Controllers\Api\V1\CompetitionController::class, 'index']);
    Route::get('competitions/{slug}', [\App\Http\Controllers\Api\V1\CompetitionController::class, 'show']);
    Route::get('championships', [\App\Http\Controllers\Api\V1\CompetitionController::class, 'championships']);
    Route::get('championships/{year}', [\App\Http\Controllers\Api\V1\CompetitionController::class, 'championship']);
    Route::get('seasons', [\App\Http\Controllers\Api\V1\CompetitionController::class, 'seasons']);
    Route::get('seasons/{season}/standings', [\App\Http\Controllers\Api\V1\CompetitionController::class, 'standings']);
    Route::get('resource-pages', [\App\Http\Controllers\Api\V1\ResourceController::class, 'pages']);
    Route::get('resource-pages/{slug}', [\App\Http\Controllers\Api\V1\ResourceController::class, 'page']);
    Route::get('resources', [\App\Http\Controllers\Api\V1\ResourceController::class, 'index']);
    Route::get('resources/{id}', [\App\Http\Controllers\Api\V1\ResourceController::class, 'show']);
    Route::get('resources/{id}/access', [\App\Http\Controllers\Api\V1\ResourceController::class, 'access']);
    Route::get('resources/{id}/file', [\App\Http\Controllers\Api\V1\ResourceController::class, 'file'])->name('resources.file');
    Route::get('sercs', [\App\Http\Controllers\Api\V1\TrainingController::class, 'sercs']);
    Route::get('sercs/{slug}', [\App\Http\Controllers\Api\V1\TrainingController::class, 'serc']);
    Route::get('casualties', [\App\Http\Controllers\Api\V1\TrainingController::class, 'casualties']);
    Route::get('casualties/{slug}', [\App\Http\Controllers\Api\V1\TrainingController::class, 'casualty']);
    Route::get('contact/config', [\App\Http\Controllers\Api\V1\ContactController::class, 'config']);
    Route::post('contact/submissions', [\App\Http\Controllers\Api\V1\ContactController::class, 'submit'])->middleware('throttle:5,1,public-contact');
    Route::post('articles/{slug}/views', [\App\Http\Controllers\Api\V1\ArticleInteractionController::class, 'view'])->middleware('throttle:30,1,article-views');
    Route::post('articles/{slug}/ratings', [\App\Http\Controllers\Api\V1\ArticleInteractionController::class, 'rate'])->middleware('throttle:10,1,article-ratings');
    Route::get('articles', [\App\Http\Controllers\Api\V1\ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{slug}', [\App\Http\Controllers\Api\V1\ArticleController::class, 'show'])->name('articles.show');
    Route::post('client-errors', \App\Http\Controllers\Api\V1\ClientErrorController::class)
        ->withoutMiddleware('throttle:api')
        ->middleware(\App\Http\Middleware\ThrottleClientErrors::class);
});
