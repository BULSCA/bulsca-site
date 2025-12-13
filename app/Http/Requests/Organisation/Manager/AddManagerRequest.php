<?php

namespace App\Http\Requests\Organisation\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddManagerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'role' => ['required', Rule::in(['owner', 'admin'])],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Please select a user.',
            'user_id.exists' => 'The selected user does not exist.',
            'role.required' => 'Please select a role.',
            'role.in' => 'Invalid role selected. Must be owner or admin.',
        ];
    }
}