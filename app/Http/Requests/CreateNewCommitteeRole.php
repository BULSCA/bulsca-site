<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Committee\CommitteeRole;

class CreateNewCommitteeRole extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('admin.committee.manage');
    }

    protected function prepareForValidation()
    {
        if (!$this->has('order') || $this->order === null) {
            $this->merge([
                'order' => CommitteeRole::count() + 1
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'label' => 'required|min:8',
            'order' => 'sometimes|integer',
            'active' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'label.required' => 'The role label is required and must be at least 8 characters long.',
            'order.integer' => 'The order field must be an integer.',
            'active.required' => 'The active field is required and must be a boolean value.',
        ];
    }
}