<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('uni-logo/{uni_name}', 'App\Http\Controllers\UniversityController@getLogo');

// Protected API routes with key validation
Route::middleware(['validate-api-key'])->group(function () {
    Route::get('/articles', [ArticleApiController::class, 'index'])->name('api.articles.index');
});
