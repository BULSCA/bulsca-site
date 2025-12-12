@extends('layout')

@section('title')
    {{ $casualty->name }} | Casualties | Resources |
@endsection

@section('extra-meta')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')
    <x-page-banner
        title="{{ $casualty->name }}"
        subtitle="{{ $casualty->getCasualtyGroup->name }}"
        :snowContainer="true"
    />



    <div class="container-responsive">

        @if (count($images) > 0)
            @php
                $cols = 'grid-cols-3';

                if (count($images) == 1) {
                    $cols = 'grid-cols-1';
                } elseif (count($images) == 2) {
                    $cols = 'grid-cols-2';
                }
            @endphp

            <div class="grid {{ $cols }} gap-3 grid-rows-1">

                @foreach ($images as $image)
                    <div
                        class="flex items-center justify-center overflow-hidden rounded-md aspect-video relative group mb-2 w-full max-h-[30vh] min-w-[33%]">
                        <img src="{{ $image }}" class="w-full " alt="">
                    </div>
                @endforeach

            </div>
            <br>
        @endif
        <h1>{{ $casualty->name }}</h3>


            <div class="prose max-w-none ck-content prose-li:my-0">

                {!! $casualty->description !!}

            </div>


            @php
                $sercs = $casualty->getAssociatedSercs();
            @endphp

            @if ($sercs->count() > 0)
                <br>
                <hr>
                <br>
                <h2>Associated SERCs</h2>
                <div class="w-full grid grid-cols-1 lg:grid-cols-2 3xl:grid-cols-3 gap-4 flex-grow-0 items-start">

                    @foreach ($casualty->getAssociatedSercs() as $serc)
                        <a href="{{ route('resources.sercs') }}?open={{ $serc->id }}"
                            class="border rounded-md px-3 py-4 cursor-pointer hover:border-black hover:shadow-md group no-underline">
                            <h5 class="mb-0 line-clamp-1 group-hover:line-clamp-none">{{ $serc->name }}
                            </h5>
                            <div class="flex justify-between text-gray-400">
                                <small>{{ $serc?->author ?? 'Unknown' }}</small>

                                <div class="flex space-x-2">
                                    <small class="flex items-center justify-center space-x-0"
                                        title="# Casualties">{{ $serc?->casualties ?? '-' }} <svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                            class="w-4 h-4">
                                            <path
                                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                        </svg>

                                    </small>
                                </div>


                            </div>

                            <p class="mt-1 mb-2 line-clamp-3 !text-black font-normal"
                                x-text="serc.description ? serc.description : '-'">
                                {{ $serc->description }}
                            </p>


                            <div class="overflow-x-auto flex flex-row whitespace-nowrap thin-scrollbar">

                                <span class="badge badge-warning">{{ $serc->when->format('d/m/y') }}</span>
                                <span class="badge badge-warning">{{ $serc->where }}</span>

                                @foreach ($serc->tags as $tag)
                                    <span class="badge badge-info">{{ $tag->name }}</span>
                                @endforeach

                            </div>
                        </a>
                    @endforeach
                </div>
            @endif



    </div>
@endsection
