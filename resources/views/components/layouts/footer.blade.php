
<footer class="bg-bulsca">
    <div class="w-full container-responsive">
        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start mx-2">

            {{  $slot  }}

            <div class="flex flex-col items-center justify-center md:flex-[1] flex-1 border-0">
                <h3 class="text-white font-semibold text-lg pb-2">Quick Links</h3>
                <p class="text-white ">
                    <a class="text-white font-normal no-underline hover:underline"
                        href="{{ route('contact') }}">Contact</a>
                </p>
                <p>
                    <a class="text-white font-normal no-underline hover:underline"
                        href="{{ route('welfare') }}">Welfare</a>
                </p>
                <p>
                    <a class="text-white font-normal no-underline hover:underline"
                        href="{{ route('privacy-policy') }}">Privacy Policy</a>
                </p>
                <?php
                    $ref = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : 'direct';
                    $ref = urlencode($ref);
                    echo '<p>
                        <a class="text-white font-normal no-underline hover:underline"
                            target="_blank"
                            rel="noopener noreferrer"
                            href="https://scoring.events?ref=' . $ref . '">Scoring.Events</a>
                    </p>';
                ?>
                <div class="p-6 flex flex-row items-center justify-center divide-x mt-auto">
                    <a href="https://www.facebook.com/BULSCA/" rel="noopener noreferrer" target="_blank"><img
                            src="/storage/logo/f_logo_RGB-Blue_1024.png" loading="lazy" class="w-12 h-12 mx-3" alt=""></a>
                    <a href="https://www.instagram.com/bulsca" rel="noopener noreferrer" target="_blank"><img
                            src="/storage/logo/Instagram_Glyph_Gradient_RGB.png" loading="lazy" class="w-12 h-12 mx-3"
                            alt=""></a>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full text-center text-sm text-white p-4 flex items-center justify-center">
        <span>&copy; {{ date('Y') }} British Universities Lifesaving Clubs' Association</span>
    </div>
</footer>
