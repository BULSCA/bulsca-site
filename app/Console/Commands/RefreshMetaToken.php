<?php

namespace App\Console\Commands;

use App\Services\MetaContentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RefreshMetaToken extends Command
{
    protected $signature = 'meta:refresh-token';
    protected $description = 'Refresh the long-lived Meta access token before it expires';

    public function handle(MetaContentService $metaContent)
    {
        $result = $metaContent->refreshToken();

        if (!$result) {
            Log::error('Meta token refresh failed — manual intervention needed');
            $this->error('Token refresh failed.');
            return self::FAILURE;
        }

        // TODO: persist $result['access_token'] somewhere durable — see note below
        Log::info('Meta token refreshed', ['expires_in' => $result['expires_in']]);
        $this->info('Token refreshed successfully.');
        return self::SUCCESS;
    }
}