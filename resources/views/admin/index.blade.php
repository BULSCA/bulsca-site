@extends('layouts.adminlayout')

@section('title')
Admin |
@endsection


@section('content')

<div class="container">
    <div class="grid grid-cols-5 gap-6">
        <a href="{{ route('admin.season.view', $currentSeason->id) }}" class="rounded-md no-underline border-2 col-span-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-blue-600 ">
            <div class="flex flex-col ">
                <small class="text-base">Current Season</small>
                <p class=" text-4xl font-bold ">{{ $currentSeason->name }}</p>
                <small class="text-base">{{ $currentSeason->competitions->count() }} Competitions</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>
        <a href="{{ route('admin.competitions') }}" class="rounded-md no-underline border-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-purple-600 ">
            <div class="flex flex-col ">
                <p class=" text-4xl font-bold ">{{ $count['competition'] }}</p>
                <small class="text-base">Competitions</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>
        <a href="{{ route('admin.universities') }}" class="rounded-md no-underline border-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-cyan-400 ">
            <div class="flex flex-col ">
                <p class=" text-4xl font-bold ">{{ $count['uni'] }}</p>
                <small class="text-base">Universities</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>
        </a>
        <a href="{{ route('admin.users') }}" class="rounded-md no-underline border-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-orange-500 ">
            <div class="flex flex-col ">
                <p class=" text-4xl font-bold ">{{ $count['user'] }}</p>
                <small class="text-base">Users</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>

    </div>

    <br>
    <hr>
    <br>
    <h1 class="header">Current Season <a href="{{ route('admin.seasons') }}" class="text-base text-gray-400 hover:text-gray-700">(Previous Seasons)</a></h1>

    <div class="flex flex-row items-center  ">
        @foreach ($currentSeason->competitions()->get() as $comp)
        <div class="flex-1 flex flex-col items-center justify-center">

            <div class="mb-4">
                <a href="{{ route('admin.competition.view', $comp) }}" class="text-xl font-normal no-underline text-black hover:font-semibold hover:underline">{{ $comp->hostUni->name }}</a>
            </div>

            <div class="relative border-t border-gray-300 w-full ">
                <div class="absolute flex w-full bottom-full top-full group items-center justify-center">
                    <span class="competition-status {{ $comp->status->toCSSStatus() }}"></span>

                    <div class="absolute  w-full hidden group-hover:flex items-center justify-center">
                        <div class="bg-white rounded-md p-2 border-2">
                            <p class="text-xs">{{ $comp->status->toStatusMessage() }}</p>
                        </div>
                    </div>
                </div>



            </div>

            <div class="mt-4">
                <p class="text-sm">{{ $comp->when->format('d/m/Y') }}</p>
            </div>





        </div>
        @endforeach

    </div>
    <br>

    <a href="{{ route('admin.season.view', $currentSeason->id) }}">View more about this season</a>

    <br>
    <br>

    <a href="{{ route('admin.resources') }}">View Resources</a>



</div>


@endsection