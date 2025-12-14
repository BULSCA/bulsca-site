<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Organisation\Organisation;

class MigrateUniversitiesToOrganisations extends Command
{
    protected $signature = 'migrate:unis-to-orgs {--dry-run : Run without making changes}';
    protected $description = 'Migrate universities to organisations';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('DRY RUN - No changes will be made');
        }
        
        $universities = DB::table('unis')->get();
        $this->info("Found {$universities->count()} universities to migrate");
        
        if (!$dryRun && !$this->confirm('Do you want to continue?')) {
            return;
        }
        
        $bar = $this->output->createProgressBar($universities->count());
        
        foreach ($universities as $uni) {
            $this->info("\nMigrating: {$uni->name}");
            
            if (!$dryRun) {
                $orgId = DB::table('organisations')->insertGetId([
                    'name' => $uni->name,
                    'short_name' => $uni->short_name ?? null,
                    'type' => 'club',
                    'created_at' => $uni->created_at,
                    'updated_at' => $uni->updated_at,
                ]);
                
                DB::table('uni_org_mapping')->insert([
                    'uni_id' => $uni->id,
                    'organisation_id' => $orgId,
                ]);
                
                $this->info("  Created organisation ID: {$orgId}");
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Migration complete!');
    }
}