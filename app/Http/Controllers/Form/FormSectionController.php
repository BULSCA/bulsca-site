<?php

namespace App\Http\Controllers\Form;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Form\Form;
use App\Models\Form\FormSection;
use App\Models\Form\FormField;
use App\Models\Form\Submission;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Form\SubmissionController;
use App\Http\Controllers\Form\SubmissionFieldController;

class FormSectionController extends Controller
{
    public function create(Form $form)
    {
        $form_section = new FormSection();
        $form->sections()->save($form_section);
    }

}