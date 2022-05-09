@extends('layout')

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
      <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center " >
        <img src="/storage/logo/blogo.png" class="w-[10%] " alt="">
        <div class="border-l-2 border-white ml-12 pl-12 py-8">
          <h2 class="text-6xl font-bold text-white">Competitions</h2>
          <p class="text-white">At the heart of BULSCA</p>
        </div>
      </div>

    </div>

    
  </div>

  <a href="#" class="notification-stripe ns-red">
    Southampton results are now available!
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
    </svg>
  </a>

  <div class=" mx-2 md:mx-[20%] my-[2%] ">
    <div class=" grid grid-cols-2 gap-32 text-center">
      <div class=" h-52 bg-gray-400 flex items-center justify-center bg-image" style="background-image: url(/storage/photos/IMG_4946.JPG);">
        <a href="{{ route('league') }}" class=" image-card-text" >{{ $season->name }}</a>
      </div>
      <div class=" h-52 bg-gray-400 flex items-center justify-center bg-image transition-all image-card-text" style="background-image: url(/storage/photos/DSC_0016.jpg);">
        <a href="#" class="image-card-text">Champs 2022</a>
      </div>


    </div>
  </div>

 

  <div class="px-2 md:px-[20%] py-[2%] bg-bulsca flex">
    <div>
      <h1 class="text-white text-3xl font-bold uppercase mb-2">What makes a BULSCA Competition? </h1>
      <p class="text-white">
        BULSCA league competitions are all about enjoying the experience of competing, putting the skills you learn into practice and making new friends! Competitions provide the perfect opportunity for lifesavers to demonstrate their skills as a team and to see how they respond under pressure. Each league competition consists of two elements - SERCs and Speeds. Competitions are followed by food, results and a social - a great opportunity to make new friends, share knowledge, and celebrate successes!
      </p>
    </div>


  </div>


  <div class=" mx-2 md:mx-[20%] my-[2%] ">
    <div class="grid grid-cols-2">
      <div class="flex flex-col justify-center">
        <h2 class="text-bulsca text-4xl font-semibold">SERCs <small class=" text-sm text-slate-500">Simulated Emergency Response Competitions</small></h2>
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
    
      <div class="flex items-center justify-center">
        <img src="/storage/photos/DSC_1201.jpg" loading="lazy" class="w-[90%]" alt="">
      </div>

    </div>
  </div>

  <div class=" mx-2 md:mx-[20%] my-[2%] ">
    <div class="grid grid-cols-2">
      <div class="flex items-center justify-center">
        <img src="/storage/photos/DSC_0335.jpg" loading="lazy" class="w-[90%]" alt="">
      </div>
      <div class="flex flex-col justify-center">
        <h2 class="text-bulsca text-4xl font-semibold">Speeds</h2>
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