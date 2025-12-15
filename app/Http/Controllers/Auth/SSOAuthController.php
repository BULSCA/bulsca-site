<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SSOAuthController extends Controller
{
    public function redirectToSSO()
    {
        if (!config('sso.enabled')) {
            return redirect('/login')->withErrors(['error' => 'SSO is not enabled']);
        }

        $state = Str::random(40);
        session(['sso_state' => $state]);

        $query = http_build_query([
            'client_id' => config('sso.client_id'),
            'redirect_uri' => config('sso.redirect_uri'),
            'state' => $state,
        ]);

        return redirect(config('sso.auth_server') . '/sso/authorize?' . $query);
    }

    public function handleCallback(Request $request)
    {
        // Verify state to prevent CSRF
        if ($request->state !== session('sso_state')) {
            Log::error('SSO state mismatch', [
                'expected' => session('sso_state'),
                'received' => $request->state
            ]);
            return redirect('/login')->withErrors(['error' => 'Invalid state parameter']);
        }

        if ($request->has('error')) {
            Log::error('SSO authorization error', ['error' => $request->error]);
            return redirect('/login')->withErrors(['error' => $request->error]);
        }

        try {
            // Exchange code for access token
            $response = Http::timeout(10)->post(config('sso.auth_server') . '/sso/token', [
                'grant_type' => 'authorization_code',
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
                'code' => $request->code,
            ]);

            if (!$response->successful()) {
                Log::error('SSO token request failed');
                return redirect('/login')->withErrors(['error' => 'Failed to authenticate with SSO']);
            }

            $tokens = $response->json();

            // SERVER-TO-SERVER: Verify user has access with accepted scopes
            $siteIdentifier = config('sso.site_identifier', 'main');
            $acceptedScopes = config('sso.accepted_scopes', []);
            
            $accessCheckResponse = Http::timeout(10)->post(config('sso.auth_server') . '/sso/site-access/verify', [
                'access_token' => $tokens['access_token'],
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
                'site_identifier' => $siteIdentifier,
                'accepted_scopes' => $acceptedScopes,
            ]);

            if (!$accessCheckResponse->successful()) {
                Log::error('SSO site access verification failed');
                return redirect('/login')->withErrors(['error' => 'Failed to verify site access']);
            }

            $accessData = $accessCheckResponse->json();
            
            if (!($accessData['has_access'] ?? false)) {
                $reason = $accessData['reason'] ?? 'Access denied';
                $userScopes = $accessData['user_scopes'] ?? [];
                $acceptedScopes = $accessData['accepted_scopes'] ?? [];
                
                Log::warning('SSO access denied', [
                    'reason' => $reason,
                    'user_scopes' => $userScopes,
                    'accepted_scopes' => $acceptedScopes,
                ]);
                
                session()->forget(['sso_state', 'sso_access_token', 'sso_refresh_token']);
                
                // User-friendly error message
                if (!empty($userScopes) && !empty($acceptedScopes)) {
                    $errorMessage = "You don't have the required permissions for this site. Your scopes: " . implode(', ', $userScopes);
                } else {
                    $errorMessage = 'You do not have access to this site. Please contact the site administrator.';
                }
                
                return redirect('/login')->withErrors(['error' => $errorMessage]);
            }
            
            $userData = $accessData['user'];
            $userScopes = $accessData['scopes'] ?? [];

            // Create or update user
            $user = User::updateOrCreate(
                ['sso_user_id' => $userData['id']],
                [
                    'email' => $userData['email'],
                    'name' => $userData['name'],
                    'auth_type' => 'sso',
                ]
            );

            // Store tokens and scopes in session
            session([
                'sso_access_token' => $tokens['access_token'],
                'sso_refresh_token' => $tokens['refresh_token'],
                'sso_scopes' => $userScopes,
            ]);

            Auth::login($user);

            Log::info('SSO login successful', [
                'user_id' => $user->id,
                'scopes' => $userScopes,
                'site' => $siteIdentifier,
            ]);

            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            Log::error('SSO callback exception', [
                'message' => $e->getMessage(),
            ]);
            return redirect('/login')->withErrors(['error' => 'Authentication failed. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // If SSO user, also logout from SSO server
        if ($user && isset($user->auth_type) && $user->auth_type === 'sso' && session('sso_access_token')) {
            try {
                Http::timeout(5)->post(config('sso.auth_server') . '/sso/logout', [
                    'access_token' => session('sso_access_token'),
                ]);
            } catch (\Exception $e) {
                \Log::warning('SSO logout failed: ' . $e->getMessage());
            }
        }

        Auth::guard('web')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}