<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Http, Log, Validator};
use Illuminate\Support\Str;

class SSOAuthController extends Controller
{
    public function redirectToSSO(Request $request)
    {
        if (! config('sso.enabled')) {
            return redirect('/login')->withErrors(['error' => 'SSO is not enabled']);
        }

        $state = Str::random(40);
        $request->session()->put(['sso_state' => $state, 'sso_portal' => $request->boolean('portal')]);
        $query = http_build_query([
            'client_id' => config('sso.client_id'),
            'redirect_uri' => config('sso.redirect_uri'),
            'state' => $state,
        ]);

        return redirect(config('sso.auth_server').'/sso/authorize?'.$query);
    }

    public function handleCallback(Request $request)
    {
        // A callback is single-use, including when the provider returns an error.
        $expected = $request->session()->pull('sso_state');
        $portal = $request->session()->pull('sso_portal', false);
        $failure = fn () => redirect($portal ? '/?auth=failed' : '/login')
            ->withErrors(['error' => 'Authentication failed. Please sign in again.']);
        $state = $request->input('state');
        if (! is_string($expected) || $expected === '' || ! is_string($state) || ! hash_equals($expected, $state)) {
            return $failure();
        }
        $code = $request->input('code');
        if ($request->has('error') || ! is_string($code) || $code === '' || strlen($code) > 4096) {
            return $failure();
        }

        try {
            $response = Http::timeout(10)->post(config('sso.auth_server').'/sso/token', [
                'grant_type' => 'authorization_code',
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
                'code' => $code,
            ]);
            $tokens = $response->json();
            if (! $response->successful() || ! is_array($tokens) || ! is_string($tokens['access_token'] ?? null) || $tokens['access_token'] === '') {
                Log::warning('sso_token_unavailable', ['status' => $response->status()]);
                return $failure();
            }

            $profile = Http::timeout(10)->post(config('sso.auth_server').'/sso/validate', [
                'access_token' => $tokens['access_token'],
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
            ]);
            $userData = $profile->json('user');
            if (! $profile->successful() || ! is_array($userData) || Validator::make($userData, [
                'id' => 'required|integer|min:1', 'email' => 'required|email|max:254', 'name' => 'required|string|max:255',
            ])->fails()) {
                Log::warning('sso_profile_unavailable', ['status' => $profile->status()]);
                return $failure();
            }

            // Authentication never creates memberships or grants a role.
            $user = User::updateOrCreate(['sso_user_id' => $userData['id']], [
                'email' => $userData['email'], 'name' => $userData['name'], 'auth_type' => 'sso',
            ]);
            $request->session()->put([
                'sso_access_token' => $tokens['access_token'],
                'sso_refresh_token' => is_string($tokens['refresh_token'] ?? null) ? $tokens['refresh_token'] : null,
            ]);
            Auth::login($user);
            $request->session()->regenerate();

            return $portal ? redirect('/dashboard') : redirect()->intended('/dashboard');
        } catch (\Throwable) {
            // Exception messages and provider bodies can contain tokens and personal data.
            Log::warning('sso_authentication_unavailable');
            return $failure();
        }
    }

    public function logout(Request $request)
    {
        if ($request->user()?->auth_type === 'sso' && $request->session()->has('sso_access_token')) {
            try {
                Http::timeout(5)->post(config('sso.auth_server').'/sso/logout', [
                    'access_token' => $request->session()->get('sso_access_token'),
                ]);
            } catch (\Throwable) {
                Log::warning('sso_logout_unavailable');
            }
        }
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->expectsJson() ? response()->json(['data' => ['signed_out' => true]]) : redirect('/');
    }
}
