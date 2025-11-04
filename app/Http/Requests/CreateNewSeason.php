<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewSeason extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('admin.seasons.manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:8',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
        ];
    }

    public function messages()
    {
        return [
            'to.after' => 'The season must end after the start date!',
        ];
    }
}
