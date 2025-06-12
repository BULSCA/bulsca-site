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
<div class="container-boast">
  <div>
    <h1 class="header-white header header-bold uppercase mb-2">Whats different about an RLSS competition? </h1>
    <p class="text-white">
        RLSS competitions are run by the Royal Life Saving Society UK and are open to all lifesavers, not just BULSCA members.  These competitions are a great way to gain experience, improve your skills, and meet other lifesavers from different clubs and regions.
    </p>
  </div>


</div>

<div class=" container-responsive ">
  <div class=" image-link-group">
    <div class=" image-link " style="">
      <a href="{{ route('league') }}" class=" ">{{ $season->name }}</a>
    <a href="https://www.rlss.org.uk/nationals-regional-heats" target="_blank"> Go to 'RLSS Regional Heats'</a>
    </div>
  </div>
</div>
@endsection