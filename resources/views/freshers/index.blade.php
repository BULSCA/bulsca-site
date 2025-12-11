@extends('layout')

@section('title')
    Freshers |
@endsection

@section('extra-meta')

@section('content')

    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full  flex  items-center justify-center head-bg-3  "
                style="background-image: linear-gradient(rgba(0, 0, 0, 0.25),
                       rgba(0, 0, 0, 0.25)), url('storage/photos/freshers/fresher_banner.jpeg');  ">
                <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h1 class="md:text-6xl text-4xl font-bold text-white">Freshers</h1>
                    <p class="text-white">Welcome to university lifesaving!</p>
                </div>
            </div>

        </div>


    </div>

    <div class="container-responsive">

        <h1>Welcome</h1>
        <div class="-mt-3 text-gray-500 text-sm mb-1 indent-3">Jump to: <a href="#clubs"
                class="text-gray-500 hover:text-gray-800">Clubs</a>, <a href="#gallery"
                class="text-gray-500 hover:text-gray-800">Gallery</a>, <a href="#faq"
                class="text-gray-500 hover:text-gray-800">FAQ</a></div>
        <p>
            to the British Universities Lifesaving Clubs Association (BULSCA) Freshers' page! We are the national governing
            body for university lifesaving clubs in the UK. We are here to help you find your nearest university lifesaving
            club, and to provide you with all the information you need to get involved in lifesaving at university.
        </p>

        <br>
        <h3>Lifesaving?</h3>
        <p>
            Lifesaving is a sport that combines swimming, lifesaving and first aid. It is a fun and sociable sport that
            provides a great way to keep fit and make new friends. Lifesaving is a great way to develop your swimming, first
            aid skills, and to learn how to save lives. as well as a great way to get involved in university life and to try
            something new.
            <br>
            Check out the video below from the Royal Life Saving Society UK to find out more about lifesaving.
        </p>
        <br>
        <div class="w-full flex justify-center relative">
            {{-- <div class="absolute w-[90%] h-full flex items-center justify-center" style="background-image: url('https://img.youtube.com/vi/5Jz1vySXorw/maxresdefault.jpg'); background-repeat: no-repeat; background-size: cover;">
 
        </div> --}}
            <iframe class="w-[90%] aspect-video"
                src="https://www.youtube-nocookie.com/embed/5Jz1vySXorw?si=RaieqnAttSfZUdNE" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>

        <br>
        <h3 id="clubs" class=" scroll-mb-[35rem]">Clubs</h3>
        <p>Lifesaving is provided by university clubs through their local branches. We currently have
            <strong>{{ \App\Models\University::where('active', true)->count() }} active clubs</strong> across the UK, and
            were always looking to
            help setup
            more if one isn't available at your university.
        </p>
        <br>
        <p>
            You can find a list of our clubs below, clicking one will update the map and show you when their Freshers Fayre
            is. To find out more about a club, click the
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" style="display: inline; vertical-align: text-bottom;" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            button.
        </p>
        <br>



        <div class="w-full flex flex-col-reverse md:flex-row space-x-2">
            <div class="w-full md:w-[30%]" id="club-cards">

                @foreach (\App\Models\University::where('active', true)->orderBy('name')->get() as $club)
                    <div
                        x-club-name="{{ $club->name }}"
                        x-club-loc="{{ $club->location }}"
                        class="bg-bulsca w-full flex items-center space-x-5 hover:scale-x-105 border-y last-of-type:border-b-0 first-of-type:border-t-0 hover:bg-bulsca_red cursor-pointer"
                    >
                        <div class="flex items-center space-x-3 pl-3 py-3 flex-1">
                            <div class="size-8 overflow-hidden flex items-center justify-center pointer-events-none">
                                <img src="{{ $club->image_path ? route('image', $club->image_path) : '/storage/logo/blogo.png' }}"
                                    class="w-full" alt="">
                            </div>
                            <h5 class="text-white mb-0 pointer-events-none text-ellipsis overflow-hidden">{{ $club->name }}</h5>
                        </div>

                        <div class="flex  " style="margin-left: auto !important">
                            <a href="{{ route('clubs') }}/{{ Str::lower($club->name) . '.' . $club->id }}" target="_blank"
                                class=" text-white flex items-center justify-center hover:text-bulsca transition-colors  no-underline p-3 ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="relative flex flex-grow z-20 bg-white h-[500px] md:h-auto w-full">
                <div id="club-map" style="width: 100%; height: 100%; "
                    x-locations="{{ \App\Models\University::where('active', true)->orderBy('name')->whereNotNull('location')->get(['name', 'id', 'location'])->toJson() }}">
                </div>
                <div class="absolute bottom-0 left-0  w-[40%]  border-t-2 border-white  bg-bulsca flex items-center px-2"
                    id="map-club-bar"
                    style="display: none; height: {{ (1 / \App\Models\University::count()) * 100 * 1 }}%;">
                    <p class="text-white text-sm hmb-0 leading-[1.125rem]">Freshers Fayre:
                        <br>Sports Hub, 11AM-5PM, 01/09/24
                    </p>
                </div>
            </div>
        </div>
        <br>

        <h3 id="gallery" class=" scroll-mb-[35rem]">Gallery</h3>



        <div class="grid-3">
            <div class=" w-full max-h-80  overflow-hidden flex items-center justify-center">
                <img src="storage/photos/freshers/freshers (1).jpeg" loading="lazy" class=" " alt="">
            </div>
            <div class=" w-full max-h-80 overflow-hidden flex items-center justify-center">
                <img src="storage/photos/freshers/freshers (2).jpeg" loading="lazy" class="w-full" alt="">
            </div>
            <div class=" w-full max-h-80 overflow-hidden flex items-center justify-center">
                <img src="storage/photos/freshers/freshers (3).jpeg" loading="lazy" class="w-full" alt="">
            </div>
            <div class=" w-full max-h-80 overflow-hidden flex items-center justify-center">
                <img src="storage/photos/freshers/freshers (4).jpeg" loading="lazy" class="w-full" alt="">
            </div>
            <div class=" w-full max-h-80 overflow-hidden flex items-center justify-center">
                <img src="storage/photos/freshers/freshers (5).jpeg" loading="lazy" class="w-full" alt="">
            </div>
            <div class=" w-full max-h-80 overflow-hidden flex items-center justify-center">
                <img src="storage/photos/freshers/freshers (6).jpeg" loading="lazy" class="w-full" alt="">
            </div>
            <div class=" w-full max-h-80 overflow-hidden flex items-center justify-center">
                <img src="storage/photos/freshers/freshers (7).jpeg" loading="lazy" class="w-full" alt="">
            </div>
            <div class=" w-full max-h-80 overflow-hidden flex items-center justify-center">
                <img src="storage/photos/freshers/freshers (8).jpeg" loading="lazy" class="w-full" alt="">
            </div>
        </div>

        <br>
        <h3 id="faq" class=" scroll-mb-[35rem]">FAQ</h3>

        <details class="faq">
            <summary>Do I need to be able to swim?</summary>
            <p>Sort of. On the first aid side you don't need to be able to swim at all. However, on the swimming side we
                recommend that you can swim at least one length (25m) of a pool without stopping.</p>
        </details>
        <details class="faq">
            <summary>Is this the same as Lifeguarding?</summary>
            <p>Lifesaving crosses with Lifeguarding in many ways, however its also different in that we regularly train,
                compete and hold socials within individual clubs and across competitions. It an excellent way to maintain
                your lifeguarding skills or become one, with clubs running NPLQ's all year round.</p>
        </details>
        <details class="faq">
            <summary>There isn't a club at my university?</summary>
            <p>We're sorry to hear that, but if you get in touch with our Club Development manager they can help you to find
                a local club, or organise the process of setting up a club with your univesity and local RLSS branch. You
                can contact the CLub Development manager at <a
                    href="mailto:clubdevelopment@bulsca.co.uk">clubdevelopment@bulsca.co.uk</a></p>
        </details>
        <details class="faq">
            <summary>I have a disability / long term health condition, is lifesaving accessible to me?</summary>
            <p>Yes, we strive to make lifesaving inclusive to all and can implement reasonable adjustments to ensure your
                access. Please check out the welfare page of the website and if you have any questions reach out to our
                friendly welfare officer at <a href="mailto:welfare@bulsca.co.uk">welfare@bulsca.co.uk</a></p>
        </details>

        <script>
            // when opening a detials close all the others
            document.querySelectorAll('details').forEach((item) => {
                item.addEventListener('click', () => {
                    if (!item.open) {

                        document.querySelectorAll('details').forEach((item) => {
                            if (item !== event.target) {
                                item.open = false;
                            }
                        })
                    }
                })
            })
        </script>




    </div>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            });
        });
    </script>
@endsection
