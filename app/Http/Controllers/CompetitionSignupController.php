<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\CompetitionInfo;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CompetitionSignupController extends Controller
{
    public function createOrEdit(Competition $cid)
    {
        $arr = explode(".", $cid);
        $id = $arr[count($arr) - 1];

        $lc = Competition::find($id)->load('hostUni', 'currentSeason');

        // Check if signup is still allowed
        if (!$lc->isSignupAllowed()) {
            return redirect()->back()->with('error', 'Signup deadline has passed');
        }

        // Try to find existing signup for the current user
        $signup = CompetitionSignup::where([
            'competition_id' => $lc->id,
            'user_id' => auth()->id()
        ])->first();

        return view('competitions.signup', [
            'competition' => $lc,
            'signup' => $signup
        ]);
    }

    public function store(Request $request, Competition $cid)
    {
        // Validate signup is still allowed
        if (!$cid->isSignupAllowed()) {
            return redirect()->back()->with('error', 'Signup deadline has passed');
        }

        // Validate input (customize as needed)
        $validatedData = $request->validate([
            // Add your specific validation rules
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            // Add more fields as needed
        ]);

        // Find or create signup
        $signup = CompetitionSignup::updateOrCreate(
            [
                'competition_id' => $cid->id,
                'user_id' => auth()->id()
            ],
            [
                'signup_data' => $validatedData
            ]
        );

        return redirect()->route('competitions.signup.show', $cid)
            ->with('success', 'Signup submitted successfully');
    }

    public function show(Competition $cid)
    {
        // Find user's signup
        $signup = CompetitionSignup::where([
            'competition_id' => $cid->id,
            'user_id' => auth()->id()
        ])->first();

        // If no signup exists, redirect to create
        if (!$signup) {
            return redirect()->route('competitions.signup.create', $cid)
                ->with('message', 'You have not signed up yet');
        }

        return view('competitions.signup-details', [
            'competition' => $cid,
            'signup' => $signup
        ]);
    }

    // Method for competition owner to get all signups
    public function getUserSignups(Competition $cid)
    {
        // This method would be used by the competition owner
        // to retrieve all signups for the competition
        return CompetitionSignup::where('competition_id', $cid->id)
            ->with('user')
            ->get();
    }
}
