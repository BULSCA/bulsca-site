@extends('layout')

@section('title')
RLSS Competitions |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">RLSS Competitions</h2>
        <p class="text-white">More opportunities to do lifesaving!</p>
      </div>
    </div>

  </div>


</div>
<x-alert-banner />

{{-- External Link Section --}}
<div class="container mx-auto mt-6 text-center">
    <p class="text-gray-600 text-lg mb-4">
        Clicking the button below will take you to an external site.
    </p>
    <a href="https://www.rlss.org.uk/nationals-regional-heats" target="_blank" 
       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
        Go to 'RLSS Regional Heats'
    </a>
</div>

@endsection