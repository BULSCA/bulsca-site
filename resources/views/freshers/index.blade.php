@extends('layout')

@section('title')
    Freshers |
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full bg-bulsca   flex  items-center justify-center ">
                <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h1 class="md:text-6xl text-4xl font-bold text-white">Freshers</h1>
                    <p class="text-white">Welcome to univeristy lifesaving!</p>
                </div>
            </div>

        </div>


    </div>

    <div class="container-responsive">

        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque sed iste rerum quaerat nesciunt dicta beatae
            minima dolor dolorum in, ad illum consectetur delectus voluptate nostrum amet dolore fuga ut.
            Soluta sequi quod officiis, facere recusandae fugiat non placeat suscipit dolores nostrum voluptatum cumque quo
            hic quas omnis repellendus cum alias deleniti sed aut itaque eius dicta. Cupiditate, nisi non!
            Amet possimus, fugit similique natus saepe corporis dolorum laborum, sunt architecto magnam, quisquam eveniet.
            Tenetur saepe unde dolorem dicta nostrum cupiditate corrupti inventore! Maiores voluptatem laudantium inventore
            voluptas et incidunt!
            <br>
            <br>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor vel iusto commodi cum saepe, tempora nesciunt
            quae eos laboriosam sequi aliquid id vero, delectus, est quibusdam minus aspernatur! Modi, culpa?
            Voluptatem ex fugiat quod sunt ipsam quam! Odit unde ducimus, reiciendis repellendus consequatur recusandae
            incidunt veniam quia. Deserunt tenetur impedit ipsa, ratione error ullam ipsam quisquam aliquid aut dolorem
            sint!
            Porro rerum a fuga nisi dolores. Quis culpa suscipit ad blanditiis. Saepe, placeat fuga aliquam at ut fugiat
            tempore consequatur culpa assumenda. Obcaecati sunt rem inventore et, quam dolorem laboriosam!
        </p>
    </div>


    <div class="container-responsive ">
        <div class="w-full flex justify-center relative">
            {{-- <div class="absolute w-[90%] h-full flex items-center justify-center" style="background-image: url('https://img.youtube.com/vi/5Jz1vySXorw/maxresdefault.jpg'); background-repeat: no-repeat; background-size: cover;">
 
        </div> --}}
            <iframe class="w-[90%] aspect-video"
                src="https://www.youtube-nocookie.com/embed/5Jz1vySXorw?si=RaieqnAttSfZUdNE" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>

    </div>

    <div class="container-responsive">
        <h2>The Clubs</h2>


        <div class="w-full flex flex-col-reverse md:flex-row ">
            <div class="w-full md:w-[30%]" id="club-cards">

                @foreach (\App\Models\University::orderBy('name')->get() as $club)
                    <div x-club-name="{{ $club->name }}" x-club-loc="{{ $club->location }}"
                        class="bg-bulsca w-full flex items-center space-x-5 px-5 py-3 hover:scale-x-105 border-y last-of-type:border-b-0 first-of-type:border-t-0 hover:bg-bulsca_red cursor-pointer">


                        <div class="w-5 aspect-square  overflow-hidden flex items-center justify-center pointer-events-none ">
                            <img src="{{ $club->image_path ? route('image', $club->image_path) : '/storage/logo/blogo.png' }}"
                                class="w-full  " alt="">
                        </div>

                        <h5 class="text-white hmb-0 pointer-events-none text-ellipsis overflow-hidden">{{ $club->name }}</h5>

                        <div class="flex  " style="margin-left: auto !important">
                            <a href='{{ route('clubs') }}/{{ Str::lower($club->name) . '.' . $club->id }}' target="_blank"
                                class=" text-white text-xs flex items-center justify-center hover:text-bulsca no-underline ">More <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                  </svg>
                              </a>
                              
                            
                        </div>



                    </div>
                @endforeach

            </div>
            <div class="relative flex flex-grow z-20 bg-white h-[500px] md:h-auto w-full">
                <div id="club-map" style="width: 100%; height: 100%; "
                    x-locations="{{ \App\Models\University::orderBy('name')->whereNotNull('location')->get(['name', 'id', 'location'])->toJson() }}">
                </div>
                <div class="absolute bottom-0 left-0 w-full border-t-2 border-white  bg-bulsca flex items-center px-16"
                    id="map-club-bar" style="display: none; height: {{ (1 / \App\Models\University::count()) * 100 * 1 }}%;">
                    <h3 class="text-white hmb-0">Warwick</h3>
                </div>
            </div>
        </div>







    </div>
@endsection
