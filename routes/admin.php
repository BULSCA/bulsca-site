<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'role:admin|super_admin'], 'prefix' => 'admin'], function() {

    Route::get('/', [AdminController::class, 'index']);

});