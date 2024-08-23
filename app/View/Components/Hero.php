<?php

namespace App\View\Components;

use App\Models\Components\Hero as ModelHero;
use Illuminate\View\Component;

class Hero extends Component
{

    private ModelHero $hero;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->hero = ModelHero::first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.hero.hero', ['hero' => $this->hero]);
    }
}
