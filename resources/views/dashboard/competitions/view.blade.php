@extends('layouts.dashlayout')

@section('title')
{{ $comp->hostUni->name }} {{ $comp->when->format('Y') }} | Competitions |
@endsection

@section('nav-extra')
nav-scrolled
@endsection

@section('content')



<div class="container-responsive">
  <div class="flex items-center ">
    <div class="flex flex-col">
      <h2 style='margin-bottom: -.25em !important'><a href="{{ route('prev_season', $comp->currentSeason->getDateSlug()) }}" class="no-underline hover:underline" style="font-size: 0.5em !important">Competitions</a></h2>
      <h2 style='margin-bottom: -.15em !important'><span class="text-bulsca_red font-bold">{{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}</span></h2>
      <small class="">
        {{ $comp->when->format('d/m/Y @ h:m A') }}
      </small>
    </div>
    @if ($comp->hostUni->currentUserIsClubAdmin())
    <a href="{{ route('lc-manage', $comp->id) }}" class="btn btn-thinner ml-auto">Manage</a>
    @endif
  </div>



  <div class=" md:space-x-3 md:flex-row flex flex-col justify-center md:justify-start">
    <a href="{{ $info->form_entry }}" target="_blank" rel="noopener noreferrer" class="btn btn-thinner inline-flex items-center mt-2">Entry Form <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
      </svg></a>
    <a href="{{ $info->form_judges }}" target="_blank" rel="noopener noreferrer" class="btn btn-thinner inline-flex items-center mt-2">Judges Form <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
      </svg></a>
    <a href="{{ $info->form_helpers }}" target="_blank" rel="noopener noreferrer" class="btn btn-thinner inline-flex items-center mt-2">Helpers Form <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
      </svg></a>
  </div>


  <div class="mt-1 mb-2">
    <small>Entries close on {{ date('d/m/Y @ h:i A', strtotime($info->getTimetableTime('timetable_entry_close'))) }}</small>
  </div>



  <div class="grid-4">
    <div class="group">
      <h4>Location</h4>
      <p class=" md:truncate group-hover:overflow-visible group-hover:whitespace-normal ">
        {{ $info->general_location ?: 'N/A'}}
      </p>
    </div>
    <div>
      <h4>League Event</h4>
      <p>
        {{ $info->general_league_event ?: 'N/A'}}
      </p>
    </div>
    <div>
      <h4>Firstaid Kits</h4>
      <p>
        <strong>Full</strong>: {{ $info->general_fak_full ? "Yes" : "No" }}
        &nbsp; &nbsp;
        <strong>Travel</strong>: {{ $info->general_fak_travel ? "Yes" : "No" }}
      </p>
    </div>
    <div>
      <h4>Teams</h4>
      <p>
        Max: {{ $info->teams_limit ?: 'N/A' }} (£{{ $info->teams_cost ?: 'N/A' }}<small>/team</small>)
      </p>
    </div>
  </div>

  <br>
  <hr>
  <br>

  <div class="grid-4">
    <div>
      <h4>Timetable</h4>
      <table class="comp-tt">
        <tr>
          <td><strong>Saturday</strong></td>
        </tr>
        <tr class="">
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_reg_open') ?: 'N/A' }}</strong>
          </td>
          <td class="">
            Registration Opens
          </td>
        </tr>
        <tr>
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_reg_close') ?: 'N/A'  }}</strong>
          </td>
          <td>
            Registration Closes
          </td>
        </tr>

        <tr>
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_sercs_start') ?: 'N/A'  }}</strong>
          </td>
          <td>
            SERCs Start
          </td>
        </tr>

        <tr>
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_speeds_start') ?: 'N/A'  }}</strong>
          </td>
          <td>
            Speeds Start
          </td>
        </tr>
        <tr>
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_comp_end') ?: 'N/A'  }}</strong>
          </td>
          <td>
            Competition Ends
          </td>
        </tr>
        <tr>
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_accom_open') ?: 'N/A'  }}</strong>
          </td>
          <td>
            Accommodation Opens
          </td>
        </tr>
        <tr>
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_social_open') ?: 'N/A'  }}</strong>
          </td>
          <td>
            Social Opens
          </td>
        </tr>
        <tr>
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_results') ?: 'N/A'  }}</strong>
          </td>
          <td>
            Results
          </td>
        </tr>
        <tr>
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_social_end') ?: 'N/A'  }}</strong>
          </td>
          <td>
            Social Closes
          </td>
        </tr>
        <tr>
          <td><strong>Sunday</strong></td>
        </tr>
        <tr>
          <td class="">

            <strong>{{ $info->getTimetableTime('timetable_accom_close') ?: 'N/A'  }}</strong>
          </td>
          <td>
            Accommodation Closes
          </td>
        </tr>



      </table>
    </div>
    <div>
      <h4>Officials</h4>
      <div class="flex flex-col space-y-1">
        <span><strong>Head Ref:</strong> {{ $info->general_official_headref ?: 'N/A' }}</span>

        <span><strong>Dry SERC Writer:</strong> {{ $info->general_official_dryserc ?: 'N/A' }}</span>

        <span><strong>Wet SERC Writer:</strong> {{ $info->general_official_wetserc ?: 'N/A' }}</span>
      </div>
      <br>
      <hr>
      <br>
      <h4>Required Kit</h4>
      <p>
        {{ $info->general_required_kit ?: 'None' }}
      </p>

    </div>
    <div class="md:col-span-2">
      <h4>Other Details</h4>
      {!! $info->extra_info !!}
      <br>
      {{ $info->teams_extra }}
    </div>

  </div>


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
        {{ $info->registration_location ?: 'N/A'}} <br>
      </p>

      <h2 class="header header-small">
        Extra Info
      </h2>
      <p class="mb-2">
        {{ $info->registration_extra ?: 'None'}} <br>
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
        {{ $info->pool_location ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Length
      </h2>
      <p class="mb-2">
        {{ $info->pool_length ?: 'N/A'}}m <br>
      </p>
      <h2 class="header header-small">
        Lanes
      </h2>
      <p class="mb-2">
        {{ $info->pool_lanes ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Extra Info
      </h2>
      <p class="mb-2">
        {{ $info->pool_extra ?: 'None'}} <br>
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
        {{ $info->social_location ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Theme
      </h2>
      <p class="mb-2">
        {{ $info->social_theme ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Cost
      </h2>
      <p class="mb-2 flex flex-col">
        <span><strong>Food:</strong> £{{ $info->food_cost ?: 'N/A'}} </span>
        <span><strong>Social:</strong> £{{ $info->social_cost ?: 'N/A'}}</span>

        <small class="text-right ml-auto">*Costs may be combined</small>
      </p>
      <h2 class="header header-small">
        Options
      </h2>
      <p class="mb-2">
        {{ $info->food_options ?: 'N/A'}} <br>
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
        {{ $info->accom_location ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Cost
      </h2>
      <p class="mb-2">
        £{{ $info->accom_cost ?: 'N/A'}} <br>
      </p>
      <h2 class="header header-small">
        Extra Info
      </h2>
      <p class="mb-2">
        {{ $info->accom_extra ?: 'None'}} <br>
      </p>
    </div>

  </div>

  <br>

  <div>

    <h4>Contact Info</h4>
    <div class="grid-4">
      <div>
        <h5>Organiser</h5>
        <strong>Name:</strong> {{ $info->contact_organiser_name ?: 'N/A' }} <br>
        <strong>Email:</strong> <a href="mailto:{{ $info->contact_organiser_name }}">{{ $info->contact_organiser_email ?: 'N/A' }}</a> <br>
        <strong>Phone:</strong> <a href="tel:{{ $info->orgPhone() }}">{{ $info->orgPhone() }}</a>
      </div>
      <div>
        <h5>Emergency</h5>
        <strong>Name:</strong> {{ $info->contact_emergency_name ?: 'N/A' }} <br>
        <strong>Email:</strong> <a href="mailto:{{ $info->contact_organiser_name }}">{{ $info->contact_emergency_email ?: 'N/A' }}</a> <br>
        <strong>Phone:</strong> <a href="tel:{{ $info->orgPhone() }}">{{ $info->emergPhone() ?: 'N/A' }}</a>
      </div>
    </div>


  </div>









</div>

<div class="container-responsive">

  <div class="grid-3">
    <div>
      <h3>Info Pack</h3>
      @if ($comp->getPackResource()->first())
      <div class="flex items-center space-x-4">
        <x-resource-download :file="$comp->getPackResource()->first()" />

      </div>



      @else
      <p>The info pack isn't currently available!</p>

      @endif
    </div>
    <div id="results">
      <h3>Results</h3>
      @if ($comp->getResultsResource()->first())
      <div class="flex items-center space-x-4">
        <x-resource-download :file="$comp->getResultsResource()->first()" />

      </div>



      @else
      <p>Results aren't currently available!</p>

      @endif
    </div>
  </div>





</div>







@endsection