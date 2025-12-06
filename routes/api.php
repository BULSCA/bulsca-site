<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EntityController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\MembershipController;

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


Route::middleware('internal')->group(function () {
    Route::apiResource('entities', EntityController::class);
    Route::apiResource('organisations', OrganisationController::class);
    Route::apiResource('memberships', MembershipController::class);   
});   