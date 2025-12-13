<?php

use App\Http\Controllers\Organisation\OrganisationController;
use App\Http\Controllers\Organisation\OrganisationManagerController;
use App\Http\Controllers\Organisation\OrganisationCommitteeController;
use App\Http\Controllers\Organisation\OrganisationMemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Organisation Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('organisations')->name('organisations.')->group(function () {
    
    // Main organisation CRUD
    Route::get('/', [OrganisationController::class, 'index'])->name('index');
    Route::get('/create', [OrganisationController::class, 'create'])->name('create');
    Route::post('/', [OrganisationController::class, 'store'])->name('store');
    Route::get('/{id}', [OrganisationController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [OrganisationController::class, 'edit'])->name('edit');
    Route::put('/{id}', [OrganisationController::class, 'update'])->name('update');
    Route::delete('/{id}', [OrganisationController::class, 'destroy'])->name('destroy');
    
    // Manager management routes
    Route::prefix('{id}/managers')->name('managers.')->group(function () {
        Route::get('/', [OrganisationManagerController::class, 'index'])->name('index');
        Route::post('/', [OrganisationManagerController::class, 'store'])->name('store');
        Route::put('/{userId}', [OrganisationManagerController::class, 'update'])->name('update');
        Route::delete('/{userId}', [OrganisationManagerController::class, 'destroy'])->name('destroy');
    });
    
    // Committee management routes
    Route::prefix('{id}/committee')->name('committee.')->group(function () {
        Route::get('/', [OrganisationCommitteeController::class, 'index'])->name('index');
        
        // Committee position CRUD
        Route::post('/positions', [OrganisationCommitteeController::class, 'store'])->name('positions.store');
        Route::put('/positions/{positionId}', [OrganisationCommitteeController::class, 'update'])->name('positions.update');
        Route::delete('/positions/{positionId}', [OrganisationCommitteeController::class, 'destroy'])->name('positions.destroy');
        
        // Assign/remove members to positions
        Route::post('/positions/{positionId}/members', [OrganisationCommitteeController::class, 'assignMember'])->name('positions.members.assign');
        Route::delete('/positions/{positionId}/members/{userId}', [OrganisationCommitteeController::class, 'removeMember'])->name('positions.members.remove');
    });
    
    // Member management routes
    Route::prefix('{id}/members')->name('members.')->group(function () {
        Route::get('/', [OrganisationMemberController::class, 'index'])->name('index');
        Route::post('/', [OrganisationMemberController::class, 'store'])->name('store');
        Route::put('/{userId}', [OrganisationMemberController::class, 'update'])->name('update');
        Route::delete('/{userId}', [OrganisationMemberController::class, 'destroy'])->name('destroy');
    });
});