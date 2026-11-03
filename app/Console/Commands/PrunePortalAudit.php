<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrunePortalAudit extends Command
{
    protected $signature = 'portal:prune-audit';
    protected $description = 'Remove portal administration audit events older than 90 days';

    public function handle(): int
    {
        $removed = DB::table('portal_audit_events')->where('created_at', '<', now()->subDays(90))->delete();
        $this->info("Removed {$removed} expired portal audit events.");
        return self::SUCCESS;
    }
}
