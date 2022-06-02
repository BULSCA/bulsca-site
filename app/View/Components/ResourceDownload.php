<?php

namespace App\View\Components;

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
        $this->file = $file;
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
