@extends('layout')

@section('title')
Championships 2022 | Competitions | 
@endsection

@section('content')

  <x-page-banner
      title="Resources"
      subtitle="Beep boop..."
      :snowContainer="true"
  />

  <div class="container-responsive">
  @foreach ($res as $resSec)

  
      <h3 class="header">{{ $resSec['name'] }}</h3>
      <br>

      <div class="grid md:grid-cols-4 grid-cols-1 gap-4">
      @foreach ($resSec['resources'] as $r)
       <x-resource-download :file="$r" /> 


      @endforeach
      </div>
      <br><hr><br>

            
  @endforeach
  </div>


@endsection