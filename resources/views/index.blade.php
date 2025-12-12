@extends('layout')

@section('content')
@section('meta')
    The British Universities Life Saving Clubs' Association (BULSCA) acts as the governing body for, and oversees
    competitive lifesaving between, university clubs. Our competitions test lifesaving athletes on their prioritisation,
    rescue skills, fitness, first aid knowledge and ability to adapt and show initiative in an emergency. Swimming speed and
    endurance, while helpful, do not necessarily make a good lifesaver!
@endsection

{{-- remove h-100 and revert back to just h-50 once freshers page goes --}}
<div id="banner-carousel" data-snow-container class=" h-[60vh] max-h-[70vh] overflow-hidden w-screen  bg-gray-100">

    <div class="h-full w-screen  relative ">
        <div class="absolute bottom-4 left-0 w-screen flex items-center justify-center space-x-3" id="pane-controls"></div>
        <div id="panes"
            class="h-full w-full flex flex-row overflow-hidden overflow-x-auto snap-x snap-mandatory thin-scrollbar ">

            @if ($nearComp)
                <div class="min-w-full snap-center flex flex-col items-center justify-center head-bg-4 ">
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
                            <h2 class="md:text-6xl text-4xl font-bold text-white"><a
                                    href="{{ route('lc-view', Str::lower($nearComp->hostUni->name) . '-' . $nearComp->when->format('Y') . '.' . $nearComp->id) }}"
                                    class="text-white">{{ $nearComp->getName() }}</a></h2>
                            <p class="text-white mt-3">
                                @php
                                    $diff = now()->diffInDays($nearComp->when) + 1;
                                @endphp
                                @if ($nearComp->when->isToday())
                                    <a href="https://live.bulsca.co.uk"
                                        class=" bg-green-500 rounded-md px-4 py-2 text-sm no-underline text-white hover:bg-green-600 transition-all duration-200 ease-in-out hover:underline"
                                        rel="noopener noreferrer" target="_blank">Follow live</a>
                                @elseif ($nearComp->when->isFuture())
                                    {{ $nearComp->when->format('l jS M Y') }} ({{ floor($diff) }}
                                    day{{ floor($diff) > 1 ? 's' : '' }} to go!)
                                @else
                                    <a href="https://results.bulsca.co.uk/resolve/{{ $nearComp->when->format('d-m-Y') }}/{{ $nearComp->hostUni->name }}"
                                        class=" bg-white rounded-md px-4 py-2 text-sm no-underline  hover:bg-gray-200 transition-all duration-200 ease-in-out hover:underline"
                                        rel="noopener noreferrer" target="_blank">Results</a>
                                @endif
                            </p>

                        </div>
                    </div>
                </div>
            @endif

            <div class=" min-w-full h-full snap-center head-bg-3 flex items-center justify-center transition-opacity   duration-1000"
                style="background-image: url('storage/photos/manikin_swimmer_down_view.jpg')" id="head1">
                <img src="./storage/logo/blogo.png" ondblclick="ee(this)" class="md:w-[12.5%] w-[50%] h-auto"
                    alt="">
            </div>

            <div class="min-w-full snap-center flex flex-col items-center justify-center" style="background: #004490">
                <img src="{{ asset('storage/photos/champs/2026/champs-logo-2.png') }}" class=" w-56"
                    alt="" srcset="">
                <div class="flex flex-col items-center">
                    <p class="text-white 2xl:text-4xl text-3xl font-bold uppercase text-center md:text-left">7th-8th
                        March</p>
                        <p class="text-white 2xl:text-2xl text-xl font-semibold uppercase text-center md:text-left" id="time-container">
                            <span id="days">0</span> Days, <span id="hours">0</span> Hours, <span id="mins">0</span> Minutes & <span id="secs">0</span> Seconds
                        </p>
                    <p class="text-gray-300 2xl:text-xl text-lg font-semibold uppercase text-center md:text-left">@ Liverpool Aquatics Centre</p>
                </div>

                <a href="{{ route('champs.2026') }}" rel="noopener noreferrer"
                    class="btn btn-thinner mt-6 !text-white !bg-[#004490] hover:!bg-[#f48c00] hover:!border-[#f48c00]">
                    Find out More
                </a>
            </div>

            @if (now()->month >= 7 && now()->month <= 11)
            <div class=" min-w-full snap-center head-bg-3 flex flex-col items-center justify-center transition-opacity   duration-1000 !bg-right md:bg-center  "
                style="background-image: url('storage/photos/freshers/freshers (4).jpeg')" id="head1">

                <div class=" py-8 text-center flex flex-col ">
                    <p class="md:text-[5rem] text-5xl font-bold text-white mb-3 md:mb-0 ">Hello Freshers 👋</p>
                    <p class=" text-xl font-semibold text-white">Welcome to university lifesaving</p>

                    <a href="{{ route('freshers') }}#clubs" id="become-live-sat"
                        class="btn  self-center btn-thinner mt-8 rounded-full">Find
                        my club & more</a>
                </div>
            </div>
            @endif

            <div class=" min-w-full h-full snap-center head-bg-3 flex items-center justify-center transition-opacity   duration-1000"
                id="head1">
                <img src="./storage/logo/blogo.png" ondblclick="ee(this)" class="md:w-[12.5%] w-[50%] h-auto"
                    alt="">
            </div>
        </div>


    </div>

    <script>
        const panes = document.getElementById('panes')
        const controls = document.getElementById('pane-controls')

        const activeClasses = ['bg-bulsca']
        const inactiveClasses = ['bg-gray-100', 'opacity-90']
        const baseClasses = ['cursor-pointer', 'size-3', 'rounded-full']

        const max_index = panes.children.length
        let current_index = 0  // Start with the second tile (index 1)

        const switchToPane = (i) => {
            const child = panes.children[i]
            current_index = i


            panes.scrollTo({
                left: i * child.clientWidth,
                behavior: 'smooth'
            })

            //child.scrollIntoView({behavior: 'smooth', block:'nearest'})

            for (var j = 0; j < panes.children.length; j++) {
                var jumper = controls.children[j]

                jumper.classList.remove(...activeClasses, ...inactiveClasses)
                console.log(i, j)
                if (j == i) {
                    jumper.classList.add(...activeClasses)
                } else {
                    jumper.classList.add(...inactiveClasses)
                }
            }
        }


        let first = true

        for (let i = 0; i < panes.children.length; i++) {
            jumper = document.createElement('div')
            jumper.classList.add(...baseClasses)

            if (first) {
                jumper.classList.add(...activeClasses)
                first = false
            } else {
                jumper.classList.add(...inactiveClasses)
            }

            jumper.onclick = (e) => {
                switchToPane(i)

            }

            controls.appendChild(jumper)
        }

        // Show the second tile initially
        switchToPane(0)

        setInterval(() => {
            current_index++

            if (current_index >= max_index) {
                current_index = 0
            }

            switchToPane(current_index)



        }, 6000);
    </script>



