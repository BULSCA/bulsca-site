@extends('layout')

@section('title')
    {{ $club->name }} | Clubs | 
@endsection



@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
      <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center " >
        <img src="/storage/clubs/logos/{{ $club->id }}.png" class="w-[10%] " alt="">
        <div class="border-l-2 border-white ml-12 pl-12 py-8">
          <h2 class="text-6xl font-bold text-white">{{ $club->name }}</h2>
          
       
        </div>
      </div>

    </div>

    
  </div>

  <div class="mx-2 md:mx-[20%] my-[2%] flex flex-col items-center">
    <a href="{{ url()->current() }}/edit" class="btn btn-thinner">Edit</a>
  </div>

  <div class="mx-2 md:mx-[20%] my-[2%] flex flex-col items-center">
      {!! $club->getPage()->first()->content ?? '' !!}
  </div>


@endsection