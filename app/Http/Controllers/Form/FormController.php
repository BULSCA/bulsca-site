<?php

namespace App\Http\Controllers\Form;

use Auth;
use Inertia\Inertia;
use App\Models\Form\Form;
use App\Models\Form\FormSection;
use App\Models\Form\FormField;
use App\Models\Form\Submission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Form\FormFieldController;
use App\Http\Controllers\Form\FormSectionController;
use App\Http\Controllers\Form\SubmissionController;
use App\Http\Controllers\Form\SubmissionFieldController;
use Inertia\Response;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::with(['sections' => fn($q) => $q->orderBy('section_order')])
        ->latest()
        ->get(['id','status','code']);

        return Inertia::render('forms/Index', [
            'forms' => $forms->map(fn($f) => [
                'id' => $f->id,
                'code' => $f->code,
                'status' => $f->status,
                'title' => $f->title, // accessor applied
            ]),
        ]);
    }

    public function create()
    {
        $current_user = Auth::user();

        $form = new Form();
        $form->generateCode();
        $form->status = Form::STATUS_DRAFT;
        $form->title = 'Untitled Form';
        $current_user->forms()->save($form);

        app(FormSectionController::class)->create($form);

        return redirect()->route('forms.edit', $form);
    }

    public function edit(Form $form)
    {
        $data = $this->buildFormData($form);

        return Inertia::render('forms/FormBuilder', [
            'form' => $form,
            'data' => $data
        ]);
    }

    public function viewform(Form $form)
    {
        // if $form->requires_user is true, ensure user and check for previous submission.
        $current_user = Auth::user();

        // Check if user has any submissions for this form
        $submission = $current_user->submissions()->where('form_id', $form->id)->first();

        if (!$submission) {
            $submission_controller = new SubmissionController();
            $submission = $submission_controller->create($form);
            \Log::info('submission created', $submission->toArray());
        }
        else {
            \Log::info('submission fetched', $submission->toArray());
        }

        foreach ($form->fields as $field) {
            $submissionField = $submission->submissionFields()->where('form_field_id', $field->id)->first();
            if (!$submissionField) {
                $submission_field_controller = new SubmissionFieldController();
                $submissionField = $submission_field_controller->create($field, $submission);
                \Log::info('submission field created', $submissionField->toArray());
            }
            else {
                \Log::info('submission field fetched', $submissionField->toArray());
            }
        }

        return Inertia::render('forms/DynamicForm', [
            'form' => $form,
            'fields' => $form->fields,
            'submission' => $submission,
            'submissionFields' => $submission->submissionFields
        ]);
    }

    public function jsonform(Form $form)
    {
        $data = $this->buildFormData($form);
        return response()->json(['data' => $data]);
    }

    protected function buildFormData(Form $form)
    {
        // Return the form structure as JSON
        $form->load([
            'sections' => fn($q) => $q->orderBy('section_order'),
            'sections.fields' => fn($q) => $q->orderBy('field_order'),
        ]);

        $data = [];

        //$data['primary_color'] = $form->primary_color;
        //$data['secondary_color'] = $form->secondary_color;

        foreach ($form->sections as $i => $section) {
            $sectionKey = $i;

            $data[$sectionKey] = [
                'id' => $section->id,
                'titlesec' => [
                    'title' => $section->title,
                    'description' => $section->description,
                ],
                'fields' => $section->fields->map(fn($f) => [
                    'id' => $f->id,
                    'label' => $f->label,
                    'type' => $f->type,
                    'options' => $f->options,
                    'required' => (bool) $f->required,
                ])->values()->all(),
            ];
        }

        return  $data;
    }

    public function viewformsubmission(Form $form, Submission $submission)
    {
        return Inertia::render('forms/DynamicForm', [
            'form' => $form,
            'fields' => $form->fields,
            'submission' => $submission,
            'submissionFields' => $submission->submissionFields
        ]);
    }

    public function update(Request $request, Form $form): Response
    {
        \Log::info('Update method hit', $request->all());

        $validated = $request->validate([
            'data' => ['required', 'array', 'min:1'],
            'data.primary_color' => ['nullable', 'string', 'max:7'],
            'data.secondary_color' => ['nullable', 'string', 'max:7'],
            'data.*.id' => ['nullable', 'integer', 'exists:form_sections,id'],
            'data.*.titlesec' => ['required', 'array'],
            'data.*.titlesec.title' => ['required', 'string', 'max:55'],
            'data.*.titlesec.description' => ['nullable', 'string', 'max:1000'],
            'data.*.fields' => ['present', 'array'],
            'data.*.fields.*.id' => ['nullable', 'integer', 'exists:form_fields,id'],
            'data.*.fields.*.label' => ['required', 'string', 'max:255'],
            'data.*.fields.*.type' => ['nullable', 'string', 'in:text,textarea,multiplechoice'],
            'data.*.fields.*.options' => ['nullable', 'json'],
            'data.*.fields.*.required' => ['nullable', 'boolean'],

        ], [
            'data.*.titlesec.title.required' => 'Section title is required.',
            'data.*.titlesec.title.string' => 'Section title must be a string.',
            'data.*.titlesec.title.max' => 'Section title may not be greater than 55 characters.',
            'data.*.titlesec.description.string' => 'Section description must be a string.',
            'data.*.titlesec.description.max' => 'Section description may not be greater than 1000 characters.',
            'data.*.fields.*.label.required' => 'Field label is required.',
        ]);

        $sections = collect($validated['data']);
        $existingSectionIds = $form->sections()->pluck('id')->toArray();

        foreach ($sections as $i => $sectionData) {
            \Log::info('Updating section', ['section_index' => $i]);
            $titlesec = data_get($sectionData, 'titlesec', []);
            $title = data_get($titlesec, 'title', null);
            $description = data_get($titlesec, 'description', null);
            \Log::info('section data', $sectionData);
            \Log::info("title, {$title}");
            \Log::info("description, {$description}");

            if (isset($sectionData['id']) && in_array($sectionData['id'], $existingSectionIds)) {
                $section = $form->sections()->find($sectionData['id']);

                $section->update([
                    'title' => $title,
                    'description' => $description,
                    'section_order' => $i,
                ]);
            } else {
                $section = $form->sections()->create([
                    'title' => $title,
                    'description' => $description,
                    'section_order' => $i,
                ]);
                $existingSectionIds[] = $section->id;
            }
            $existingFieldIds = [];

            foreach ($sectionData['fields'] as $j => $fieldData) {
                \Log::info('Updating field', ['field_index' => $j]);
                \Log::info('field data', $fieldData);
                if (isset($fieldData['id'])) {
                    // Update existing field
                    $field = $section->fields()->find($fieldData['id']);
                    if ($field) {
                        $field->update([
                            'label' => $fieldData['label'],
                            'type' => $fieldData['type'] ?? 'text',
                            'options' => $fieldData['options'] ?? null,
                            'required' => $fieldData['required'] ?? false,
                            'field_order' => $j,
                        ]);
                        $existingFieldIds[] = $field->id;
                    }
                } else {
                    // Create new field
                    $newField = app(FormFieldController::class)->create($form, $section);
                    $newField->update([
                        'label' => $fieldData['label'],
                        'type' => $fieldData['type'] ?? 'text',
                        'options' => $fieldData['options'] ?? null,
                        'required' => $fieldData['required'] ?? false,
                        'field_order' => $j,
                    ]);
                    $existingFieldIds[] = $newField->id;
                }
            }
        }


        \Log::info('Update fields passed', $request->all());
    
        // Optionally delete fields that were removed in the frontend
        $form->fields()->whereNotIn('id', $existingFieldIds)->delete();

        \Log::info('Update deletefields passed', $request->all());
    
        //return back()->with('success', 'Form updated successfully.');
        //return back()->with('success', __('A reset link will be sent if the account exists.'));
        //return redirect()->route('forms.edit', $form->code)->with('success', 'Form updated successfully.');
        return Inertia::render('forms/FormBuilder', [
            'form' => $form->fresh(),
            'flash' => [
                'success' => 'Form updated successfully.',
            ],
        ]);

    }
    













    public function store(request $request)
    {
        $current_user = Auth::user();

        foreach ($request->fields as $field) {
            $form->fields()->create([
                'label' => $field['label'],
                'type' => $field['type'],
                'options' => $field['options'] ?? null,
                'required' => $field['required'] ?? false,
                'uuid' => (string) Str::uuid(),
            ]);
        }
    }

}