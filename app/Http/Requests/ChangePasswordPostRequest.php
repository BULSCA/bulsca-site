<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old_password' => 'required|current_password',
            'new_password' => 'required',
            'new_password_conf' => 'required|same:new_password'
        ];
    }

    public function messages()
    {
        return [
            'new_password_conf.same' => 'Your password and password confirmation do not match!',
        ];
    }
}
