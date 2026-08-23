{{-- Hand-curated Instagram carousel, populated from resources/data/instagram-posts.txt --}}
<x-meta-content.image-carousel
    :title="$title"
    :posts="$posts"
    :mode="$mode"
    :backgroundOverlay="$backgroundOverlay"
    {{ $attributes }}
/>
