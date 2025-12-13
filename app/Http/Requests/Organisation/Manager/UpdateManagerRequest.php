<?php

namespace App\Http\Requests\Organisation\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateManagerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role' => ['required', Rule::in(['owner', 'admin'])],
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'Please select a role.',
            'role.in' => 'Invalid role selected. Must be owner or admin.',
        ];
    }
}