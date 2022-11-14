@extends('layout')

@section('title')
{{$season->name}} | Competitions |
@endsection

@section('content')



<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">{{ $season->name }}</h2>
        <p class="text-white">{{ $season->from->format('Y') }}-{{ $season->to->format('y') }}</p>
      </div>
    </div>

  </div>


</div>



<div class=" container-responsive ">
  <h2 class="pb-3 header header-larger header-bold">Competition Calender </h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-1 md:gap-y-12 gap-y-4">
    @foreach ($comps as $comp)
    <div class="flex flex-col ">
      <a href="{{ route('lc-view', Str::lower($comp->hostUni->name) . '-' . $comp->when->format('Y') . '.' . $comp->id) }}" class="header header-bold hover:text-bulsca_red">
        {{ $comp->hostUni->name }}
      </a>

      <small>
        {{ $comp->when->format('d/m/Y') }}
      </small>


      <p class="mb-4 mt-2">
        {{ $comp->short }}

      </p>
      @if ( $comp->getResultsResource()->first() )
      <a href="{{ $comp->getResultsResource()->first()->getURL() }}" target="_blank" class="font-semibold text-gray-600 hover:text-black flex mt-auto ">
        View Results
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
        </svg>
      </a>
      @else
      <p href="#" class="font-semibold text-red-600  flex mt-auto ">
        Results Unavailable!
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
        </svg>
      </p>
      @endif
    </div>
    @endforeach
  </div>


</div>

<div class="px-2 md:px-[20%] py-[2%] bg-bulsca flex flex-col space-y-4">
  @php
  $data = $season->getLeagueResults('a')
  @endphp
  @php
  $bdata = $season->getLeagueResults('b')
  @endphp

  <div class="grid-2 text-white">
    <div>
      <h4 class="text-white">A-League</h4>
      <div class="podium grid-2">

        @foreach ($data['data'] as $row)
        @if ($loop->index > 2)
        @break
        @endif
        <div class="flex flex-col items-center space-y-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
          </svg>

          <span>{{ $row['team'] }}</span> @th($loop->index + 1)
        </div>

        @endforeach
      </div>
    </div>

    <div>
      <h4 class="text-white">B-League</h4>
      <div class="podium grid-2">

        @foreach ($bdata['data'] as $row)
        @if ($loop->index > 2)
        @break
        @endif
        <div class="flex flex-col items-center space-y-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
          </svg>

          <span>{{ $row['team'] }}</span> @th($loop->index + 1)
        </div>

        @endforeach
      </div>
    </div>



  </div>













</div>

<div class=" container-responsive ">
  <h2 class="pb-3 header header-larger header-bold">A-League Results </h2>


  <div class="table-wrapper relative">
    <table class=" table-auto" style="position: relative;">
      <thead>
        <tr>
          @foreach ($data['cols'] as $col)
          <th>{{ $col }}</th>

          @endforeach
        </tr>
      </thead>
      <tbody>


        @foreach ($data['data'] as $row)
        @if ($row['points'] == 0) @continue; @endif
        <tr>
          <th>{{ $row['team'] }}</th>
          <td>@th( $loop->index + 1 )</td>
          <td>{{ $row['points'] }}</td>

          @foreach ($data['comps'] as $comp)

          <td>@if ($row['positionPoints'][$comp] != 0)
            {{max(11 - $row['positionPoints'][$comp], 0)}} (@th($row['positionPoints'][$comp]))
            @endif
          </td>



          @endforeach
        </tr>

        @endforeach


      </tbody>
    </table>
  </div>
</div>

<div class=" container-responsive ">
  <h2 class="pb-3 header header-larger header-bold">B-League Results </h2>


  <div class="table-wrapper relative">
    <table class=" table-auto" style="position: relative;">
      <thead>
        <tr>
          @foreach ($bdata['cols'] as $col)
          <th>{{ $col }}</th>

          @endforeach
        </tr>
      </thead>
      <tbody>

        @foreach ($bdata['data'] as $row)
        @if ($row['points'] == 0) @continue; @endif


        <tr>
          <th>{{ $row['team'] }}</th>
          <td>@th( $loop->index + 1 )</td>
          <td>{{ $row['points'] }}</td>

          @foreach ($bdata['comps'] as $comp)

          <td>@if ($row['positionPoints'][$comp] != 0)
            {{max(11 - $row['positionPoints'][$comp], 0)}} (@th($row['positionPoints'][$comp]))
            @endif
          </td>



          @endforeach
        </tr>

        @endforeach


      </tbody>
    </table>
  </div>
</div>







@endsection