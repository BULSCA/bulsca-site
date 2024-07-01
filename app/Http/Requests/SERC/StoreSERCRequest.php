<?php

namespace App\Http\Requests\SERC;

use Illuminate\Foundation\Http\FormRequest;

class StoreSERCRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('admin.sercs.manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => '',
            'when' => 'required|date',
            'where' => 'required',
            'no_cas' => 'sometimes|nullable|integer|min:1',
            'author' => 'sometimes|nullable',
            'files' => '',
            'tags' => '',
        ];
    }

    public function messages()
    {
        return [

            'no_cas.min' => '# casualties must be at least 1',
        ];
    }
}
