@extends('layout')

@section('title')
{{ $club->name }} | Clubs |
@endsection



@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="{{ $club->image_path ? route('image', $club->image_path) : '/storage/logo/blogo.png' }}" class="w-[10%] hidden md:block " alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">{{ $club->name }}</h2>


      </div>
    </div>

  </div>


</div>

<div class="container-responsive flex flex-col space-y-4">



  <div class="flex flex-row items-center">
    <a href="{{ route('clubs') }}" class=" underline ">Back</a>
    @if ($club->currentUserIsClubAdmin() || (auth()->user() && auth()->user()->can('admin.universities.manage')))

    <a href="{{ url()->current() }}/edit" class="btn btn-thinner ml-auto">Edit</a>

    @endif
  </div>


  {!! $club->getPage()->first()->content ?? '' !!}

</div>




@endsection