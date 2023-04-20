<?php

namespace App\Console\Commands;

use App\Models\ResourcePage;
use Illuminate\Console\Command;

class FixOrdering extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:fix-ordering';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $indx = 0;
        foreach (ResourcePage::all() as $page) {
            $page->ordering = $indx;
            $page->save();
            $indx++;
        }
    }
}
