<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\GlobalNotification;

class AlertBanner extends Component
{

    private $message;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->message = Cache::rememberForever('gn_banner', function () {
            $banner = GlobalNotification::getBanner();

            if (!$banner) return null;
            return $banner->content;
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        if (!$this->message) return;

        return view('components.alert-banner', ['content' => $this->message]);
    }
}
