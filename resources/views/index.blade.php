@extends('layout')

@section('content')
@section('meta')
    The British Universities Life Saving Clubs' Association (BULSCA) acts as the governing body for, and oversees
    competitive lifesaving between, university clubs. Our competitions test lifesaving athletes on their prioritisation,
    rescue skills, fitness, first aid knowledge and ability to adapt and show initiative in an emergency. Swimming speed and
    endurance, while helpful, do not necessarily make a good lifesaver!
@endsection

<div class=" h-[100dvh] w-screen bg-gray-100  overflow-hidden  ">



    @if ($nearComp)
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
    <div class="h-[100dvh] w-full overflow-x-hidden relative">
        <div class="absolute top-0 right-0 w-full  h-[110dvh] md:h-[100dvh] flex flex-col items-center justify-center transition-opacity   duration-1000 " style="background-color: #275271"
            id="head1">
            <img src="./storage/photos/champs/2024/champs_2024_dark.png" ondblclick="ee(this)" class=" md:w-[40rem] w-[20rem] md:-mt-20 md:-mb-12 -mb-6 mt-48   h-auto"
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
                    <div class="grid grid-cols-4 gap-y-4 md:gap-y-0 text-white text-lg font-semibold uppercase anton-regular mb-9" style="letter-spacing: 5px !important; line-height: 1.2em;">
                        <div><div class="text-4xl " id="days">{{ $days }}</div><div>Days</div></div>
                        <div><div class="text-4xl " id="hours">{{ $hours }}</div><div>Hours</div></div>
                        <div><div class="text-4xl " id="mins">{{ $mins }}</div><div>Minutes</div></div>
                        <div><div class="text-4xl " id="secs">{{ $secs }}</div><div>Seconds</div></div>
                        
                        
                        
                        
                 
                    </div>
                    <a href="{{ route('champs.2024') }}" class="btn btn-champs self-center btn-thinner ">Find out more</a>
                  </div>
        </div>

    </div>
        {{-- <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center transition-opacity   duration-1000"
                id="head1">
                <img src="./storage/logo/blogo.png" ondblclick="ee(this)" class="md:w-[12.5%] w-[50%] h-auto"
                    alt="">
            </div>

        </div> --}}
    @endif


</div>



<x-alert-banner />


<div class=" container-responsive ">
    <div class=" grid xl:grid-cols-3 grid-cols-1 overflow-hidden md:gap-32 text-center">
        <div class="flex flex-col items-center space-y-3 w-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            <h2 class="text-2xl font-semibold ">Acting Governing Body</h2>
            <p class="">
                BULSCA acts as the governing body for lifesaving sport while at University. We are an organisation
                overseeing the development of university lifesaving clubs, and ensure the smooth-running of an annual
                league.
            </p>
        </div>
        <div class="flex flex-col items-center space-y-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h2 class="text-2xl font-semibold ">By Students, For Students</h2>
            <p>
                The BULSCA committee is made up entirely of volunteers, either current students or graduates from higher
                education institutions.
            </p>
        </div>
        <div class="flex flex-col items-center space-y-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <h2 class="text-2xl font-semibold ">Our aims</h2>
            <p>
                Our aims are to promote the training and development of lifesaving skills, to promote and develop
                lifesaving as a sport and to oversee competitive lifesaving between Higher Education institutions.
            </p>
        </div>
    </div>
</div>
<div class="container-boast">
    <p class="text-white 2xl:text-5xl text-4xl font-bold uppercase text-center md:text-left">We're on Facebook, go have
        a look!</p>
    <a href="https://www.facebook.com/BULSCA/" rel="noopener noreferrer"
        class="btn md:ml-auto flex flex-row items-center mt-8 md:mt-0">
        To Facebook
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
        </svg>
    </a>
</div>

<script>
    let clk = 0;

    function ee(target) {
        clk++;

        if (clk < 2) return;
        target.src =
            "https://scontent-mad1-1.xx.fbcdn.net/v/t1.6435-1/89133349_2788611911222752_6862972772499324928_n.jpg?stp=dst-jpg_p200x200&_nc_cat=109&ccb=1-7&_nc_sid=7206a8&_nc_ohc=Z9BSXnigZCcAX_9ozYA&_nc_ht=scontent-mad1-1.xx&oh=00_AT--a8zn5YY8ZGnwBJ8A0MEUxQV9fRNRpolc1qrYczW83w&oe=6324671E"

    }

    function daysUntil(date) {
        const now = new Date();
        const target = new Date('2023-03-18T00:00:00Z');
        const nowUtc = Date.UTC(now.getFullYear(), now.getMonth(), now.getDate());
        const targetUtc = Date.UTC(target.getFullYear(), target.getMonth(), target.getDate());
        const diffInDays = Math.floor((targetUtc - nowUtc) / (1000 * 60 * 60 * 24));
        document.getElementById('countdown').textContent = diffInDays > 0 ? `${diffInDays} days to go!` : "";
    }

    daysUntil('2023-03-18');
</script>

<script>
    // Set the date we're counting down to
var countDownDate = new Date("March 2, 2024 09:30:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

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
  document.getElementById("days").innerHTML = days;
    document.getElementById("hours").innerHTML = hours;
    document.getElementById("mins").innerHTML = minutes;
    document.getElementById("secs").innerHTML = seconds;

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
@endsection
