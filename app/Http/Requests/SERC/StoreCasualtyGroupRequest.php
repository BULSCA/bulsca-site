<?php

namespace App\Http\Requests\SERC;

use Illuminate\Foundation\Http\FormRequest;

class StoreCasualtyGroupRequest extends FormRequest
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

        $id = $this->route('group') ? $this->route('group')->id : null;

        return [
            'name' => 'required|min:3|unique:casualty_groups,name,' . $id,
            'description' => '',
        ];
    }


    public function messages()
    {
        return [

            'name.unique' => 'A group with that name already exists',
        ];
    }
}
