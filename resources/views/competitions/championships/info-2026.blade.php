@extends('layout')

@section('title')
    Championships 2026 | Competitions |
@endsection

@section('extra-meta')
    <meta property="og:image" content="{{ asset('storage/photos/champs/2026/champs-logo.JPG') }}">
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full flex items-center justify-center "
                style="background-color: #004490">
                <img src="/storage/photos/champs/2026/champs-logo-2.JPG" class="w-[13%] hidden md:block" alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8 text-center">
                    <h2 class="md:text-6xl text-4xl font-bold text-white mt-5 lg:mt-0">Championships 2026</h2>
                    <p class="text-white">Presented by Katy Nicholls</p>
                </div>
            </div>

        </div>


    </div>


    <div class="container-responsive space-y-2">

        <div class="md:hidden w-full flex items-center justify-center pb-2 -mt-6">
            <img src="/storage/photos/champs/2026/champs-logo.JPG" class="w-[90%] " alt="">
        </div>

        <div class="flex flex-col lg:flex-row justify-between lg:items-center -mb-1">
            <p class="font-semibold text-bulsca text-4xl lg:text-5xl">Championships 2026</p>
            <div class="flex flex-col md:flex-row md:items-center justify-center md:space-x-3">
                <a href="https://forms.gle/ro1aeNhSBiAYMSuJ8" target="_blank" rel="noopener noreferrer"
                    class="btn btn-thinner  inline-flex items-center mt-2  ">Online
                    Registration <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg></a>
                <a href="#entries" class="btn btn-thinner disabled inline-flex items-center mt-2">Entry Forms <svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-6 w-6 ml-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </a>
            </div>
        </div>
        <small>7th-8th March 2026 at Liverpool Aquatics Centre</small>

        <br>

        <div class="  text-center font-semibold text-bulsca_red text-xl py-5">
            Please see the <a class="link" href="{{ route('view-resource', '2a8539c6-8808-452c-9d59-d2ce37c0c7a5') }}"
                target="_blank">Info Pack</a> for full details.
        </div>
        <div class="sm:grid  xl:grid-cols-3 sm:grid-cols-2  space-y-3  md:space-y-0">

            <div>
                <h2 class="">Costs</h2>
                <p>
                    <strong>£45</strong> per competitor in a Squad,
                    <br>
                    <br>
                    <strong>OR</strong>
                    <br>
                    <br>
                    <strong>£8</strong> per individual event, <br><strong>£20</strong> per relay (4x£5),
                    <br>
                    <strong>£50</strong> per sunday team

                </p>
            </div>
            <div>
                <h2 class="-mb-1">Accommodation</h2>
                <small class="">(available Friday and Saturday night)</small>
                <p class="mt-1">
                    <strong>£5</strong> for 2 nights
                    <br>
                    <strong>£3</strong> for 1 night
                </p>
                <a href="https://forms.gle/dzimjsJKLhwoue9Q7" target="_blank" rel="noopener noreferrer"
                    class="btn btn-thinner  inline-flex items-center mt-2  ">Competitors only form<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg></a>
            </div>
            <div>
                <h2 class="">Merch</h2>
                <small class="">(deadline 1st February at 23:59)</small>

                <div class=" list-inside list-disc md:w-[50%] ">
                    <div class="flex justify-between">Sports t-shirt <strong class="ml-auto">£15</strong></div>
                    <div class="flex justify-between">Swim hat <strong>£8</strong></div>
                </div>
                <a href="https://forms.gle/tSF9UmHbYGi4guxR8" target="_blank" rel="noopener noreferrer"
                    class="btn btn-thinner  inline-flex items-center mt-2  ">Merchandise form<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg></a>
                <br>

            </div>

        </div>
 


        {{-- <p class="text-center font-bold">

            <br>


            <hr>
            <br>

        <h2 id="entries" class="">Entries</h2>
        <br>
        <div class="grid-3">
            <div class="flex items-center justify-center">
                <a href="https://forms.gle/yQQkkzsMaEyPGpSQ6" target="_blank" rel="noopener noreferrer"
                    class="btn btn-thinner inline-flex items-center">Competitors <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
            <div class="flex items-center justify-center"><a href="https://forms.gle/xRbuYBCYhvkC8aS56" target="_blank"
                    rel="noopener noreferrer" class="btn btn-thinner inline-flex items-center">Officials <svg
                        xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg></a></div>
            <div class="flex items-center justify-center"><a href="https://forms.gle/TrM9rUGeqZMVkg3s7" target="_blank"
                    rel="noopener noreferrer" class="btn btn-thinner inline-flex items-center">Helpers <svg
                        xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg></a></div>
        </div>
        <br> --}}




    </div>
@endsection
