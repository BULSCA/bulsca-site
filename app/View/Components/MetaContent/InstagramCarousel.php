<?php

namespace App\View\Components\MetaContent;

use App\Services\MetaContentService;
use Illuminate\View\Component;

class InstagramCarousel extends Component
{
    private $posts;
    private $title;
    private $backgroundOverlay;

    public function __construct(
        MetaContentService $metaContent,
        $title = 'Latest from BULSCA Instagram',
        $limit = null,
        $backgroundOverlay = 'rgba(0, 0, 0, 0.5)'
    ) {
        $this->title = $title;
        $this->backgroundOverlay = $backgroundOverlay;
        $this->posts = $metaContent->getLatestPosts($limit ?? config('services.meta.post_limit'));
    }

    /**
     * Hide the section entirely when there's nothing to show.
     */
    public function shouldRender()
    {
        return count($this->posts) > 0;
    }

    public function render()
    {
        return view('components.meta-content.instagram-carousel', [
            'posts' => $this->posts,
            'title' => $this->title,
            'backgroundOverlay' => $this->backgroundOverlay,
        ]);
    }
}