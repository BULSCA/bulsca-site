<?php

namespace App\View\Components\MetaContent;

use App\Services\MetaContentService;
use Illuminate\View\Component;

class InstagramCarousel extends Component
{
    private $posts;
    private $title;
    private $mode;
    private $backgroundOverlay;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        MetaContentService $metaContent,
        $title = null,
        $limit = null,
        $mode = null,
        $backgroundOverlay = 'rgba(0, 0, 0, 0.5)'
    ) {
        $this->title = $title ?? config('social.instagram_carousel.title');
        $this->mode = $mode ?? config('social.instagram_carousel.mode', 'image');
        $this->backgroundOverlay = $backgroundOverlay;

        $this->posts = config('social.instagram_carousel.enabled')
            ? $metaContent->getCuratedPosts($limit)
            : [];
    }

    /**
     * Hide the section entirely when disabled or when nothing is listed.
     */
    public function shouldRender()
    {
        return count($this->posts) > 0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.meta-content.instagram-carousel', [
            'posts' => $this->posts,
            'title' => $this->title,
            'mode' => $this->mode,
            'backgroundOverlay' => $this->backgroundOverlay,
        ]);
    }
}
