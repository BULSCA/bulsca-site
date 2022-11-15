<?php

namespace App\Http\Requests;

use App\Models\Competition;
use Illuminate\Foundation\Http\FormRequest;

class ManageCompetitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $cid = request()->cid;
        $c = Competition::find($cid)->first();
        return $cid->hostUni->currentUserIsClubAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [];
    }
}
