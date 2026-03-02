<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/png" href="/storage/logo/blogo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?{{ config('version.hash') }}">
    <title> @yield('title') BULSCA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <meta name="description" content="@yield('meta')">
    <meta property="og:title" content="@yield('title') BULSCA">
    <meta name="og:description" content="@yield('meta')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.css">


    <script src="{{ asset('js/Snow.js') }}"></script>
    <script src="{{ asset('js/Holiday-eastereggs.js') }}?{{ config('version.hash') }}"></script>
    <script src="{{ asset('js/Confetti.js') }}?{{ config('version.hash') }}"></script>


    @yield('extra-meta')
</head>

    @php
        $currentYear = now()->year;
        $currentDate = now();

        // New Year's period
        $newYearStart = Carbon\Carbon::create($currentYear, 1, 1);
        $newYearEnd = Carbon\Carbon::create($currentYear, 1, 2);
        
        // Valentine's period
        $valentinesStart = Carbon\Carbon::create($currentYear, 2, 14);
        $valentinesEnd = Carbon\Carbon::create($currentYear, 2, 15);

        // Championships Weekend
        $championshipsStart = null; // api/champs-dates
        $championshipsEnd = null; // api/champs-dates

        // Calculate Easter Sunday dynamically
        $easter = Carbon\Carbon::createFromTimestamp(easter_date($currentYear));
        $easterStart = $easter->copy()->subWeeks(2);
        $easterEnd = $easter->copy()->addWeek();

        // Halloween period
        $halloweenStart = Carbon\Carbon::create($currentYear, 10, 25);
        $halloweenEnd = Carbon\Carbon::create($currentYear, 11, 1);

        // December snow period
        $snowStart = Carbon\Carbon::create($currentYear, 12, 1);
        $snowEnd = Carbon\Carbon::create($currentYear + 1, 1, 1);
    @endphp

    @if (now()->between($snowStart, $snowEnd))
        <script>
            console.log('Let it snow!');
            document.addEventListener('DOMContentLoaded', () => {

                const snowContainer = document.querySelector('[data-snow-container]');
                if (snowContainer) {
                    console.log('Snow container found:', snowContainer.id);
                    letItSnow(snowContainer.id);
                } else {
                    console.log('No snow container, using full page');
                    letItSnow(); // Fall back to full page
                }
                addCornerImages([
                    { url: '/storage/photos/holiday-photos/christmas-snowman.png', position: 'bottom-right' }
                ], snowContainer ? snowContainer.id : null);
            });
        </script>
    @elseif (now()->between($newYearStart, $newYearEnd))
        <script>
            console.log('Happy New Years!');
            document.addEventListener('DOMContentLoaded', () => {
                const container = document.querySelector('[data-snow-container]');
                throwConfetti(['#FFD700', '#C0C0C0'], 150); // Gold, silver, bronze
                addCornerImages([
                    { url: '/storage/photos/holiday-photos/new-year.png', position: 'bottom-left' }
                ], container ? container.id : null);
            });
        </script>
    @elseif ($currentDate->between($valentinesStart, $valentinesEnd))
        <script>
            console.log('Happy Valentine\'s Day!');
            document.addEventListener('DOMContentLoaded', () => {
                throwConfetti(['#FF69B4', '#FFB6C1', '#FFC0CB'], 150); // Pink theme with more confetti
                const container = document.querySelector('[data-snow-container]');
                addCornerImages(
                    '/storage/photos/valentines/heart-left.png',
                    '/storage/photos/valentines/heart-right.png',
                    container ? container.id : null
                );
            });
        </script>
    @elseif ($championshipsStart && $currentDate->between($championshipsStart, $championshipsEnd))
        <script>
            console.log('Good luck at Championships!');
            document.addEventListener('DOMContentLoaded', () => {
                throwConfetti(['#FFD700', '#C0C0C0', '#CD7F32'], 150); // Gold, silver, bronze
            });
        </script>
    @elseif ($currentDate->between($easterStart, $easterEnd))
        <script>
            console.log('Happy Easter!');
            document.addEventListener('DOMContentLoaded', () => {
                const container = document.querySelector('[data-snow-container]');
                addCornerImages([
                    { url: '/storage/photos/holiday-photos/easter-1.png', position: 'bottom-left' },
                    { url: '/storage/photos/holiday-photos/easter-2.png', position: 'bottom-right' }
                ], container ? container.id : null);
            });
        </script>
    @elseif ($currentDate->between($halloweenStart, $halloweenEnd))
        <script>
            console.log('Happy Halloween!');
            document.addEventListener('DOMContentLoaded', () => {
                const container = document.querySelector('[data-snow-container]');
                addCornerImages(
                    '/storage/photos/holiday-photos/halloween-1.png',
                    '/storage/photos/holiday-photos/halloween-2.png',
                    container ? container.id : null
                );
            });
        </script>
    @endif


    @include('layouts.navigation')


    @yield('content')

    
    <x-layouts.footer>
        <x-layouts.mailing-list></x-layouts.mailing-list>
    </x-layouts.footer>


    @if (session('message'))
        <x-notification-sliver>{{ session('message') }}</x-notification-sliver>
    @endif




    <script>
        let h1 = document.getElementById("head1")
        let h2 = document.getElementById("head2")
        let nav = document.getElementById("navbar")
        let toggle = true

        const runner = () => {
            if (toggle) {
                h1.classList.add('opacity-0')
                h2.classList.remove('opacity-0')
            } else {
                h1.classList.remove('opacity-0')
                h2.classList.add('opacity-0')
            }
            toggle = !toggle
        }

        window.onload = function() {
            console.log('h')
            initMobileNav()
            if (window.scrollY > 50) {
                nav.classList.add('nav-scrolled')
            }

            if (h1 == undefined || h2 == undefined) return

            setInterval(runner, 10000)



        }

        window.onscroll = () => {

            if (window.scrollY > 50) {
                nav.classList.add('nav-scrolled')
            } else {
                nav.classList.remove('nav-scrolled')
            }
        }

        function initMobileNav() {
            let mn = document.getElementById('mobile-nav');
            let mno = document.getElementById('mobile-nav-opener');
            let mnc = document.getElementById('mobile-nav-closer');


            mno.onclick = () => {
                mn.classList.add('open')
            }

            mnc.onclick = () => {
                mn.classList.remove('open')
            }
        }

        initMobileNav();
    </script>
    <script src="{{ asset('js/app.js') }}?{{ config('version.hash') }}"></script>
</body>



</html>
