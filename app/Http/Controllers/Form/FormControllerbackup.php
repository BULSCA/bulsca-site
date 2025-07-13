<?php
namespace App\Http\Controllers\Form;

use App\Models\Form\Form;

class FormController extends BaseFormController
{
    public function __construct(Form $form)
    {
        parent::__construct($form);

        // Define specific validation rules
        $this->createRules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'close_date' => 'nullable|date|after:today',
            'status' => 'in:draft,active,closed'
        ];

        $this->updateRules = [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'close_date' => 'nullable|date|after:today',
            'status' => 'in:draft,active,closed'
        ];
    }

    // Optional: Override any methods with specific logic
    public function store(Request $request)
    {
        // Add any form-specific logic before or after parent method
        return parent::store($request);
    }
}