</div>



<x-alert-banner />


<div class=" container-responsive ">
    <div class="flex flex-col space-y-9 ">
        <div
            class="flex flex-col md:flex-row items-center justify-center md:space-x-12 space-y-6 md:space-y-0 text-center md:text-left w-full">

            <svg xmlns="http://www.w3.org/2000/svg" class=" h-16 w-16" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            <div class="flex flex-col max-w-3xl ">
                <h2 class="text-2xl font-semibold ">Acting Governing Body</h2>

                <p class="">
                    BULSCA acts as the governing body for lifesaving sport while at University. We are an organisation
                    overseeing the development of university lifesaving clubs, and ensure the smooth-running of an
                    annual
                    league.
                </p>
            </div>
        </div>

        <div
            class="flex flex-col-reverse md:flex-row items-center justify-center md:space-x-12 space-y-6 md:space-y-0 text-center md:text-left w-full">


            <div class="flex flex-col max-w-3xl !mt-6 md:!mt-0">
                <h2 class="text-2xl font-semibold ">By Students, For Students</h2>
                <p>
                    The BULSCA committee is made up entirely of volunteers, either current students or graduates from
                    higher
                    education institutions.
                </p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class=" h-16 w-16 " fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>

        <div
            class="flex flex-col md:flex-row items-center justify-center md:space-x-12 space-y-6 md:space-y-0 text-center md:text-left w-full">

            <svg xmlns="http://www.w3.org/2000/svg" class=" h-16 w-16" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <div class="flex flex-col max-w-3xl ">
                <h2 class="text-2xl font-semibold ">Our aims</h2>
                <p>
                    Our aims are to promote the training and development of lifesaving skills, to promote and develop
                    lifesaving as a sport and to oversee competitive lifesaving between Higher Education institutions.
                </p>
            </div>
        </div>
    </div>
</div>


