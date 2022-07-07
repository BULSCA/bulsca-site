@extends('layout')

<div class="h-[30vh] w-screen bg-gray-100  overflow-hidden  ">

<div class="h-full w-full overflow-hidden relative">
  <div class="absolute top-0 right-0 w-full h-full head-bg flex items-center justify-center transition-opacity   duration-1000" id="head1">
    <img src="./storage/logo/blogo.png" class="md:w-[12.5%] w-[50%] h-auto" alt="">
  </div>
  <div class="absolute top-0 right-0 w-full h-full head-bg-2 flex items-center justify-center transition-opacity opacity-0 duration-1000 z-20" id="head2">
    <img src="./storage/logo/blogo.png" class="md:w-[12.5%] w-[50%] h-auto" alt="">
  </div>
</div>


</div>

@php
  $title = 'Error '.$error_number;
@endphp


@section('content')
<div class="container py-16">
  <div class="text-center">
    <div class=" text-5xl text-bulsca_red ">
      {{ $error_number }}
      
    </div>
    <br>
    <div class="text-7xl text-bulsca text-bold">
      @yield('title')
    </div>
    <div class="error_description text-muted">
      <small>
        @yield('description')
     </small>
    </div>
  </div>
</div>
@endsection