@extends('layout')

@section('title')
    Clubs |
@endsection

@section('meta')
    BULSCA is home to clubs all across Britain, and they all come together to form BULSCA.
@endsection

@section('content')
    <x-page-banner
        title="Clubs"
        subtitle="🏊"
        :snowContainer="true"
    />

    <div class="container-responsive ">
        <h1 class="header">Active Clubs </h1>
        <p>
            The following are all the actively competing clubs in BULSCA, click on one to find out more!
        </p>
    </div>

    <div class=" container-responsive ">

        <div class=" grid md:grid-cols-2 xl:grid-cols-3 grid-cols-1 text-center">

            @foreach ($clubs as $club)
                <a href='{{ route('clubs') }}/{{ Str::lower($club->name) . '.' . $club->id }}'
                    class="grid grid-cols-3 gap-8 group hover:bg-bulsca_red hover:bg-opacity-20 even:bg-bulsca even:bg-opacity-10 px-6 py-2 cursor-pointer  transition-colors no-underline">


                    <div class="col-span-2  flex flex-col items-start justify-center ">
                        <h3 class="text-left">
                            {{ $club->name }}
                        </h3>
                        <small>
                            Click to view more
                        </small>
                    </div>

                    <div class="aspect-square  overflow-hidden flex items-center justify-center ">
                        <img src="{{ $club->image_path ? route('image', $club->image_path) : '/storage/logo/blogo.png' }}"
                            class=" " alt="">
                    </div>

                </a>
            @endforeach



        </div>
    </div>

    <br>
@endsection
