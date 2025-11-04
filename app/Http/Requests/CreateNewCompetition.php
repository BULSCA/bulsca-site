<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateNewCompetition extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('admin.competitions.manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'host' => ['required', Rule::notIn(['null'])],
            'when' => 'required|date',
            'season' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'host.not_in' => 'Please select a host!',
        ];
    }
}
