<?php
namespace App\Http\Controllers\Form;

use App\Models\Form\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    /**
     * Display a listing of forms
     */
    public function index()
    {
        // Fetch forms with pagination, optionally filtered
        $forms = Form::latest()->paginate(10);

        return view('forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new form
     */
    public function create()
    {
        // Authorize form creation
        $this->authorize('create', Form::class);

        return view('forms.create');
    }

    /**
     * Store a newly created form
     */
    public function store(Request $request)
    {
        // Authorize form creation
        $this->authorize('create', Form::class);

        // Validate input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'close_date' => 'nullable|date|after:today',
            'is_user_response_required' => 'boolean'
        ]);

        // Add user_id if applicable
        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = 'draft';

        // Create the form
        $form = Form::create($validatedData);

        // Redirect to question creation
        return redirect()->route('forms.edit-questions', $form)
            ->with('success', 'Form created successfully');
    }

    /**
     * Display the specified form
     */
    public function show(Form $form)
    {
        // Authorize viewing
        $this->authorize('view', $form);

        // Load questions
        $form->load('questions');

        return view('forms.show', compact('form'));
    }

    /**
     * Show the form for editing form details
     */
    public function edit(Form $form)
    {
        // Authorize editing
        $this->authorize('update', $form);

        return view('forms.edit', compact('form'));
    }

    /**
     * Update the form
     */
    public function update(Request $request, Form $form)
    {
        // Authorize updating
        $this->authorize('update', $form);

        // Validate input
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'close_date' => 'nullable|date|after:today',
            'status' => 'in:draft,active,closed',
            'is_user_response_required' => 'boolean'
        ]);

        // Update the form
        $form->update($validatedData);

        return redirect()->route('forms.show', $form)
            ->with('success', 'Form updated successfully');
    }

    /**
     * Delete the form
     */
    public function destroy(Form $form)
    {
        // Authorize deletion
        $this->authorize('delete', $form);

        // Delete the form
        $form->delete();

        return redirect()->route('forms.index')
            ->with('success', 'Form deleted successfully');
    }

    /**
     * Show page to edit form questions
     */
    public function editQuestions(Form $form)
    {
        // Authorize question editing
        $this->authorize('update', $form);

        // Load existing questions
        $form->load('questions');

        return view('forms.edit-questions', compact('form'));
    }

    /**
     * Store a new question for the form
     */
    public function storeQuestion(Request $request, Form $form)
    {
        // Authorize question creation
        $this->authorize('update', $form);

        // Validate question input
        $validatedData = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:text,textarea,multiple_choice,checkbox,dropdown,date,number',
            'is_required' => 'boolean',
            'options' => 'nullable|array',
            'order' => 'nullable|integer'
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Determine the order of the question
            $lastOrder = $form->questions()->max('order') ?? 0;
            $validatedData['order'] = $validatedData['order'] ?? ($lastOrder + 1);

            // Create the question
            $question = $form->questions()->create([
                'question_text' => $validatedData['question_text'],
                'question_type' => $validatedData['question_type'],
                'is_required' => $validatedData['is_required'] ?? false,
                'order' => $validatedData['order'],
                'options' => !empty($validatedData['options']) 
                    ? json_encode($validatedData['options']) 
                    : null
            ]);

            // Commit the transaction
            DB::commit();

            // Redirect back with success message
            return back()->with('success', 'Question added successfully');
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            // Log the error
            \Log::error('Question creation failed: ' . $e->getMessage());

            // Redirect back with error message
            return back()->withErrors(['error' => 'Failed to add question: ' . $e->getMessage()]);
        }
    }

    /**
     * Update an existing question
     */
    public function updateQuestion(Request $request, Form $form, $questionId)
    {
        // Authorize question update
        $this->authorize('update', $form);

        // Find the question
        $question = $form->questions()->findOrFail($questionId);

        // Validate question input
        $validatedData = $request->validate([
            'question_text' => 'sometimes|string',
            'question_type' => 'sometimes|in:text,textarea,multiple_choice,checkbox,dropdown,date,number',
            'is_required' => 'sometimes|boolean',
            'options' => 'nullable|array',
            'order' => 'nullable|integer'
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update the question
            $question->update([
                'question_text' => $validatedData['question_text'] ?? $question->question_text,
                'question_type' => $validatedData['question_type'] ?? $question->question_type,
                'is_required' => $validatedData['is_required'] ?? $question->is_required,
                'order' => $validatedData['order'] ?? $question->order,
                'options' => !empty($validatedData['options']) 
                    ? json_encode($validatedData['options']) 
                    : $question->options
            ]);

            // Commit the transaction
            DB::commit();

            // Redirect back with success message
            return back()->with('success', 'Question updated successfully');
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            // Log the error
            \Log::error('Question update failed: ' . $e->getMessage());

            // Redirect back with error message
            return back()->withErrors(['error' => 'Failed to update question: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete a question from the form
     */
    public function destroyQuestion(Form $form, $questionId)
    {
        // Authorize question deletion
        $this->authorize('update', $form);

        // Find the question
        $question->delete();

        return redirect()->route('questions.index')
            ->with('success', 'Question deleted succesfully');
    }
}