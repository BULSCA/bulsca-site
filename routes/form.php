<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Form;
use App\Models\Submission;
use App\Http\Controllers\Form\FormController;
use App\Http\Controllers\Form\SubmissionController;


Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
Route::get('/forms/create', [FormController::class, 'create'])->name('forms.create');
Route::get('/forms/{form}/edit', [FormController::class, 'edit'])->name('forms.edit');
Route::put('/forms/{form}/edit', [FormController::class, 'update'])->name('forms.update');
Route::get('/forms/{form}/viewform', [FormController::class, 'viewform'])->name('forms.viewform');
Route::put('/forms/{form}/viewform/{submission}', [SubmissionController::class, 'submit'])->name('forms.createsubmission');
Route::get('/forms/{form}/viewform/{submission}', [FormController::class, 'viewformsubmission'])->name('forms.viewformsubmission');

Route::get('/forms/{form}/formjson', [FormController::class, 'jsonform'])->name('forms.json');
