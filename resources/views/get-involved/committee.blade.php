@extends('layout')

@section('title')
    Committee | Get Involved |
@endsection

@section('meta')
    The BULSCA Committee have been running since 2002 and are responsible for keeping things in check and ensuring the
    longevity of the association.
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
                <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h2 class="md:text-6xl text-4xl font-bold text-white">Committee</h2>
                    <p class="text-white"></p>
                </div>
            </div>

        </div>


    </div>


    @if ($time)
        <div class="container-responsive mb-5">
            <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                <div class="flex flex-col items-center justify-center basis-1/5 py-4 rounded-lg animate-pulse ">
                    <div class="rounded-full w-56 h-56 overflow-hidden flex items-center justify-center">
                        <img src="/storage/photos/ben.jpg" alt="">
                    </div>
                    <h3 class="header py-4 px-3 border-b border-gray-400">
                        Ben Barker
                    </h3>
                    <p class=" text-gray-600 font-semibold">
                        Lord of Lifesaving
                    </p>
                </div>
                <div class="flex flex-col items-center justify-center basis-1/5 py-4 rounded-lg animate-pulse ">
                    <div class="rounded-full w-56 h-56 overflow-hidden">
                        <img src="/storage/photos/adaml.jpg" alt="">
                    </div>
                    <h3 class="header  py-4 px-3 border-b border-gray-400">
                        Adam Lane
                    </h3>
                    <p class=" text-gray-600 font-semibold">
                        Legend
                    </p>
                </div>
                <div class="flex flex-col items-center justify-center basis-1/5 py-4 rounded-lg animate-pulse ">
                    <div class="rounded-full w-56 h-56 overflow-hidden">
                        <img src="/storage/photos/noah.jpg" alt="">
                        alt="">
                    </div>
                    <h3 class="header header py-4 px-3 border-b border-gray-400">
                        Noah Hollowell
                    </h3>
                    <p class=" text-gray-600 font-semibold">
                        Get Data Managed
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="container-responsive">
        <div class="md:flex md:flex-wrap gap-2 gap-y-20 justify-center grid grid-cols-1  ">

            <div class="flex flex-col items-center justify-center md:basis-1/5 ">
                <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
                    <img src="/storage/photos/committee/chair.jpg" class="w-full h-full " alt="">
                </div>
                <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
                    Tom Park
                </h3>
                <p class=" text-gray-600 font-semibold">
                    Chair
                </p>
            </div>

            <div class="flex flex-col items-center justify-center md:basis-1/5 ">
                <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
                    <img src="/storage/photos/committee/secretary.jpg" class="w-full h-full" alt="">
                </div>
                <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
                    Annabel Cruse
                </h3>
                <p class=" text-gray-600 font-semibold">
                    Secretary
                </p>
            </div>

            <div class="flex flex-col items-center justify-center md:basis-1/5 ">
                <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
                    <img src="/storage/photos/committee/treasurer.jpg" class="w-full h-full" alt="">
                </div>
                <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
                    Anton Oleinik
                </h3>
                <p class=" text-gray-600 font-semibold">
                    Treasurer
                </p>
            </div>

            <div class="flex flex-col items-center justify-center md:basis-1/5 ">
                <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
                    <img src="/storage/photos/committee/club_dev.jpg" class="w-full h-full" alt="">
                </div>
                <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
                    Amy Parnell
                </h3>
                <p class=" text-gray-600 font-semibold">
                    Club Development
                </p>
            </div>


            <div class="flex flex-col items-center justify-center md:basis-1/5 ">
                <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
                    <img src="/storage/photos/committee/communications.jpg" class="w-full h-full" alt="">
                </div>
                <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
                    Katy Nicholls
                </h3>
                <p class=" text-gray-600 font-semibold">
                    Communications Officer
                </p>
            </div>


            <div class="flex flex-col items-center justify-center md:basis-1/5 ">
                <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
                    <img src="/storage/photos/committee/data_manager.jpg" class="w-full h-full" alt="">
                </div>
                <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
                    Noah Hollowell
                </h3>
                <p class=" text-gray-600 font-semibold">
                    Data Manager
                </p>
            </div>


            <div class="flex flex-col items-center justify-center md:basis-1/5 ">
                <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
                    <img src="/storage/photos/committee/champs.jpg" class="w-full h-full" alt="">
                </div>
                <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
                    Glafki Schellekens
                </h3>
                <p class=" text-gray-600 font-semibold">
                    Championships Coordinator
                </p>
            </div>

            <div class="flex flex-col items-center justify-center md:basis-1/5 ">
                <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center">
                    <img src="/storage/photos/committee/welfare.jpg" class="w-full h-full" alt="">
                </div>
                <h3 class="header header-smallish py-4 px-3 border-b border-gray-400">
                    Kirsty Reed
                </h3>
                <p class=" text-gray-600 font-semibold">
                    Welfare Officer
                </p>
            </div>


        </div>
    </div>
@endsection
