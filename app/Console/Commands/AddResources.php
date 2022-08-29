<?php

namespace App\Console\Commands;

use App\Models\Resource;
use App\Models\ResourcePage;
use App\Models\ResourcePageSection;
use App\Models\ResourcePageSectionResource;
use DirectoryIterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Str;

class AddResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:add-resources {section} {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds all the given resources to the given section';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        if (!ResourcePageSection::where('name', $this->argument('section'))->exists()) {
            $this->error("No section called '{$this->argument('section')}' exists!");
            return 0;
        }

        $section = ResourcePageSection::where('name', $this->argument('section'))->first();


        $path = $this->argument('path');

        if (!file_exists($path)) {
            $this->error("The path given doesn't exist!");
            return 0;
        }


        foreach (new DirectoryIterator($path) as $fileInfo) {

            if (!$fileInfo->isFIle()) continue;

            $target = 'resources/resources/' . Str::random(40) . '.' . $fileInfo->getExtension();



            copy($fileInfo->getPathname(), storage_path('app') . '/' . $target);

            $resource = new Resource();
            $resource->name = Str::replace('-', ' ', Str::replace('_', ' ', pathinfo($fileInfo->getPathname(), PATHINFO_FILENAME)));
            $resource->location = $target;
            $resource->save();

            $rpsr = new ResourcePageSectionResource();
            $rpsr->section = $section->id;
            $rpsr->resource = $resource->id;
            $rpsr->short = "";
            $rpsr->content = "";
            $rpsr->save();
        }

        $page = ResourcePage::find($section->page);


        Cache::forget('resource-page-' . Str::replace(' ', '-', Str::lower($page->name)));
    }
}
