<?php

namespace App\Http\Controllers\Form;

use Auth;
use Inertia\Inertia;
use App\Models\Form\Form;
use App\Models\Form\FormField;
use App\Models\Form\Submission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Inertia\Response;

class SubmissionController extends Controller
{
    public function create(Form $form)
    {
        \Log::info('submission create method hit');
        $current_user = Auth::user();

        $submission = new Submission();
        $submission->generateCode();
        $submission->status = Submission::STATUS_DRAFT;
        $submission->form()->associate($form);
        $current_user->Submissions()->save($submission);

        \Log::info('create method finished', $submission->toArray());
        return $submission;
    }

    public function submit(Request $request, Form $form, Submission $submission): Response
    {
        \Log::info('submit method hit', $request->all());

        $request->validate([
            'submissionFields' => 'present|array'
        ]);
        \Log::info('Submit validate passed', $request->all());
        \Log::info('request->submissionFields', $request->submissionFields);
        \Log::info('submission before processing fields', $submission->toArray());
    
        $existingSubmissionFieldIds = [];
    
        foreach ($request->submissionFields as $submissionFieldData) {
            \Log::info('Processing submissionField data', $submissionFieldData);
            if (isset($submissionFieldData['id'])) {
                // Update existing field
                $submissionField = $submission->submissionFields()->find($submissionFieldData['id']);
                if ($submissionField) {
                    $submissionField->update([
                        'answer' => $submissionFieldData['answer'], // Ensure the value is JSON-encoded
                    ]);
                    \Log::info('Updated existing submissionField', $submissionField->toArray());
                    $existingSubmissionFieldIds[] = $submissionField->id;
                } else {
                    \Log::warning('SubmissionField not found for update', ['id' => $submissionFieldData['id']]);
                }
            } else {
                // Create new field
                $newsubmissionField = $submission->submissionFields()->create([
                    'submissionField' => $submissionFieldData['submissionField']['answer'],
                ]);
                \Log::info('Created new submissionField', $newsubmissionField->toArray());
                $existingSubmissionFieldIds[] = $newsubmissionField->id;
            }
        }
        \Log::info('Update fields passed');
    
        // Optionally delete fields that were removed in the frontend
        $submission->submissionFields()->whereNotIn('id', $existingSubmissionFieldIds)->delete();
        \Log::info('Update deletefields passed');
    
        //return back()->with('success', 'Form updated successfully.');
        //return back()->with('success', __('A reset link will be sent if the account exists.'));
        //return redirect()->route('forms.edit', $form->code)->with('success', 'Form updated successfully.');
        \Log::info('Submit method finished');
        return Inertia::render('forms/DynamicForm', [
            'form' => $form,
            'fields' => $form->fields,
            'submission' => $submission,
            'submissionFields' => $submission->submissionFields,
            'flash' => [
                'success' => 'Form updated successfully.',
            ],
        ]);

    }
    

}