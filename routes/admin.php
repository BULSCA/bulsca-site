<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SeasonController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'role:admin|super_admin'], 'prefix' => 'admin'], function() {

    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/seasons', [AdminController::class, 'viewSeasons'])->name('admin.seasons');
    Route::get('/season/{season}', [AdminController::class, 'viewSeason'])->name('admin.season.view');

    Route::post('/season/{season}/edit', [SeasonController::class, 'update'])->name('admin.season.edit');

});