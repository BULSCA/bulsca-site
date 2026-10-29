<?php

namespace App\Console\Commands;

use App\Services\MetaContentService;
use App\Services\MetaTokenStore;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RefreshMetaToken extends Command
{
    protected $signature = 'meta:refresh-token';
    protected $description = 'Refresh the long-lived Meta access token before it expires';

    public function handle(MetaTokenStore $tokens)
    {
        if (! config('services.meta.user_id') || ! config('services.meta.app_id') || ! config('services.meta.app_secret')) {
            $this->info('Social integration is not configured; token refresh skipped.');
            return self::SUCCESS;
        }
        try {
            if (! $tokens->get()) throw new \RuntimeException('No social credentials');
            $result = app(MetaContentService::class)->refreshToken();
            if (! $result) throw new \RuntimeException('Social token refresh unavailable');
            $tokens->put($result['access_token'], $result['expires_in']);
        } catch (\Throwable) {
            Log::error('Meta token refresh failed; existing credentials retained');
            $this->error('Token refresh failed; check provider configuration and private storage.');
            return self::FAILURE;
        }

        Log::info('Meta token refreshed', ['expires_in' => $result['expires_in']]);
        $this->info('Token refreshed successfully.');
        return self::SUCCESS;
    }
}
