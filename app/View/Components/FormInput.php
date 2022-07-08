<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $type = "text", $defaultValue = "", $extraCss = "")
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->defaultValue = $defaultValue;
        $this->extraCss = $extraCss;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-input', ['id' => $this->id, 'title' => $this->title, 'type' => $this->type, 'defaultValue' => $this->defaultValue, 'css' => $this->extraCss]);
    }
}
