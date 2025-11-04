<?php

namespace App\Console\Commands;

use App\Models\Resource;
use App\Models\ResourcePageSectionResource;
use Illuminate\Console\Command;

class IndexPdfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:index-pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all dynamic resources that are pdfs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rpsrs = ResourcePageSectionResource::all();

        foreach ($rpsrs as $pres) {
            $resource = Resource::find($pres->resource);
            if (pathinfo($resource->location, PATHINFO_EXTENSION) == 'pdf') {
                $fullTarget = storage_path('app').'/'.$resource->location;
                $content = '';

                $content = shell_exec("pdftotext {$fullTarget} -");
                $pres->content = $content;
            }
            $pres->name = $resource->name;
            $pres->save();
        }

        return 0;
    }
}
