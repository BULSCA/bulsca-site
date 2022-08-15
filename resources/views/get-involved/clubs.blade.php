@extends('layout')

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
      <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center " >
        <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
        <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
          <h2 class="md:text-6xl text-4xl font-bold text-white">Clubs</h2>
          <p class="text-white">🏊</p>
        </div>
      </div>

    </div>

    
  </div>

<div class="container-responsive ">
<h1 class="header">Active Clubs </h1>
    <p>
        The following are all the actively competing clubs in BULSCA, click on one to find out more!
    </p>
</div>

  <div class=" container-responsive ">

    <div class=" grid md:grid-cols-3 grid-cols-1 text-center">

        @foreach ($clubs as $club)
        <a href='{{ route("clubs") }}/{{ Str::lower($club->name) . "." . $club->id }}' class="grid grid-cols-3 gap-8 group hover:bg-bulsca_red hover:bg-opacity-20 even:bg-bulsca even:bg-opacity-10 px-6 py-2 cursor-pointer  transition-colors no-underline">
          

          <div class="col-span-2  flex flex-col items-start justify-center ">
              <h1 class="header ">
                  {{ $club->name }}
              </h1>
              <small>
                  Something else here
              </small>
          </div>

          <div class="aspect-square  overflow-hidden flex items-center justify-center ">
            <img src="{{ $club->image_path ? route('image', $club->image_path) : '/storage/logo/blogo.png' }}" class=" " alt="">
          </div>
          
      </a>
            
        @endforeach



    </div>
  </div>

  <br>




@endsection