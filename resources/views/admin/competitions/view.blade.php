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

    <h1 class="header" style="margin-bottom: 0 !important;">{{ $competition->getName() }} </h1>
    <a href="#" class="text-gray-500 no-underline text-sm font-normal hover:underline hover:text-gray-800 hover:font-semibold">{{ $competition->currentSeason->name }}</a>

    <h2 class="header header-small">{{ $competition->when->format('D dS M Y') }}</h2>

    <p class="my-4">
        
        {{ $competition->getInfo && $competition->getInfo->desc ?: 'No description available yet'}}
    </p>


    <div class="grid grid-cols-4 gap-4">
        <div class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h1 class="header header-smallish header-bold" >
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
                <iframe  class="w-full h-44"  id="gmap_canvas" src="https://maps.google.com/maps?q={{ $competition->getInfo->isolation_information['location'] }}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            @else
                    N/A
            @endif
 
        
        </div>

        <div class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h1 class="header header-smallish header-bold" >
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
                <iframe  class="w-full h-44"  id="gmap_canvas" src="https://maps.google.com/maps?q={{ $competition->getInfo->pool_information['location'] }}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            @else
                    N/A
            @endif
        
        </div>
    </div>

    <hr class="my-8">



  
    

    <div>
        <h1 class="header">Competition Details</h1>
        <form action="{{ route('admin.competition.edit', $competition) }}" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input id='when' type="datetime-local" title='When' defaultValue='{{ $competition->when }}' />
         


            <button type="submit" class="btn btn-thinner btn-save row-start-2 col-start-4">Save</button>
        </form>
    </div>

</div>


@endsection
