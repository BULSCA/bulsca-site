@extends('layouts.dashlayout')

@section('title')
{{ $comp->hostUni->name }} {{ $comp->when->format('Y') }} | Competitions |
@endsection

@section('nav-extra')
nav-scrolled
@endsection

@section('content')



<div class="container-responsive">
  <h2 style='margin-bottom: -.25em !important'><span style="font-size: 0.5em !important">Competition Management</span></h2>
  <h2 style='margin-bottom: -.15em !important'><span class="text-bulsca_red font-bold">{{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}</span></h2>
  <small class="">
    {{ $comp->when->format('d/m/Y @ h:m A') }}
  </small>

  <br>

  <div class=" space-x-3">
    <a href="#" class="btn btn-thinner inline-flex items-center mt-2">Entry Form <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
      </svg></a>
    <a href="#" class="btn btn-thinner inline-flex items-center mt-2">Judges Form <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
      </svg></a>
    <a href="#" class="btn btn-thinner inline-flex items-center mt-2">Helpers Form <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
      </svg></a>
  </div>

  <br>

  <div class="grid  grid-cols-1 md:grid-cols-4 gap-4">
    <div>
      <h4>League Event</h4>
      <p>
        {{ $comp->getInfo && $comp->getInfo->league_event ?: 'N/A'}}
      </p>
    </div>
    <div>
      <h4>Firstaid Kits</h4>
      <p>
        <strong>Full</strong>: {{ $comp->getInfo && $comp->getInfo->full_fa_kit ? "Yes" : "No" }}
        &nbsp; &nbsp;
        <strong>Travel</strong>: {{ $comp->getInfo && $comp->getInfo->full_fa_kit ? "Yes" : "No" }}
      </p>
    </div>
    <div>
      <h4>Organiser</h4>
      <p>
        {{ $comp->hostUni->name}} ({{ $comp->getInfo && $comp->getInfo->organiser_email ?: "N/A" }})
      </p>
    </div>
  </div>

  <br>
  <hr>
  <br>

  <p>Timetable here</p>

  <br>
  <hr>
  <br>

  <div class="grid  grid-cols-1 md:grid-cols-4 gap-4">
    <div class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
      <div class="flex items-center justify-center">
        <h1 class="header header-smallish header-bold">
          Registration
        </h1>
        <small class="ml-auto  text-black font-normal "></small>

      </div>
      <hr class="-mx-6 mb-4">
      <h2 class="header header-small">
        Location
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->registration_location ?: 'N/A'}} <br>
      </p>
    </div>

    <div class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
      <div class="flex items-center justify-center">
        <h1 class="header header-smallish header-bold">
          Pool
        </h1>
        <small class="ml-auto  text-black font-normal "></small>

      </div>
      <hr class="-mx-6 mb-4">
      <h2 class="header header-small">
        Location
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->pool_location ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Length
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->pool_length ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Lanes
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->pool_lanes ?: 'N/A'}} <br>
      </p>
    </div>

    <div class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
      <div class="flex items-center justify-center">
        <h1 class="header header-smallish header-bold">
          Food & Social
        </h1>
        <small class="ml-auto  text-black font-normal "></small>

      </div>
      <hr class="-mx-6 mb-4">
      <h2 class="header header-small">
        Location
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->food_social_location ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Theme
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->social_theme ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Cost
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->food_price ?: '0'}} <br>
      </p>
      <h2 class="header header-small">
        Options
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->food_info ?: 'N/A'}} <br>
      </p>
    </div>

    <div class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
      <div class="flex items-center justify-center">
        <h1 class="header header-smallish header-bold">
          Accommodation
        </h1>
        <small class="ml-auto  text-black font-normal "></small>

      </div>
      <hr class="-mx-6 mb-4">
      <h2 class="header header-small">
        Location
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->accommodation_location ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Cost
      </h2>
      <p class="mb-2">
        {{ $comp->getInfo && $comp->getInfo->food_price ?: '0'}} <br>
      </p>
    </div>

  </div>

  <br>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <h4>Contact Info</h4>
    </div>
    <div>
      <h4>Official Info</h4>
    </div>
    <div>
      <h4>Extra Info</h4>
    </div>
  </div>









</div>

<div class="container-responsive">
  <h3>Results</h3>
  @if ($comp->getResultsResource()->first())
  <div class="flex items-center space-x-4">
    <x-resource-download :file="$comp->getResultsResource()->first()" />

  </div>



  @else
  <p>Results aren't currently available!</p>

  @endif



</div>







@endsection