@extends('layout')

@section('title')
Get Involved | 
@endsection

@section('content')

<x-page-banner
    title="Get Involved"
    subtitle="You don't just have to compete!"
    :snowContainer="true"
/>

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