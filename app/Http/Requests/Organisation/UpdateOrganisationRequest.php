<?php

namespace App\Http\Requests\Organisation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrganisationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled in controller
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'type' => ['required', Rule::in(['club', 'league', 'national_body', 'region', 'other'])],
            'parent_id' => [
                'nullable',
                'exists:organisations,id',
                Rule::notIn([$this->route('id')]), // Can't be own parent
            ],
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'county' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The organisation name is required.',
            'type.required' => 'Please select an organisation type.',
            'type.in' => 'Invalid organisation type selected.',
            'parent_id.exists' => 'The selected parent organisation does not exist.',
            'parent_id.not_in' => 'An organisation cannot be its own parent.',
            'website.url' => 'Please provide a valid URL for the website.',
            'email.email' => 'Please provide a valid email address.',
        ];
    }
}