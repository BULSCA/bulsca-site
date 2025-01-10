<?php

namespace App\Http\Requests\SERC;

use Illuminate\Foundation\Http\FormRequest;

class StoreCasualtyRequest extends FormRequest
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

        $id = $this->route('casualty') ? $this->route('casualty')->id : null;

        return [
            'name' => 'required|min:3|unique:casualties,name,' . $id,
            'manual' => '',
            'group' => 'required|not_in:null',
            'description' => '',
        ];
    }


    public function messages()
    {
        return [

            'name.unique' => 'A casualty with that name already exists',
            'group.not_in' => 'Please select a group',
        ];
    }
}
