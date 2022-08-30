@extends('layout')

@section('title')
Committee | Get Involved |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">Committee</h2>
        <p class="text-white"></p>
      </div>
    </div>

  </div>


</div>


@if ($time)
<div class="container-responsive mb-5">
  <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
    <div class="flex flex-col items-center justify-center basis-1/5 py-4 rounded-lg animate-pulse ">
      <div class="rounded-full w-56 h-56 overflow-hidden flex items-center justify-center">
        <img src="https://scontent-man2-1.xx.fbcdn.net/v/t1.6435-9/56711145_844469509222706_903012072210563072_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=ad2b24&_nc_ohc=UfZPhcG2zQsAX9gik-F&tn=bfxGmV1Mpk9jg-Ca&_nc_ht=scontent-man2-1.xx&oh=00_AT-BS7XAczFfC8IS_siZsueb3kG2wBq6md3QrjD5KgUmRA&oe=632580DC" alt="">
      </div>
      <h3 class="header py-4 px-3 border-b border-gray-400">
        Ben Barker
      </h3>
      <p class=" text-gray-600 font-semibold">
        Lord of Lifesaving
      </p>
    </div>
    <div class="flex flex-col items-center justify-center basis-1/5 py-4 rounded-lg animate-pulse ">
      <div class="rounded-full w-56 h-56 overflow-hidden">
        <img src="/storage/photos/adaml.jpg" alt="">
      </div>
      <h3 class="header  py-4 px-3 border-b border-gray-400">
        Adam Lane
      </h3>
      <p class=" text-gray-600 font-semibold">
        Legend
      </p>
    </div>
    <div class="flex flex-col items-center justify-center basis-1/5 py-4 rounded-lg animate-pulse ">
      <div class="rounded-full w-56 h-56 overflow-hidden">
        <img src="https://scontent-man2-1.xx.fbcdn.net/v/t1.6435-9/202898952_3055688511422840_6374224258213301214_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=09cbfe&_nc_ohc=56tYeKtdrpQAX9uAwaC&_nc_ht=scontent-man2-1.xx&oh=00_AT9byXWqXXhDLPtAEDNEnWeD1ST2MYiLoxN-DhPzQtRcRw&oe=632322AA" alt="">
      </div>
      <h3 class="header header py-4 px-3 border-b border-gray-400">
        Noah Hollowell
      </h3>
      <p class=" text-gray-600 font-semibold">
        Get Data Managed
      </p>
    </div>
  </div>
</div>
@endif

<div class="container-responsive">
  <div class="md:flex md:flex-wrap gap-2 gap-y-20 justify-center grid grid-cols-1  ">

    <div class="flex flex-col items-center justify-center md:basis-1/5 ">
      <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
        <img src="/storage/logo/blogo.png" class="w-full h-full" alt="">
      </div>
      <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
        Ell Murray
      </h3>
      <p class=" text-gray-600 font-semibold">
        Chair
      </p>
    </div>

    <div class="flex flex-col items-center justify-center md:basis-1/5 ">
      <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
        <img src="/storage/photos/committee/secretary.jpg" class="w-full h-full" alt="">
      </div>
      <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
        Michael Kirkham
      </h3>
      <p class=" text-gray-600 font-semibold">
        Secretary
      </p>
    </div>

    <div class="flex flex-col items-center justify-center md:basis-1/5 ">
      <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
        <img src="/storage/photos/committee/treasurer.jpeg" class="w-full h-full" alt="">
      </div>
      <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
        Dylan Nicole
      </h3>
      <p class=" text-gray-600 font-semibold">
        Treasurer
      </p>
    </div>

    <div class="flex flex-col items-center justify-center md:basis-1/5 ">
      <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
        <img src="/storage/logo/blogo.png" class="w-full h-full" alt="">
      </div>
      <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
        Mia Green
      </h3>
      <p class=" text-gray-600 font-semibold">
        Club Development
      </p>
    </div>


    <div class="flex flex-col items-center justify-center md:basis-1/5 ">
      <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
        <img src="/storage/photos/committee/communications.jpeg" class="w-full h-full" alt="">
      </div>
      <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
        Lauren Hill
      </h3>
      <p class=" text-gray-600 font-semibold">
        Communications Officer
      </p>
    </div>


    <div class="flex flex-col items-center justify-center md:basis-1/5 ">
      <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
        <img src="/storage/photos/committee/data_manager.jpg" class="w-full h-full" alt="">
      </div>
      <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
        Noah Hollowell
      </h3>
      <p class=" text-gray-600 font-semibold">
        Data Manager
      </p>
    </div>


    <div class="flex flex-col items-center justify-center md:basis-1/5 ">
      <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
        <img src="/storage/logo/blogo.png" class="w-full h-full" alt="">
      </div>
      <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
        Chloe Warr
      </h3>
      <p class=" text-gray-600 font-semibold">
        Championships Coordinator
      </p>
    </div>


  </div>
</div>




@endsection