@extends('layout')

@section('title')
    {{ $club->name }} | Clubs |
@endsection

@section('meta')
    {{ Str::of(html_entity_decode(str_replace('  ', ' ', strip_tags(str_replace('<', ' <', $club->getPage()->first()->content)))))->squish()->limit(170) }}
@endsection

@section('extra-meta')
    <meta property="og:type" content="article" />
    <meta property="og:image"
        content="{{ $club->image_path ? route('image', $club->image_path) : '/storage/logo/blogo.png' }}">
@endsection


@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full  flex items-center justify-center "
                style=" background-color: {{ $club->getPage()->first()->banner_color }}">
                <img src="{{ $club->image_path ? route('image', $club->image_path) : 'https://bulsca.co.uk/storage/logo/blogo.png' }}"
                    class="w-[10%] hidden md:block " alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h2 class="md:text-6xl text-4xl font-bold text-white"
                        style="color: {{ $club->getPage()->first()->banner_text_color }}">{{ $club->name }}</h2>


                </div>
            </div>

        </div>


    </div>

    <div class="container-responsive flex flex-col space-y-4">

        <link rel="stylesheet" href="{{ asset('css/ck_styles.css') }}">



        <div class="flex flex-row items-center justify-between w-full">
            <a href="{{ route('clubs') }}" class=" underline ">Back</a>

            <div class="flex space-x-2 items-center justify-center  ">
                @if ($club->website)
                    <a href="//{{ $club->website }}" target="_blank" rel="noopener noreferrer"
                        title="{{ $club->name }}'s Website" class="hover:scale-105 transition-transform ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-9">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>

                    </a>
                @endif

                @if ($club->instagram)
                    <a href="https://instagram.com/{{ $club->instagram }}" target="_blank" rel="noopener noreferrer"
                        title="{{ $club->name }}'s Instagram" class=" hover:scale-105 transition-transform  text-bulsca">
                        <img src="/storage/logo/Instagram_Glyph_Gradient_RGB.png" class="w-12 h-12" alt="">
                    </a>
                @endif

                @if ($club->facebook)
                    <a href="https://facebook.com/{{ $club->facebook }}" target="_blank" rel="noopener noreferrer"
                        title="{{ $club->name }}'s Facebook" class=" hover:scale-105 transition-transform  text-bulsca">
                        <img src="/storage/logo/f_logo_RGB-Blue_1024.png" class="w-12 h-12" alt="">
                    </a>
                @endif
            </div>

            @if ($club->currentUserIsClubAdmin() || (auth()->user() && auth()->user()->can('admin.universities.manage')))
                <a href="{{ url()->current() }}/edit" class="btn btn-thinner ">Edit</a>
            @endif
        </div>



        <div class="main-container">

            <div class="ck-content">
                {!! $club->getPage()->first()->content ?? '' !!}
            </div>

        </div>




        @if ($club->location != null)
            @php
                $splt = explode(',', $club->location);
                $lat = $splt[0];
                $long = $splt[1];

            @endphp
            <div id="map" x-long="{{ $lat }}" x-lat="{{ $long }}"
                style="width: 100%; height: 400px; display: none"></div>
        @endif

    </div>
@endsection
