@extends('layout')

@section('title')
Championships 2022 | Competitions | 
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
      <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center " >
        <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
        <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
          <h2 class="md:text-6xl text-4xl font-bold text-white">Resources</h2>
          <p class="text-white">Beep boop...</p>
        </div>
      </div>

    </div>

    
  </div>

  

  <div class="container-responsive">
  @foreach ($res as $resSec)

  
      <h3 class="header">{{ $resSec['name'] }}</h3>
      <br>

      <div class="grid md:grid-cols-4 grid-cols-1 gap-4">
      @foreach ($resSec['resources'] as $r)
       <div class="file-link" title='{{ $r["name"] }}'>
            <a href='{{ route("view-resource", $r["id"]) }}' >
                <div>
                    <h3>{{ $r['name'] }}</h3>
                    <small>Click to download</small>
                </div>

                <div >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                </div>
            </a>
        </div>
      @endforeach
      </div>
      <br><hr><br>

            
  @endforeach
  </div>


@endsection