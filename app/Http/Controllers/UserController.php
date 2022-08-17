<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUserCreateRequest;
use App\Models\User;
use App\Notifications\WelcomeUserInvite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery\Undefined;

class UserController extends Controller
{


    public function createUser(PostUserCreateRequest $request)
    {

        $validated = $request->validated();



        $user = new User();

        $user->name = $validated['user_name'];
        $user->email = $validated['user_email'];

        $password = Str::random(16);
        $user->password = Hash::make($password);

        $user->save();

        try {
            $user->notify(new WelcomeUserInvite($user, $password));
        } catch (Exception $e) {
            // Ignore failed mail for now
        }


        if ($validated['user_university'] != 'null') {

            if (array_key_exists('user_university_admin', $validated)) {
                DB::table('user_universities')->insert(['uni' => $validated['user_university'], 'user' => $user->id, 'admin' => true]);
            } else {
                DB::table('user_universities')->insert(['uni' => $validated['user_university'], 'user' => $user->id]);
            }
        }

        return redirect()->route('admin.users')->with('message', 'User created');
    }
}
