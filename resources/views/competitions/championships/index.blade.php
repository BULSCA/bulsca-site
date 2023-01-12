@extends('layout')

@section('title')
Championships | Competitions |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">Championships</h2>
        <p class="text-white"></p>
      </div>
    </div>

  </div>


</div>


<div class="container-responsive">
  <div class="image-link-group">

    <div class=" image-link " style="background-image: url(/storage/photos/DSC_0014.jpg);">
      <a href="{{ route('champs.2023') }}" class=" ">Champs 2023 Info</a>
    </div>

    <div class=" image-link disabled" style="background-image: url(/storage/photos/DSC_0348.jpg);">
      <a href="#" class=" ">Champs 2023 Entries</a>
    </div>

  </div>
</div>

<div class="container-responsive">
  <h2 class="header">The Championships</h2>
  <p>
    The BULSCA Student Championships is the highlight of the year, where clubs come together and compete in a two day competition.
    <br><br>
    On the first day, the competition takes the same form as the RLSS National Speed Championships. Clubs form teams consisting of up to twelve members, who take part in various individual and relay events.
    <br><br>
    The second day, takes the form of a normal league competition with the exception of the speed events. The clubs from the first day split into three teams of four, who compete in all team events.
    <br>
    <br>
    The overall Championships result is formed from the results of the first and second day combined.
  </p>
</div>

<div class="container-responsive">
  <h2 class="header">Saturday</h2>
  <p>
    When everyone comes crawling back to show off just how good at swimming they truely are!
  </p>
  <br>
  <div class="grid md:grid-cols-2 grid-cols1 gap-2">
    <div>
      <h2 class="header header-small">Individual Events</h2>
      <ul class=" list-disc list-inside">
        <li>200m Obstacles</li>
        <li>12.5m Line Throw</li>
        <li>50m Manikin Carry</li>
        <li>100m Rescue Medley</li>
        <li>100m Manikin Carry with Fins</li>
        <li>100m Manikin Tow with Fins</li>
        <li>200m Super Lifesaver</li>
      </ul>
    </div>
    <div>
      <h2 class="header header-small">Relay Events</h2>
      <ul class=" list-disc list-inside">
        <li>4 x 50m Obstacles Relay</li>
        <li>4 x 10m Line Throw Relay</li>
        <li>4 x 25m Manikin Tow Relay</li>
        <li>4 x 50m Medley</li>
        <li>4 x 50m Pool Lifesaver Relay</li>
      </ul>
    </div>
  </div>

</div>

<div class="container-responsive">

  <div>
    <h2 class="header">Sunday</h2>
    <p>
      A bit more traditional...
    </p>
    <br>
    <h2 class="header header-small">Individual Events</h2>
    <ul class=" list-disc list-inside">
      <li>Dry SERC</li>
      <li>Wet SERC</li>
      <li>RNLI SERC</li>
      <li>4x 12m Line Throw</li>
      <li>4x 50m Swim & 50m Tow</li>
    </ul>
  </div>





</div>




@endsection