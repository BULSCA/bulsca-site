<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvitation;

class InvitationController extends Controller
{
    public function index()
    {
        // Show invitation form
        return view('admin.invitations.create');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        try {
            // Call auth service to create invitation
            $response = Http::timeout(10)->post(config('sso.auth_server') . '/api/invitations', [
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
                'email' => $validated['email'],
                'invited_by_user_id' => auth()->id(),
            ]);

            if (!$response->successful()) {
                return back()->withErrors(['error' => 'Failed to create invitation. Email may already be registered.']);
            }

            $data = $response->json();

            // Send invitation email
            Mail::to($validated['email'])->send(new UserInvitation($data['invitation_url']));

            return back()->with('success', 'Invitation sent to ' . $validated['email']);

        } catch (\Exception $e) {
            \Log::error('Invitation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to send invitation.']);
        }
    }
}