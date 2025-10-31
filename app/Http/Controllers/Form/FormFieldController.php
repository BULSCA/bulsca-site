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
use App\Http\Controllers\Form\FormController;
use App\Http\Controllers\Form\SubmissionController;
use App\Http\Controllers\Form\SubmissionFieldController;

class FormFieldController extends Controller
{
    public function create(Form $form, FormSection $form_section)
    {
        $form_field = new FormField();
        $form_field->label = 'New Question';
        $form_field->type = 'text';
        $form_field->form()->associate($form);
        $form_section->fields()->save($form_field);

        return $form_field;
    }

}