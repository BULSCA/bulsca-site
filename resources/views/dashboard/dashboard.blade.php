@extends('layouts.dashlayout')

@section('title')
Dashboard | 
@endsection

@section('nav-extra')
nav-scrolled
@endsection

@section('content')



  <div class="container-responsive">
    <h1 class="header" style='margin-bottom: -.25em !important' ><span style="font-size: 0.5em !important">Hello</span></h1>
    <h1 class=" header  " style='margin-bottom: -.25em !important' ><span class="text-bulsca_red font-bold">{{ auth()->user()->name }}</span></h1>
    <small class="">
      @if (auth()->user()->getHomeUni())
        Associated with {{ auth()->user()->getHomeUni()->name }} University
        @if (auth()->user()->isUniAdmin(auth()->user()->getHomeUni()->id))
          <small>(Admin)</small>
        
          
        @endif
      @else
        No Associated University!
      @endif
    </small>

    <hr class="my-5">

    @if (auth()->user()->isUniAdmin(auth()->user()->getHomeUni()->id))
      
    
    <h1 class="header header-smallish">
      Your Competitions
    </h1>
    <div class="grid grid-cols-4 gap-x-4 gap-y-3">
      @forelse ($myCompetitions as $comp)
      <div class="relative rounded-lg  border   flex justify-between items-center ">

        @if ($comp->alert)
        <div class="absolute top-0  left-0"  title="{{ $comp->alert_message }}" >
          <svg xmlns="http://www.w3.org/2000/svg" class="text-red-500 -ml-[50%] -mt-[50%] rounded-full overflow-hidden w-7 h-7"viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
       
        </div>
          
        @endif

        <div class="flex flex-col m-4">
          <h2 class="header header-small">
            {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}
          </h2>
          <small class="text-gray-500 -mt-2">{{ $comp->when->format('d/m/Y') }}</small>
        </div>

      
          <a href="{{ route('lc-manage', $comp->id) }}" class="bg-bulsca hover:bg-bulsca_red transition-colors text-white no-underline  p-4 h-full flex items-center justify-center rounded-r-md ">
            Manage
          </a>
        
      </div>
      @empty
      <p>You aren't hosting any competitions!</p>
      @endforelse
    </div>

    
    <hr class="my-5">
    @endif

    <h1 class="header header-smallish">
      Upcoming Competitions
    </h1>
    <div class="grid grid-cols-4 gap-x-4 gap-y-3">
      @forelse ($upcoming as $comp)
      <div class="rounded-lg  border overflow-hidden  flex justify-between items-center ">
        <div class="flex flex-col m-4">
          <h2 class="header header-small">
            {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}
          </h2>
          <small class="text-gray-500 -mt-2">{{ $comp->when->format('d/m/Y') }}</small>
        </div>

      
          <a href="{{ route('lc-view', $comp->id) }}" class="bg-bulsca hover:bg-bulsca_red transition-colors text-white no-underline  p-4 h-full flex items-center justify-center ">
            View
          </a>
        
      </div>
      @empty
      <p>There are no upcoming competitions!</p>
      @endforelse
    </div>
  </div>







@endsection