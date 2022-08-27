@extends('layouts.adminlayout')

@section('title')
{{ $competition->getName() }} | Competitions | Admin |
@endsection


@section('content')

<div class="container">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.competitions') }}">Competitions</a>
        <span>></span>
        <p>{{ $competition->getName() }}</p>

    </div>

    <a href="{{ route('admin.season.view', $competition->currentSeason) }}" class="text-gray-500 no-underline text-sm font-normal hover:underline hover:text-gray-800 hover:font-semibold">{{ $competition->currentSeason->name }}</a>
    <h1 class="header -mt-1" style="margin-bottom: 0 !important;">{{ $competition->getName() }} </h1>
    <small class="text-bulsca_red no-underline text-sm font-semibold">{{ $competition->when->format('D dS M Y') }} </small>



    <p class="my-4">

        {{ $competition->getInfo && $competition->getInfo->desc ?: 'No description available yet'}}
    </p>


    <div class="grid grid-cols-4 gap-4 hidden">
        <div class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h1 class="header header-smallish header-bold">
                    Isolation
                </h1>
                <small class="ml-auto  text-black font-normal "></small>

            </div>
            <hr class="-mx-6 mb-4">
            <h2 class="header header-small">
                Times
            </h2>
            <p class="mb-4">
                <span class="font-semibold">Open:</span> {{ $competition->getInfo && $competition->getInfo->isolation_information['times']['open'] ?: 'N/A'}} <br>
                <span class="font-semibold">Close:</span> {{ $competition->getInfo && $competition->getInfo->isolation_information['times']['close'] ?: 'N/A' }}
            </p>
            <h2 class="header header-small">
                Location

            </h2>

            @if ($competition->getInfo)
            <p>
                {{ $competition->getInfo->isolation_information['location'] ?: 'N/A' }}
            </p>
            <iframe class="w-full h-44" id="gmap_canvas" src="https://maps.google.com/maps?q={{ $competition->getInfo->isolation_information['location'] }}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            @else
            N/A
            @endif


        </div>

        <div class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h1 class="header header-smallish header-bold">
                    Pool
                </h1>
                <small class="ml-auto  text-black font-normal "></small>

            </div>
            <hr class="-mx-6 mb-4">
            <h2 class="header header-small">
                Times
            </h2>
            <p class="mb-4">
                <span class="font-semibold">Start:</span> {{ $competition->getInfo && $competition->getInfo->pool_information['times']['start'] ?: 'N/A'}} <br>
                <span class="font-semibold">Finish:</span> {{ $competition->getInfo && $competition->getInfo->pool_information['times']['finish'] ?: 'N/A' }}
            </p>
            <h2 class="header header-small">
                Location

            </h2>
            @if ($competition->getInfo)
            <p>
                {{ $competition->getInfo->pool_information['location'] ?: 'N/A'}}
            </p>
            <iframe class="w-full h-44" id="gmap_canvas" src="https://maps.google.com/maps?q={{ $competition->getInfo->pool_information['location'] }}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            @else
            N/A
            @endif

        </div>
    </div>

    <hr class="my-8">






    <div>
        <h1 class="header">Competition Details</h1>
        <form action="@can('admin.competitions.manage'){{ route('admin.competition.edit', $competition) }}@endcan" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input deny="{{ auth()->user()->cannot('admin.competitions.manage') }}" id='when' type="datetime-local" title='When' defaultValue='{{ $competition->when }}' />


            @can('admin.competitions.manage')
            <button type="submit" class="btn btn-thinner btn-save row-start-2 col-start-4">Save</button>
            @endcan
        </form>
    </div>

    <div>
        <h2>Delete</h2>
        @can('admin.competitions.delete')
        <p>This <strong>CANNOT</strong> be undone!</p>
        <form action="{{ route('admin.competitions.delete') }}" onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="hidden" class="hidden" name="id" value="{{ $competition->id }}"></input>
            <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
        </form>
        @else
        <p>You aren't able to delete this competition, please contact the Data Manager!</p>
        @endcan
    </div>

</div>


@endsection