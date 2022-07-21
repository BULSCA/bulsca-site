@extends('layout')

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
      <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center " >
        <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
        <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
          <h2 class="md:text-6xl text-4xl font-bold text-white">Get Involved</h2>
          <p class="text-white">You don't just have to compete!</p>
        </div>
      </div>

    </div>

    
  </div>

  <div class=" container-responsive ">
    <div class=" image-link-group">
      <div class=" image-link" style="background-image: url(/storage/photos/DSC_0410.jpg);">
        <a href="{{ route('clubs') }}" class=" " >Clubs</a>
      </div>
      <div class="image-link" style="background-image: url(/storage/photos/DSC_0348.jpg);">
        <a href="{{  route('create-club')  }}" class="">Create a Club</a>
      </div>


    </div>
  </div>

  <div class=" container-responsive ">
    <h1 class="header">Me? </h1>
    <p>
      BULSCA runs purely through student clubs and volunteers.
      <br>
      <br>
      If you are interested in volunteering your time, you don't have to be on the committee - you can help out by coming along to competitions and judging, officiating, timekeeping, acting as a casualties or one of many other roles that are required to run a competition! If you are interested in changing the face of BULSCA by joining the committee, then get in contact with us! With the many roles available on the committee, you'll certainly find a role that suits.
      <br><br>
      If you are interested in entering a team into a competition, whether as a university or a local club, then get in contact with the competition organiser or with the committee. Once you've been to one competition, we're sure you'll be hooked.
    </p>
</div>



@endsection