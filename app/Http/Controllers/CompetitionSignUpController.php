<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompetitionRegistration;

class CompetitionSignUpController extends Controller
{
    /**
     * Display the competition sign-up form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('competitions.register');
    }

    /**
     * Handle the competition sign-up form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:competition_registrations,email',
            'food_preference' => 'required|array',
            'food_preference.*' => 'in:vegetarian,vegan,gluten-free',
            'has_dietary_requirements' => 'nullable|boolean',
            'dietary_requirements' => 'required_if:has_dietary_requirements,1|string|max:255',
        ]);

        $registration = CompetitionRegistration::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'food_preference' => implode(',', $validatedData['food_preference']),
            'has_dietary_requirements' => $validatedData['has_dietary_requirements'] ?? 0,
            'dietary_requirements' => $validatedData['dietary_requirements'] ?? null,
        ]);

        return redirect()->route('competitions.register.success')->with('success', 'You have successfully registered for the competition!');
    }
}
