<?php

namespace App\Http\Controllers\Form;

use Auth;
use Inertia\Inertia;
use App\Models\Form\Form;
use App\Models\Form\FormField;
use App\Models\Form\Submission;
use App\Models\Form\SubmissionField;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Inertia\Response;

class SubmissionFieldController extends Controller
{
    public function create(FormField $field, Submission $submission)
    {
        \Log::info('submissionField create method hit');
        $current_user = Auth::user();

        $submissionField = new SubmissionField();
        $submissionField->field()->associate($field);
        $submission->submissionFields()->save($submissionField);

        \Log::info('create method finished', $submissionField->toArray());
        return $submission;
    }


}