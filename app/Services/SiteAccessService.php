<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SiteAccessService
{
    protected $authServer;
    protected $clientId;
    protected $clientSecret;
    protected $siteIdentifier;
    
    public function __construct()
    {
        $this->authServer = config('sso.auth_server');
        $this->clientId = config('sso.client_id');
        $this->clientSecret = config('sso.client_secret');
        $this->siteIdentifier = config('sso.site_identifier', 'main');
    }
    
    public function grantAccess(string $userEmail, array $scopes, ?string $grantedByEmail = null, ?string $notes = null): bool
    {
        try {
            $response = Http::timeout(10)->post($this->authServer . '/sso/site-access/grant', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'user_email' => $userEmail,
                'site_identifier' => $this->siteIdentifier,
                'scopes' => $scopes,
                'granted_by_email' => $grantedByEmail ?? auth()->user()?->email,
                'notes' => $notes,
            ]);
            
            return $response->successful();
            
        } catch (\Exception $e) {
            Log::error('Exception granting site access', [
                'user_email' => $userEmail,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
    
    public function addScopes(string $userEmail, array $scopes): bool
    {
        try {
            $response = Http::timeout(10)->post($this->authServer . '/sso/site-access/add-scopes', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'user_email' => $userEmail,
                'site_identifier' => $this->siteIdentifier,
                'scopes' => $scopes,
            ]);
            
            return $response->successful();
            
        } catch (\Exception $e) {
            Log::error('Exception adding scopes', [
                'user_email' => $userEmail,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
    
    public function removeScopes(string $userEmail, array $scopes): bool
    {
        try {
            $response = Http::timeout(10)->post($this->authServer . '/sso/site-access/remove-scopes', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'user_email' => $userEmail,
                'site_identifier' => $this->siteIdentifier,
                'scopes' => $scopes,
            ]);
            
            return $response->successful();
            
        } catch (\Exception $e) {
            Log::error('Exception removing scopes', [
                'user_email' => $userEmail,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
    
    public function revokeAccess(string $userEmail): bool
    {
        try {
            $response = Http::timeout(10)->post($this->authServer . '/sso/site-access/revoke', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'user_email' => $userEmail,
                'site_identifier' => $this->siteIdentifier,
            ]);
            
            return $response->successful();
            
        } catch (\Exception $e) {
            Log::error('Exception revoking site access', [
                'user_email' => $userEmail,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
    
    public function listUsers(): ?array
    {
        try {
            $response = Http::timeout(10)->post($this->authServer . '/sso/site-access/list', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'site_identifier' => $this->siteIdentifier,
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Exception listing site users', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}