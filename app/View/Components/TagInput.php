<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TagInput extends Component
{

    private $value, $allowNew;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value = "", $allowNew = 'true')
    {
        $this->value = $value;
        $this->allowNew = $allowNew;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tag-input', ['value' => $this->value, 'allowNew' => $this->allowNew]);
    }
}
