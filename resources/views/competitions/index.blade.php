@extends('layout')

@section('title')
Competitions |
@endsection

@section('content')

<x-page-banner 
    title="Competitions" 
    subtitle="At the heart of BULSCA"
    :snowContainer="true"
/>
<x-alert-banner />

<x-recent-results-banner />

<div class=" container-responsive ">
  <div class=" image-link-group">
    <div class=" image-link " style="background-image: url(/storage/photos/IMG_4946.JPG);">
      <a href="{{ route('league') }}" class=" ">{{ $season->name }} {{ $season->to->format('Y') }}</a>
    </div>

    <div class=" image-link " style="background-image: url(/storage/photos/DSC_0016.jpg);">
      <a href="{{ route('champs') }}" class="">Champs {{ $season->to->format('Y') }}</a>
    </div>


  </div>
  <br>

    <div class="image-link bulsca" style="">
      <a href="{{ route('league.previous') }}">Previous Leagues</a>
    </div>
  </div>
</div>

<br>

<div class="container-boast">
  <div>
    <h1 class="header-white header header-bold uppercase mb-2">What makes a BULSCA Competition? </h1>
    <p class="text-white">
      BULSCA league competitions are all about enjoying the experience of competing, putting the skills you learn into practice and making new friends! Competitions provide the perfect opportunity for lifesavers to demonstrate their skills as a team and to see how they respond under pressure. Each league competition consists of two elements - SERCs and Speeds. Competitions are followed by food, results and a social - a great opportunity to make new friends, share knowledge, and celebrate successes!
    </p>
  </div>


</div>


<div class=" container-responsive ">
  <div class="grid md:grid-cols-2 grid-cols-1">
    <div class="flex flex-col justify-center">
      <h2 class="header header-large">SERCs <small class=" text-sm text-slate-500">Simulated Emergency Response Competitions</small></h2>
      <p class="">
        SERCs are the ultimate test of lifesavers’ skills, teamwork, and knowledge.
        <br>
        They carry greater weighting in the overall competition scoring than the speed events.
        <br><br>
        In a set time, between two and three minutes, a team of four must assess the situation and then respond by rescuing and treating any number of casualties. A good team will prioritise the different casualties, treating those with the greatest need first.
        <br><br>
        The scope of the incident depends largely on the writer’s imagination; in the past, incidents have ranged from the conventional drowning in a pool, or choking in a restaurant, to the more extreme such as a plane crash, a climbing accident or a ship sinking.

      </p>
    </div>

    <div class="flex items-center justify-center md:mt-0 mt-4">
      <img src="/storage/photos/DSC_1201.jpg" loading="lazy" class="w-[90%]" alt="">
    </div>

  </div>
</div>

<div class=" container-responsive ">
  <div class="grid md:grid-cols-2 grid-cols-1 ">
    <div class="flex items-center justify-center md:mb-0 mb-4">
      <img src="/storage/photos/DSC_0335.jpg" loading="lazy" class="w-[90%]" alt="">
    </div>
    <div class="flex flex-col justify-center">
      <h2 class="header header-large">Speeds</h2>
      <p class="">
        League competitions also consist of team speed relays. Speed events test the fitness of a lifesaver and their ability to use their skills quickly.
        <br><br>
        Events include a Line Throw Relay, a Swim and Tow relay, and one additional speed event of the hosting club’s choice from the list below. Full details for each event can be found in the BULSCA Competition Manual.
        <br><br>
        All BULSCA league competitions consist of a 4x12m Line throw and a 4x100m Swim & Tow Relay.
        <br>The competition organiser can then choose one other event to count towards the league:
        <br><br>
      <ul class="list-disc list-inside">
        <li>a 4x50m Obstacle Relay</li>
        <li>a 4x25m Manikin Carry Relay</li>
        <li>a 4x50m Medley Relay.</li>
      </ul>

      </p>
    </div>



  </div>
</div>



@endsection