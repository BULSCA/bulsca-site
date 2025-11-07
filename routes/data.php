<?php

use Illuminate\Support\Facades\Route;

Route::get('/privacy-policy', function () {
    return view('data.privacy-policy');
})->name('privacy-policy');

Route::get('/data-deletion', function () {
    return view('data.data-deletion');
})->name('data-deletion');
