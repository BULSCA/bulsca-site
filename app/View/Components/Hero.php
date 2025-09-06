<?php

namespace App\View\Components;

use App\Models\Components\Hero as ModelHero;
use Illuminate\View\Component;

class Hero extends Component
{

    private ?ModelHero $hero = null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?ModelHero $edit = null)
    {


        if ($edit !== null && $edit->id !== null) {

            $this->hero = $edit;
            return;
        }

        // find the hero that is enabled and is within the valid date range with the least days left
        $this->hero = ModelHero::where('enabled', true)
            ->where('activation_type', 'time')
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->orderBy('valid_to', 'asc')
            ->first();

        // if no hero is found find the first hero with a mnual activation type that is enabled
        if (!$this->hero) {
            $this->hero = ModelHero::where('enabled', true)
                ->where('activation_type', 'manual')
                ->first();
        }
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
