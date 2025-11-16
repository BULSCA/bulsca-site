@extends('layout')

@section('title')
First Steps | Clubs |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">Create a Club</h2>
        <p class="text-white">Looking to form a club at your Uni?</p>
      </div>
    </div>

  </div>


</div>


<div class=" container-responsive ">
  <h1 class="header">Getting started </h1>
  <p>
    If you are a current university student looking to set up a new lifesaving club, then contact the Chair, {{ $chair->currentMemberName() }} at <a href="mailto:chair@bulsca.co.uk">chair@bulsca.co.uk</a>
  </p>
</div>



@endsection