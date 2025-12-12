@props([
    'title' => 'Latest from Instagram',
    'posts' => [], // Array of post objects with image_url, permalink
    'backgroundOverlay' => 'rgba(0, 0, 0, 0.3)'
])

<div {{ $attributes->merge(['class' => 'w-screen relative bg-gray-100 overflow-hidden py-12']) }}>
    
    <!-- Background Overlay -->
    <div class="absolute inset-0 bg-black" style="background: {{ $backgroundOverlay }};"></div>

    <div class="flex flex-col justify-center items-center relative z-10 px-4">
        @if($title)
            <h1 class="text-white text-3xl md:text-5xl font-bold drop-shadow-lg mb-6 mt-4">{{ $title }}</h1>
        @endif

        @if(count($posts) > 0)
            <div class="w-full relative" id="instagram-carousel">
                <!-- Carousel Container -->
                <div class="relative overflow-hidden py-4">
                    <div class="flex transition-transform duration-500 ease-out" id="carousel-track">
                        @foreach($posts as $index => $post)
                            <div class="carousel-slide flex-shrink-0 px-4 transition-all duration-500" 
                                 data-slide="{{ $index }}"
                                 style="width: 350px;">
                                <a href="{{ $post['permalink'] }}" 
                                   target="_blank" 
                                   class="block transform transition-all duration-500 scale-90 opacity-60 hover:opacity-80" 
                                   data-card="{{ $index }}">
                                    <div class="relative overflow-hidden rounded-lg shadow-2xl bg-white">
                                        <img 
                                            src="{{ $post['image_url'] }}" 
                                            alt="{{ Str::limit($post['caption'] ?? 'Instagram post', 50) }}"
                                            class="w-full h-80 object-cover"
                                            loading="lazy"
                                        />
                                        <!-- Optional: Instagram icon overlay -->
                                        <div class="absolute top-2 right-2 bg-white/90 rounded-full p-2">
                                            <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Arrows -->
                @if(count($posts) > 1)
                    <button 
                        onclick="prevSlide()" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-3 shadow-lg z-20 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button 
                        onclick="nextSlide()" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-3 shadow-lg z-20 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @endif
            </div>

            <!-- Dots Indicator -->
            @if(count($posts) > 1)
                <div class="flex space-x-2 mt-4 mb-2 z-20">
                    @foreach($posts as $index => $post)
                        <button
                            onclick="goToSlide({{ $index }})"
                            class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition {{ $index === 0 ? 'bg-white' : '' }}"
                            data-dot="{{ $index }}">
                        </button>
                    @endforeach
                </div>
            @endif
        @else
            <div class="text-white text-center py-8">
                <p class="text-xl">No Instagram posts available at the moment.</p>
            </div>
        @endif
    </div>
</div>

@if(count($posts) > 1)
<script>
let currentSlide = 0;
let totalSlides = {{ count($posts) }};
let autoplayInterval;

function updateCarousel() {
    const track = document.getElementById('carousel-track');
    const cards = document.querySelectorAll('[data-card]');
    const dots = document.querySelectorAll('.carousel-dot');
    
    if (!track) return;
    
    // Calculate the offset to center the current slide
    const slideWidth = 350;
    const containerWidth = window.innerWidth;
    const offset = (containerWidth / 2) - (slideWidth / 2) - (currentSlide * slideWidth);
    
    track.style.transform = `translateX(${offset}px)`;
    
    // Update card styles
    cards.forEach((card, i) => {
        if (i === currentSlide) {
            card.classList.remove('scale-90', 'opacity-60');
            card.classList.add('scale-100', 'opacity-100');
        } else {
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-90', 'opacity-60');
        }
    });
    
    // Update dots
    dots.forEach((dot, i) => {
        if (i === currentSlide) {
            dot.classList.add('bg-white');
            dot.classList.remove('bg-white/50');
        } else {
            dot.classList.remove('bg-white');
            dot.classList.add('bg-white/50');
        }
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
    resetAutoplay();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
    resetAutoplay();
}

function goToSlide(index) {
    currentSlide = index;
    updateCarousel();
    resetAutoplay();
}

function startAutoplay() {
    if (totalSlides <= 1) return;
    autoplayInterval = setInterval(() => {
        nextSlide();
    }, 4000);
}

function resetAutoplay() {
    clearInterval(autoplayInterval);
    startAutoplay();
}

document.addEventListener('DOMContentLoaded', () => {
    updateCarousel();
    startAutoplay();
    
    const carousel = document.getElementById('instagram-carousel');
    if (carousel) {
        carousel.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
        carousel.addEventListener('mouseleave', () => startAutoplay());
    }
    
    window.addEventListener('resize', updateCarousel);
});
</script>
@endif