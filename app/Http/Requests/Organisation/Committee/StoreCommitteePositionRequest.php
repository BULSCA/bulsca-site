<?php

namespace App\Http\Requests\Organisation\Committee;

use App\Helpers\OrganisationHelpers;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommitteePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $validPermissions = array_keys(OrganisationHelpers::getAvailablePermissions());
        
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', $validPermissions),
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The position title is required.',
            'title.max' => 'The position title must not exceed 255 characters.',
            'permissions.array' => 'Permissions must be an array.',
            'permissions.*.in' => 'One or more selected permissions are invalid.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Ensure permissions is an array, even if empty
        if (!$this->has('permissions')) {
            $this->merge(['permissions' => []]);
        }
    }
}