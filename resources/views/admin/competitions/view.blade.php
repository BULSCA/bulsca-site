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

    <p>
        The aim is for alot of information to show her about the competition:
        <br>
        Location, Times, Max teams, pool details, venue details, costs, max people, social (loc price, etc), food (type, price)
        <br><br>
        Also show all the universities associated with the competition and if they have paid, numbers per uni, teams, etc
    </p>

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
