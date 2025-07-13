<?php
// app/Http/Controllers/Form/FormController.php
namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewForm;
use App\Models\Form\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FormController extends Controller 
{
    public function create(CreateNewForm $request)
    {
        try {
            \Log::info('Create method called', [
                'route' => request()->route()->getName(),
                'url' => request()->url(),
                'method' => request()->method()
            ]);
            
            // Ensure you're not redirecting to the same route repeatedly
            $validated = $request->validated();
    
            $form = new Form();
            $form->comp = $validated['competition'] ?? null;
            $form->host = $validated['host'] ?? null;
            $form->save();
    
            // IMPORTANT: Redirect to a different route, not back to create
            return redirect()->route('forms.index') // or another appropriate route
                ->with('success', 'Form created successfully!');
    
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Form creation error: ' . $e->getMessage());
    
            return back()
                ->withErrors(['msg' => 'Form creation failed'])
                ->withInput();
        }
    }
    

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            // Add your validation rules
            'field1' => 'required|max:255',
            'field2' => 'nullable|email'
        ]);

        // Create form submission
        try {
            // Save to database
            $form = Form::create($validated);

            // Redirect with success message
            return redirect()
                ->route('forms.create')
                ->with('success', 'Form submitted successfully');
        } catch (\Exception $e) {
            // Handle errors
            return back()
                ->withErrors(['msg' => 'Submission failed'])
                ->withInput();
        }
    }
}
