<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordPostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{

    public function changePassword(ChangePasswordPostRequest $request)
    {
        $validated = $request->validated();


        $user = auth()->user();



        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->back()->with('message', 'Password changed!');
    }
}
