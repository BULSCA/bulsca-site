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

<div class="container-responsive">
  <div class="flex flex-wrap gap-2 gap-y-20 justify-center  ">

    @for ($i=0; $i< 9; $i++) <div class="flex flex-col items-center justify-center basis-1/5 ">
      <div class="rounded-full w-44 h-44 overflow-hidden">
        <img src="/storage/logo/blogo.png" alt="">
      </div>
      <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
        Name Here
      </h3>
      <p class=" text-gray-600 font-semibold">
        Position
      </p>
  </div>
  @endfor

</div>
</div>




@endsection