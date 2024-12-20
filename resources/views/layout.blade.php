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

    @yield('extra-meta')
</head>

<body class="overflow-x-hidden flex flex-col min-h-screen">
    <script>
        letItSnow()
    </script>


    @include('layouts.navigation')


    @yield('content')


    <div class=" container-responsive  ">
        <div class="grid md:grid-cols-2 grid-cols-1">
            <div class="flex flex-col">
                <h2 class="header">Join the mailing list</h2>
                <form
                    action="https://bulsca.us15.list-manage.com/subscribe/post?u=1b1c9887c1e5ff377f6979e66&amp;id=94c67a5f8d&amp;f_id=00738de0f0"
                    method="post" class="flex flex-col  overflow-hidden">

                    <input type="text"
                        class="border-b-2 border-red-500 text-xl   p-2  my-2 hover:outline-none focus:outline-none"
                        name="EMAIL" placeholder="swimming@bulsca.co.uk">
                    <input type="text" name="b_1b1c9887c1e5ff377f6979e66_94c67a5f8d" tabindex="-1" value=""
                        class="hidden" hidden>
                    <input type="checkbox" id="gdpr_3427" name="gdpr[3427]" value="Y" checked class="hidden"
                        hidden>
                    <small class="my-2 mb-3">
                        By clicking below I acknowledge that BULSCA will send me emails about relevant events and news.
                        You may opt out anytime by clicking <strong>unsubscribe</strong> in any email!
                    </small>
                    <button submit class="btn">Sign me up!</button>
                </form>

                <br>
                <br>

            </div>
            <div class="flex justify-center items-center">
                <iframe
                    src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FBULSCA%2F&tabs=timeline&width=340&height=271&small_header=true&adapt_container_width=false&hide_cover=false&show_facepile=true&appId"
                    width="340" height="271" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                    allowfullscreen="true"
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </div>
        </div>
    </div>



    <footer class="bg-black w-full flex flex-col items-center justify-center mt-auto">
        <div class="p-6 px-32 flex flex-row items-center justify-center space-x-4">

            <a href="https://www.facebook.com/BULSCA/" rel="noopener noreferrer" target="_blank"><img
                    src="/storage/logo/f_logo_RGB-Blue_1024.png" loading="lazy" class="w-12 h-12" alt=""></a>
            <a href="https://www.instagram.com/bulsca" rel="noopener noreferrer" target="_blank"><img
                    src="/storage/logo/Instagram_Glyph_Gradient_RGB.png" loading="lazy" class="w-12 h-12"
                    alt=""></a>

        </div>
        <small class="text-white pb-4 divide-x ">
            <a class="text-white font-normal no-underline hover:underline pr-1"
                href="{{ route('contact') }}">Contact</a>
            <a class="text-white font-normal no-underline hover:underline pl-2"
                href="{{ route('welfare') }}">Welfare</a>
        </small>
    </footer>


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
