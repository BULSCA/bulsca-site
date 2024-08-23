<div class="   w-screen bg-gray-100  overflow-hidden  " style="height: {{ $hero->height }}">



    @if ($nearComp ?? false)
        <div class="h-full w-full overflow-hidden relative">

            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
                <div
                    class="flex items-center justify-center bg-black bg-opacity-60 rounded-md py-2 md:py-8 px-8 md:px-0">
                    <img src="{{ $nearComp->hostUni->image_path ? route('image', $nearComp->hostUni->image_path) : '/storage/logo/blogo.png' }}"
                        class="w-[20%] hidden md:block " alt="">
                    <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                        <small class="text-white font-semibold">
                            @if ($nearComp->when->isToday())
                                Today
                            @elseif ($nearComp->when->isFuture())
                                Upcoming Competition
                            @else
                                See you next year!
                            @endif
                        </small>
                        <h2 class="md:text-6xl text-4xl font-bold text-white">{{ $nearComp->getName() }}</h2>
                        <p class="text-white mt-3">
                            @php
                                $diff = now()->diffInDays($nearComp->when) + 1;
                            @endphp
                            @if ($nearComp->when->isToday())
                                <a href="https://live.bulsca.co.uk"
                                    class=" bg-green-500 rounded-md px-4 py-2 text-sm no-underline text-white hover:bg-green-600 transition-all duration-200 ease-in-out hover:underline"
                                    rel="noopener noreferrer" target="_blank">Follow live</a>
                            @elseif ($nearComp->when->isFuture())
                                {{ $nearComp->when->format('l jS M Y') }} ({{ $diff }}
                                day{{ $diff > 1 ? 's' : '' }} to go!)
                            @else
                                <a href="https://results.bulsca.co.uk/resolve/{{ $nearComp->when->format('d-m-Y') }}/{{ $nearComp->hostUni->name }}"
                                    class=" bg-white rounded-md px-4 py-2 text-sm no-underline  hover:bg-gray-200 transition-all duration-200 ease-in-out hover:underline"
                                    rel="noopener noreferrer" target="_blank">Results</a>
                            @endif
                        </p>

                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- CHAMPS LANDING --}}
        {{-- <div class="min-h-[100vh]  w-full overflow-hidden relative">
        <div class="absolute top-0 right-0 w-full h-full  flex flex-col items-center justify-center transition-opacity   duration-1000 " style="background-color: #275271"
            id="head1">
            <img src="./storage/photos/champs/2024/champs_2024_dark.png" ondblclick="ee(this)" class=" md:w-[27%] w-[20rem] md:-mt-20 md:-mb-12 -mb-6 mt-24   h-auto"
                alt="">
                <div class=" py-8 text-center flex flex-col">
                    <p class="md:text-[5rem] text-5xl font-bold text-white mb-5 anton-regular uppercase " style="letter-spacing: 5px !important; line-height: 1.2em;  ">BULSCA Championships <br>2024</p>
                    @php
                        // Calc start values
                        $now = now();
                        $champs = \Carbon\Carbon::create(2024, 3, 2, 9, 30, 0);
                        $diff = $champs->diff($now);

                        $days = $diff->d;
                        $hours = $diff->h;
                        $mins = $diff->i;
                        $secs = $diff->s;
                    @endphp
                     <div id="time-container" class="grid grid-cols-4 gap-y-4 md:gap-y-0 text-white text-lg font-semibold uppercase anton-regular mb-9" style="letter-spacing: 5px !important; line-height: 1.2em;">
                        <div><div class="text-4xl " id="days">{{ $days }}</div><div>Days</div></div>
                        <div><div class="text-4xl " id="hours">{{ $hours }}</div><div>Hours</div></div>
                        <div><div class="text-4xl " id="mins">{{ $mins }}</div><div>Minutes</div></div>
                        <div><div class="text-4xl " id="secs">{{ $secs }}</div><div>Seconds</div></div>
                        
                        
                        
                        
                 
                    </div> 
                   
                      
                 
                        <div class="flex space-x-2 items-center justify-center">
                            <a href="https://bulsca.lifesaving.events/championships/24/" rel="noreferrer noopener" target="_blank" id="become-live-sat" class="btn btn-champs self-center btn-thinner ">Sat</a>
                            <a href="https://results.bulsca.co.uk/champs-2023-24.26" rel="noreferrer noopener" target="_blank" id="become-live-sun" class="btn btn-champs self-center btn-thinner  ">Sun</a>
                        </div>
                  
                  </div>
        </div>

    </div> --}}


        {{-- FRESHERS LANDING --}}

        <div class="h-full w-full overflow-hidden relative">
            <div class=" absolute top-0 right-0 w-full h-full head-bg-3 flex flex-col items-center justify-center transition-opacity   duration-1000 !bg-right md:bg-center  "
                style="{{ $hero->background() }}" :style="{ backgroundImage: 'url(' + hero.bg_value + ')' }"
                id="head1">


                @include('components.hero.header-layouts.vertical')


                <div class="flex flex-col items-center" x-html="hero.content">
                    {!! $hero->content ?? '' !!}
                </div>

            </div>
        </div>

        {{-- DEFAULT LANDING --}}

        {{-- <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center transition-opacity   duration-1000"
                id="head1">
                <img src="./storage/logo/blogo.png" ondblclick="ee(this)" class="md:w-[12.5%] w-[50%] h-auto"
                    alt="">
            </div>

        </div> --}}
    @endif


</div>
