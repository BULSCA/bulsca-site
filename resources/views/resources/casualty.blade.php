@extends('layout')

@section('title')
    {{ $casualty->name }} | Casualties | Resources |
@endsection

@section('extra-meta')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
                <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h2 class="md:text-6xl text-4xl font-bold text-white">{{ $casualty->name }}</h2>
                    <p class="text-white">{{ $casualty->getCasualtyGroup->name }}</p>
                </div>
            </div>

        </div>


    </div>



    <div class="container-responsive">


        @php
            $cols = 'grid-cols-3';

            if (count($images) == 1) {
                $cols = 'grid-cols-1';
            } elseif (count($images) == 2) {
                $cols = 'grid-cols-2';
            }
        @endphp

        <div class="grid {{ $cols }} gap-3 ">

            @foreach ($images as $image)
                <div
                    class="flex items-center justify-center overflow-hidden rounded-md aspect-video relative group mb-2 w-full max-h-[30vh]">
                    <img src="{{ $image }}" class="w-full " alt="">
                </div>
            @endforeach

        </div>
        <br>
        <h1>{{ $casualty->name }}</h3>


            <div class="prose max-w-none ck-content prose-li:my-0">

                {!! $casualty->description !!}

            </div>




    </div>
@endsection
