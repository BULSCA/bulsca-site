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
                    <p class="text-white">Welcome to univeristy lifesaving!</p>
                </div>
            </div>

        </div>


    </div>

    <div class="container-responsive">

        <h1>Welcome</h1>
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
        <h3>Clubs</h3>
        <p>Lifesaving is provided by university clubs through their local branches. We currently have
            <strong>{{ \App\Models\University::where('active', true)->count() }} active clubs</strong> across the UK, and
            were always looking to
            help setup
            more if one isn't available at your university.
            <br>
            You can find a list of our clubs below, as well as links to their pages where you can find out more about
            them.
        </p>
        <br>

        <div class="w-full flex flex-col-reverse md:flex-row ">
            <div class="w-full md:w-[30%]" id="club-cards">

                @foreach (\App\Models\University::where('active', true)->orderBy('name')->get() as $club)
                    <div x-club-name="{{ $club->name }}" x-club-loc="{{ $club->location }}"
                        class="bg-bulsca w-full flex items-center space-x-5 px-5 py-3 hover:scale-x-105 border-y last-of-type:border-b-0 first-of-type:border-t-0 hover:bg-bulsca_red cursor-pointer">


                        <div
                            class="w-5 aspect-square  overflow-hidden flex items-center justify-center pointer-events-none ">
                            <img src="{{ $club->image_path ? route('image', $club->image_path) : '/storage/logo/blogo.png' }}"
                                class="w-full  " alt="">
                        </div>

                        <h5 class="text-white hmb-0 pointer-events-none text-ellipsis overflow-hidden">{{ $club->name }}
                        </h5>

                        <div class="flex  " style="margin-left: auto !important">
                            <a href='{{ route('clubs') }}/{{ Str::lower($club->name) . '.' . $club->id }}' target="_blank"
                                class=" text-white text-xs flex items-center justify-center hover:text-bulsca no-underline ">More
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
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
                <div class="absolute bottom-0 left-0 w-full border-t-2 border-white  bg-bulsca flex items-center px-16"
                    id="map-club-bar"
                    style="display: none; height: {{ (1 / \App\Models\University::count()) * 100 * 1 }}%;">
                    <h3 class="text-white hmb-0">Warwick</h3>
                </div>
            </div>
        </div>
        <br>
        <h3>FAQ</h3>

        <details class="faq">
            <summary>FQ title</summary>
            <p>Content</p>
        </details>

        <br>
        <h3>Gallery</h3>



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

    </div>
@endsection