<!-- Competition Boast -->
@if ($nearComp)
    @php
        $page = $nearComp->hostUni->getPage()->first();
        $banner_color = $page->banner_color ?? '#000000ff';
    @endphp
    <div class="container-boast" style="background: {{ $banner_color }}">
        <img src="{{ $nearComp->hostUni->image_path ? route('image', $nearComp->hostUni->image_path) : '/storage/logo/blogo.png' }}" class=" w-56" alt=""
            srcset="">
        <div class="flex flex-col">
            <p class="text-white 2xl:text-2xl text-1xl font-bold uppercase text-center md:text-left">
                @if ($nearComp->when->isToday())
                    Today
                @elseif ($nearComp->when->isFuture())
                    Upcoming Competition
                @else
                    See you next year!
                @endif
            </p>
            <p><a href="{{ route('lc-view', Str::lower($nearComp->hostUni->name) . '-' . $nearComp->when->format('Y') . '.' . $nearComp->id) }}"
                class="text-white 2xl:text-4xl text-3xl font-bold uppercase text-center md:text-left">{{ $nearComp->getName() }}
            </a></p>
            <p class="text-gray-300 2xl:text-xl text-lg font-semibold uppercase text-center md:text-left">
                @php
                    $diff = now()->diffInDays($nearComp->when) + 1;
                @endphp
                @if ($nearComp->when->isToday())
                    <a href="https://live.bulsca.co.uk"
                        class=" bg-green-500 rounded-md px-4 py-2 text-sm no-underline text-white hover:bg-green-600 transition-all duration-200 ease-in-out hover:underline"
                        rel="noopener noreferrer" target="_blank">Follow live</a>
                @elseif ($nearComp->when->isFuture())
                    {{ $nearComp->when->format('l jS M Y') }} ({{ floor($diff) }}
                    day{{ floor($diff) > 1 ? 's' : '' }} to go!)
                @else
                    <a href="https://results.bulsca.co.uk/resolve/{{ $nearComp->when->format('d-m-Y') }}/{{ $nearComp->hostUni->name }}"
                        class=" bg-white rounded-md px-4 py-2 text-sm no-underline  hover:bg-gray-200 transition-all duration-200 ease-in-out hover:underline"
                        rel="noopener noreferrer" target="_blank">Results</a>
                @endif
            </p>
        </div>

        @if ($nearComp->when->isToday())
            <a href="https://live.bulsca.co.uk"
                class=" bg-green-500 rounded-md px-4 py-2 text-sm no-underline text-white hover:bg-green-600 transition-all duration-200 ease-in-out hover:underline"
                rel="noopener noreferrer" target="_blank">Follow live</a>
        @elseif ($nearComp->when->isFuture())

        @else
            <a href="https://results.bulsca.co.uk/resolve/{{ $nearComp->when->format('d-m-Y') }}/{{ $nearComp->hostUni->name }}"
                class=" bg-white rounded-md px-4 py-2 text-sm no-underline  hover:bg-gray-200 transition-all duration-200 ease-in-out hover:underline"
                rel="noopener noreferrer" target="_blank">Results</a>
        @endif
    </div>
@endif
<!-- End Competition Boast -->
 
<!-- Champs 2026 Boast -->
<div class="container-boast" style="background: #004490">
    <div class="inline-flex p-4 rounded-lg" style="background: #004490">
        <img src="{{ asset('storage/photos/champs/2026/champs-logo-2.png') }}" class="w-56" alt="">
    </div>
    <div class="flex flex-col">
        <p class="text-white 2xl:text-4xl text-3xl font-bold uppercase text-center md:text-left">7th-8th March</p>
        <p class="text-white 2xl:text-4xl text-3xl font-bold uppercase text-center md:text-left">
            <span id="days"></span><span id="hours"></span><span id="mins"></span><span
                id="secs"></span>
        </p>
        <p class="text-gray-300 2xl:text-xl text-lg font-semibold uppercase text-center md:text-left">@ Liverpool Aquatics Centre</p>
    </div>

    <a href="{{ route('champs.2026') }}" rel="noopener noreferrer" class="btn btn-thinner md:ml-auto mt-6 md:mt-0">
        Find out More
    </a>
</div>
<!-- End Champs 2026 Boast -->

<script>
    let clk = 0;

    function ee(target) {
        clk++;

        if (clk < 2) return;
        target.src =
            "/storage/photos/ben.jpg"
        target.classList.add('animate-spin')
    }

    function daysUntil(date) {
        const now = new Date();
        const target = new Date('2023-03-18T00:00:00Z');
        const nowUtc = Date.UTC(now.getFullYear(), now.getMonth(), now.getDate());
        const targetUtc = Date.UTC(target.getFullYear(), target.getMonth(), target.getDate());
        const diffInDays = Math.floor((targetUtc - nowUtc) / (1000 * 60 * 60 * 24));

        let cd = document.getElementById('countdown');

        if (cd == null) return

        cd.textContent = diffInDays > 0 ? `${diffInDays} days to go!` : "";
    }

    daysUntil('2023-03-18');
</script>

<script>
    // Set the date we're counting down to
    var countDownDate = new Date("March 7, 2026 09:00:00").getTime();


    function tick() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"


        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("time-container").innerHTML = 'Goodluck!'
            document.getElementById("time-container").style.color = '#66ff00'
            document.getElementById("time-container").classList.remove('text-white')
        } else {
            document.getElementById("days").innerHTML = days;
            document.getElementById("hours").innerHTML = hours;
            document.getElementById("mins").innerHTML = minutes;
            document.getElementById("secs").innerHTML = seconds;

        }
    }
    // Update the count down every 1 second
    var x = setInterval(() => tick(), 1000);
    tick()
</script>


@endsection
