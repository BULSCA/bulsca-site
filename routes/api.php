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
    Route::get('articles', [\App\Http\Controllers\Api\V1\ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{slug}', [\App\Http\Controllers\Api\V1\ArticleController::class, 'show'])->name('articles.show');
    Route::post('client-errors', \App\Http\Controllers\Api\V1\ClientErrorController::class)
        ->withoutMiddleware('throttle:api')
        ->middleware(\App\Http\Middleware\ThrottleClientErrors::class);
});
