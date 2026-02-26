<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmission;
use App\Mail\ContactFormConfirmation;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class ContactFormController extends Controller
{
    // Mapping of departments to email addresses
    private const DEPARTMENT_EMAILS = [
        'chair' => 'chair@bulsca.co.uk',
        'secretary' => 'secretary@bulsca.co.uk',
        'treasurer' => 'treasurer@bulsca.co.uk',
        'development' => 'clubdevelopment@bulsca.co.uk',
        'recruitment' => 'clubrecruitment@bulsca.co.uk',
        'data' => 'data@bulsca.co.uk',
        'championships' => 'championships@bulsca.co.uk',
        'social' => 'social@bulsca.co.uk',
        'welfare' => 'welfare@bulsca.co.uk',
        'league' => 'league@bulsca.co.uk',
        'judges' => 'bulscajudgespanel@bulsca.co.uk',
        'general' => 'chair@bulsca.co.uk', // default to chair
    ];

    /**
     * Show the contact form
     */
    public function show()
    {
        return view('contact-form', [
            'departments' => array_keys(self::DEPARTMENT_EMAILS),
        ]);
    }

    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'department' => 'required|in:' . implode(',', array_keys(self::DEPARTMENT_EMAILS)),
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'cf-turnstile-response' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify Turnstile token
        $response = Http::post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret_key'),
            'response' => $request->input('cf-turnstile-response'),
        ]);

        if (!$response->json('success')) {
            return back()->withErrors(['turnstile' => 'Verification failed. Please try again.'])->withInput();
        }


        $departmentKey = $request->input('department');
        $recipientEmail = self::DEPARTMENT_EMAILS[$departmentKey];

        // Store the submission in database
        $submission = ContactSubmission::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'recipient_department' => $departmentKey,
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        // Send email to the department
        Mail::to($recipientEmail)->send(new ContactFormSubmission(
            $request->input('name'),
            $request->input('email'),
            $departmentKey,
            messageSubject: $request->input('subject'),
            messageContent: $request->input('message'),
        ));

        // Send confirmation email to the sender
        Mail::to($request->input('email'))->send(new ContactFormConfirmation(
            $request->input('name'),
            $departmentKey,
            messageSubject: $request->input('subject'),
            messageContent: $request->input('message'),
        ));

        return back()->with('success', 'Thank you! Your message has been sent. You will receive a confirmation email shortly.');
    }
}
