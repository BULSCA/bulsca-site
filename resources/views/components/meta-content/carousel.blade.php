@props([
    'title' => 'Carousel Title',
    'items' => [], // Array of Instagram post URLs like ['https://www.instagram.com/p/ABC123/', ...]
    'height' => 'h-[60vh]',
    'backgroundOverlay' => 'rgba(0, 0, 0, 0.3)'
])

<div {{ $attributes->merge(['class' => $height . ' w-screen relative bg-gray-100 overflow-hidden']) }}>
    
    <!-- Background Overlay -->
    <div class="absolute inset-0 bg-black" style="background: {{ $backgroundOverlay }};"></div>

    <div class="flex flex-col justify-center items-center h-full relative z-10 px-4">
        @if($title)
            <h1 class="text-white text-3xl md:text-5xl font-bold drop-shadow-lg mb-8">{{ $title }}</h1>
        @endif

        <div class="w-full relative" id="instagram-carousel">
            <!-- Carousel Container -->
            <div class="relative overflow-hidden py-8">
                <div class="flex transition-transform duration-500 ease-out" id="carousel-track" style="transform: translateX(0);">
                    @foreach($items as $index => $url)
                        <div class="carousel-slide flex-shrink-0 px-4 transition-all duration-500" 
                             data-slide="{{ $index }}"
                             style="width: 350px;">
                            <div class="transform transition-all duration-500 scale-90 opacity-60" data-card="{{ $index }}">
                                <x-meta-content.meta-content-item :itemLink="$url" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Arrows -->
            @if(count($items) > 1)
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
        @if(count($items) > 1)
            <div class="flex space-x-2 mt-6 z-20">
                @foreach($items as $index => $item)
                    <button
                        onclick="goToSlide({{ $index }})"
                        class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition {{ $index === 0 ? 'bg-white' : '' }}"
                        data-dot="{{ $index }}">
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Load Instagram embed script -->
<script async src="//www.instagram.com/embed.js"></script>

<script>
let currentSlide = 0;
let totalSlides = {{ count($items) }};
let autoplayInterval;

function updateCarousel() {
    const track = document.getElementById('carousel-track');
    const cards = document.querySelectorAll('[data-card]');
    const dots = document.querySelectorAll('.carousel-dot');
    
    // Calculate the offset to center the current slide
    const slideWidth = 350; // Width of each slide including padding
    const containerWidth = window.innerWidth;
    const offset = (containerWidth / 2) - (slideWidth / 2) - (currentSlide * slideWidth);
    
    track.style.transform = `translateX(${offset}px)`;
    
    // Update card styles based on position relative to center
    cards.forEach((card, i) => {
        if (i === currentSlide) {
            // Center card - full size and opacity
            card.classList.remove('scale-90', 'opacity-60');
            card.classList.add('scale-100', 'opacity-100');
        } else {
            // Side cards - smaller and dimmed
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
    }, 6000); // Change slide every 6 seconds
}

function resetAutoplay() {
    clearInterval(autoplayInterval);
    startAutoplay();
}

// Start carousel when page loads
document.addEventListener('DOMContentLoaded', () => {
    updateCarousel();
    startAutoplay();
    
    // Pause on hover
    const carousel = document.getElementById('instagram-carousel');
    if (carousel) {
        carousel.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
        carousel.addEventListener('mouseleave', () => startAutoplay());
    }
    
    // Update on window resize
    window.addEventListener('resize', updateCarousel);
    
    // Process Instagram embeds after a short delay
    setTimeout(() => {
        if (window.instgrm) {
            window.instgrm.Embeds.process();
        }
    }, 500);
});
</script>