@extends('layout')

@section('title')
{{$season->name}} | Competitions |  
@endsection

@section('content')



<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

<div class="h-full w-full overflow-hidden relative">
  <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center " >
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

<div class="grid grid-cols-1 md:grid-cols-4 gap-x-1 md:gap-y-12 gap-y-4">
    @foreach ($comps as $comp)
    <div class="flex flex-col ">
            <a href="{{ route('lc-view', $comp->id) }}" class="header header-bold hover:text-bulsca_red">
                {{ $comp->hostUni->name }}
            </a>

            <small>
                {{ $comp->when->format('d/m/Y') }}
            </small>
            

            <p class="mb-4 mt-2">
            {{ $comp->short }}

            </p>
            @if ( $comp->getResultsResource()->first()  )
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
<details>
  <summary class="text-white text-3xl font-bold uppercase mb-2 cursor-pointer">A-League Results</summary>
  @if ($comps->count() == 0)
    <p class="text-white font-semibold indent-8">
        A-League results are currently unavailable!
    </p>
  @else
  <div class=" relative overflow-x-auto">
    <table class="table-auto text-center text-white w-full">
        <thead>
            <tr class="text-lg border-b ">
                <th class="px-6 ">University</th>
                <th class="px-6">Position</th>
                <th class="px-6">Points</th>
                @foreach ($comps as $comp)
                    <th class="px-6">{{ $comp->hostUni->name }}</th>
          
                @endforeach
            </tr>
        </thead>
        <tbody class=" ">
          @foreach ($season->getALeagueResults() as $uni)
          <tr class="hover:bg-opacity-20 hover:bg-white  ">
              <td class="px-6 py-2 ">{{ $uni->getName() }}</td>
              <td class="px-6">{{ $loop->index + 1 }}</td>
              <td class="px-6">{{ $uni->getTotal() }}</td>
              @foreach ($uni->getScores() as $score)
                <td class="px-6">{{ $score }}</td>
              @endforeach

          </tr>
          @endforeach

        </tbody>
    </table>
  </div>
  @endif
</details>



<details>
    <summary class="text-white text-3xl font-bold uppercase mb-2 cursor-pointer">B-League Results</summary>
    
    <p class="text-white font-semibold indent-8">
        B-League results are currently unavailable!
    </p>
    
</details>


</div>




@endsection