@extends('layout')

@section('title')
    Championships 2024 | Competitions |
@endsection

@section('extra-meta')
    <meta property="og:image" content="{{ asset('storage/photos/champs/2024/champs_2024_light.png') }}">
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
                <img src="/storage/photos/champs/2024/champs_2024_light.png" class="w-[13%] hidden md:block" alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8 text-center">
                    <h2 class="md:text-6xl text-4xl font-bold text-white mt-5 lg:mt-0">Championships 2024</h2>
                    <p class="text-white">Presented by Glafki Schellekens </p>
                </div>
            </div>

        </div>


    </div>


    <div class="container-responsive space-y-2">

        <div class="md:hidden w-full flex items-center justify-center pb-2 -mt-6">
            <img src="/storage/photos/champs/2024/champs_2024_light.png" class="w-[90%] " alt="">
        </div>

        <div class="flex flex-col lg:flex-row justify-between lg:items-center -mb-1">
            <p class="font-semibold text-bulsca text-4xl lg:text-5xl">Championships 2024</p>
            <div class="flex flex-col md:flex-row md:items-center justify-center md:space-x-3">
                <a href="#" class="btn btn-thinner disabled inline-flex items-center mt-2  ">Online
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
        <small>2nd-3rd March 2024 at Alan Higgs Centre</small>

        <br>

        <div class="grid-3">
            <div class=" col-span-3 text-center font-semibold">
                More infomation available soon!
            </div>
            {{-- <div>
                <h2 class="">Costs</h2>
                <p>
                    <strong>£55</strong> per competitor in a Squad,
                    <br>
                    <br>
                    <strong>OR</strong>
                    <br>
                    <br>
                    <strong>£7.50</strong> per individual event, <br><strong>£20</strong> per relay (4x£5)
                </p>
            </div>
            <div>
                <h2 class="-mb-1">Accommodation</h2>
                <small class="">(available Friday and Saturday night)</small>
                <p class="mt-1">
                    <strong>£5</strong> per person per night.
                    <br>
                </p>
            </div>
            <div>
                <h2 class="">Merch</h2>
                <strong>Merch orders are now closed!</strong>


                <ul class=" list-inside list-disc">
                    <li>T-Shirt <strong class="ml-auto">£20</strong></li>
                    <li>Swimming Hat <strong>£7.50</strong></li>

                </ul>
                <br>

            </div> --}}

        </div>
        <br>




        <br>
        <br>
        {{-- <div class="grid-3">
            <div class="file-link" title='Info Pack 2023'>
                <a href='{{ route('view-resource', 'f646b5b5-4e3a-41ad-975e-9d92047a3cf6') }}' target='_blank'>
                    <div>
                        <h3>Info Pack 2023</h3>
                        <small>Click to download</small>
                    </div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>
                    </div>
                </a>
            </div>


            <div class="file-link" title='Entry Pack 2023'>
                <a href='{{ route('view-resource', '1eba40c0-7aa9-457c-946a-f2c56b36c330') }}' target='_blank'>
                    <div>
                        <h3>Entry Pack 2023</h3>
                        <small>Click to download</small>
                    </div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="file-link" title='BULSCA Championships Rules 2023'>
                <a href='{{ route('view-resource', '3790de53-b1d8-494e-9063-d82b9750fa5e') }}' target='_blank'>
                    <div>
                        <h3>BULSCA Championships Rules 2023</h3>
                        <small>Click to download</small>
                    </div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>
                    </div>
                </a>
            </div>
        </div> --}}

        {{-- <p class="text-center font-bold">

            <br>


            <hr>
            <br>

        <h2 id="entries" class="">Entries</h2>
        <br>
        <div class="grid-3">
            <div class="flex items-center justify-center">
                <a href="https://forms.gle/KD4u9khgc3RxWCn19" target="_blank" rel="noopener noreferrer"
                    class="btn btn-thinner inline-flex items-center">Competitors <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
            <div class="flex items-center justify-center"><a href="https://forms.gle/8QzCdxfx2bZUM5d57" target="_blank"
                    rel="noopener noreferrer" class="btn btn-thinner inline-flex items-center">Officials <svg
                        xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg></a></div>
            <div class="flex items-center justify-center"><a href="https://forms.gle/V6V4WmNCWKxn3ia86" target="_blank"
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
