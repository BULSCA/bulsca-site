@extends('layouts.dashlayout')

@section('title')
Dashboard | 
@endsection

@section('nav-extra')
nav-scrolled
@endsection

@section('content')



  <div class="container-responsive">
    <h1 class="header" style='margin-bottom: -.25em !important' ><span style="font-size: 0.5em !important">Competitions</span></h1>
    <h1 class=" header  " style='margin-bottom: -.25em !important' ><span class="text-bulsca_red font-bold">{{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}</span></h1>
    <small class="">
      {{ $comp->when->format('d/m/Y @ h:m A') }}
    </small>

    

  </div>

  <div class="container-responsive">
      <h1 class="header header-smallish">Results</h1>
      @if ($comp->getResultsResource()->first())
      <div class="flex items-center space-x-4">
        <x-resource-download :file="$comp->getResultsResource()->first()" /> 

      </div>
        
        

        @else
        <p>Results aren't currently available!</p>
    
      @endif



  </div>







@endsection