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
      @if (auth()->user()->home_uni)
        Associated with {{ auth()->user()->getHomeUni()->name }} University
      @else
        No Associated University!
      @endif
    </small>

    <hr class="my-5">

    <h1 class="header header-smallish">
      Your Competitions
    </h1>
    <div class="grid grid-cols-4 gap-x-4 gap-y-3">
      @forelse ($myCompetitions as $comp)
      <div class="rounded-lg  border overflow-hidden  flex justify-between items-center ">
        <div class="flex flex-col m-4">
          <h2 class="header header-small">
            {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}
          </h2>
          <small class="text-gray-500 -mt-2">{{ $comp->when->format('d/m/Y') }}</small>
        </div>

      
          <a href="{{ route('lc-manage', $comp->id) }}" class="bg-bulsca hover:bg-bulsca_red transition-colors text-white no-underline  p-4 h-full flex items-center justify-center ">
            Manage
          </a>
        
      </div>
      @empty
      <p>You aren't hosting any competitions!</p>
      @endforelse
    </div>

    
    <hr class="my-5">

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