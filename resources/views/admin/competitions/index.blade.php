@extends('layouts.adminlayout')

@section('title')
Competitions | Admin | 
@endsection


@section('content')

<div class="container">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Competitions</p>


    </div>

    <h1 class="header">Competitions</h1>

    <div class="grid grid-cols-2 gap-4">
        @foreach ($competitions as $comp)
        <a href="{{ route('admin.competition.view', $comp) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h1 class="header header-bold">
                    {{ $comp->getName() }}
                </h1>
                <small class="ml-auto mb-4 text-black font-normal ">{{ $comp->when->format('d/m/Y') }}</small>
            </div>
            <hr class="-mx-6 mb-4">
            <div>
                <x-badge>League: {{ $comp->currentSeason->name }}</x-badge>
                
            </div>
        </a>
            
        @endforeach
    </div>

    {{ $competitions->links() }}

   

</div>


@endsection
