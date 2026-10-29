<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormConfirmation;
use App\Mail\ContactFormSubmission;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    private const DEPARTMENTS = [
        'chair' => 'chair@bulsca.co.uk', 'secretary' => 'secretary@bulsca.co.uk', 'treasurer' => 'treasurer@bulsca.co.uk',
        'development' => 'clubdevelopment@bulsca.co.uk', 'recruitment' => 'clubrecruitment@bulsca.co.uk', 'data' => 'data@bulsca.co.uk',
        'championships' => 'championships@bulsca.co.uk', 'social' => 'social@bulsca.co.uk', 'welfare' => 'welfare@bulsca.co.uk',
        'league' => 'league@bulsca.co.uk', 'judges' => 'bulscajudgespanel@bulsca.co.uk', 'general' => 'chair@bulsca.co.uk',
    ];

    public function config(): array
    {
        return ['data' => ['turnstile_site_key' => config('services.turnstile.site_key'), 'accepts_submissions' => (bool) (config('public_site.contact_enabled') && config('services.turnstile.site_key') && config('services.turnstile.secret_key'))]];
    }

    public function submit(Request $request)
    {
        abort_unless($this->config()['data']['accepts_submissions'], 503);
        $data = $request->validate([
            'name' => 'required|string|max:255', 'email' => 'required|email|max:255', 'department' => ['required', Rule::in(array_keys(self::DEPARTMENTS))],
            'subject' => 'required|string|max:255', 'message' => 'required|string|max:5000', 'cf-turnstile-response' => 'required|string|max:2048',
        ]);
        $verification = Http::asForm()->connectTimeout(2)->timeout(5)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret_key'), 'response' => $data['cf-turnstile-response'], 'remoteip' => $request->ip(),
        ])->throw();
        if ($verification->json('success') !== true) throw ValidationException::withMessages(['cf-turnstile-response' => 'Verification failed. Please verify again.']);
        ContactSubmission::create(['name' => $data['name'], 'email' => $data['email'], 'recipient_department' => $data['department'], 'subject' => $data['subject'], 'message' => $data['message']]);
        // Delivery is deliberately not retried: a provider error can have an uncertain outcome.
        Mail::to(self::DEPARTMENTS[$data['department']])->send(new ContactFormSubmission($data['name'], $data['email'], $data['department'], messageSubject: $data['subject'], messageContent: $data['message']));
        Mail::to($data['email'])->send(new ContactFormConfirmation($data['name'], $data['department'], messageSubject: $data['subject'], messageContent: $data['message']));
        return response()->json(['data' => ['message' => 'Thank you! Your message has been sent.']], 201);
    }
}
