<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\PostUserCreateRequest;
use App\Models\User;
use App\Notifications\WelcomeUserInvite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery\Undefined;
use Spatie\Permission\Models\Role;

use Laravel\Sanctum\HasApiTokens;

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

        // Roles check handling
        $availableRoles = Role::where('name', '!=', 'super_admin')->get();

        foreach ($availableRoles as $availableRole) {
            $name = "role-{$availableRole->id}";

            if ($request->input($name, false)) {
                // If it exists then checkbox was submitted (thus it was checked!) so add role
                $user->assignRole($availableRole);
            }
        }

        return redirect()->route('admin.user', $user)->with('message', 'User created');
    }

    public function editUser(EditUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::findOrFail($validated['user_id']);


        $user->name = $validated['user_name'];
        $user->email = $validated['user_email'];


        $user->save();



        if ($validated['user_university'] != 'null') {

            $exists = DB::table('user_universities')->where('user', $user->id)->exists();

            if (array_key_exists('user_university_admin', $validated)) {

                if ($exists) {
                    DB::table('user_universities')->where('user', $user->id)->update(['uni' => $validated['user_university'], 'admin' => true]);
                } else {
                    DB::table('user_universities')->insert(['user' => $user->id, 'uni' => $validated['user_university'], 'admin' => true]);
                }
            } else {
                if ($exists) {
                    DB::table('user_universities')->where('user', $user->id)->update(['uni' => $validated['user_university'], 'admin' => false]);
                } else {
                    DB::table('user_universities')->insert(['user' => $user->id, 'uni' => $validated['user_university'], 'admin' => false]);
                }
            }
        } else {
            DB::table('user_universities')->where('user', $user->id)->delete();
        }

        // Roles check handling
        $availableRoles = Role::where('name', '!=', 'super_admin')->get();

        foreach ($availableRoles as $availableRole) {
            $name = "role-{$availableRole->id}";

            if ($request->input($name, false)) {
                // If it exists then checkbox was submitted (thus it was checked!) so add role
                $user->assignRole($availableRole);
            } else {
                $user->removeRole($availableRole);
            }
        }

        return redirect()->back()->with('message', 'User updated');
    }
}
