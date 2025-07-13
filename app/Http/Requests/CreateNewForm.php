<?php
// app/Http/Requests/CreateNewForm.php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;


class CreateNewForm extends FormRequest
{
    public function rules()
    {
        return [
            'competition' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            // Add other validation rules
        ];
    }

    public function authorize()
    {
        // Add any authorization logic
        return true;
    }
}

