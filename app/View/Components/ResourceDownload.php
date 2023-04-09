<?php

namespace App\View\Components;

use App\Models\Resource;
use Illuminate\View\Component;

class ResourceDownload extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    private $file;


    public function __construct($file)
    {
        if ($file instanceof Resource) {
            $this->file = ['name' => $file->name, 'link' => $file->getURL()];
        } else {
            $this->file = $file;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.resource-download', ['file' => $this->file]);
    }
}
