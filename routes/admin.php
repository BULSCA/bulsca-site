<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'role:admin|super_admin'], 'prefix' => 'admin'], function() {

    Route::get('/', [AdminController::class, 'index'])->name('admin');

    // SEASONS 

    Route::get('/seasons', [AdminController::class, 'viewSeasons'])->name('admin.seasons');
    Route::get('/season/{season}', [AdminController::class, 'viewSeason'])->name('admin.season.view');

    Route::post('/season/{season}/edit', [SeasonController::class, 'update'])->name('admin.season.edit');

    // COMPETITIONS

    Route::get('/competitions', [AdminController::class, 'viewCompetitions'])->name('admin.competitions');
    Route::get('/competition/{competition}', [AdminController::class, 'viewCompetition'])->name('admin.competition.view');

    Route::post('/competition/{competition}/edit', [CompetitionController::class, 'update'])->name('admin.competition.edit');

    // UNIVERSITIES

    Route::get('/universities', [AdminController::class, 'viewUniversities'])->name('admin.universities');
    Route::get('/university/{university}', [AdminController::class, 'viewUniversity'])->name('admin.university.view');

    Route::post('/university/{university}/edit', [UniversityController::class, 'update'])->name('admin.university.edit');

    // USERS

    Route::get('/users', [AdminController::class, 'viewUsers'])->name('admin.users');

});