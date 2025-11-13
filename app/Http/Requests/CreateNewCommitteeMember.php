<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewCommitteeMember extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:4|max:255|string',
            'affiliated_uni_id' => 'nullable|integer|exists:universities,id',
        ];
    }

    public function messages()
    {
        return [
            'exists' => 'The selected :attribute is invalid.',
        ];
    }
}