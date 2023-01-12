@extends('layout')

@section('title')
Championships 2023 | Competitions |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
        <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
            <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
            <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                <h2 class="md:text-6xl text-4xl font-bold text-white">Championships 2023</h2>
                <p class="text-white">Presented by Chloe Warr</p>
            </div>
        </div>

    </div>


</div>

<div class="container-responsive space-y-2">

    <div class="flex flex-row justify-between items-center -mb-1">
        <h1>Championships 2023</h1>
        <a href="#" target="_blank" rel="noopener noreferrer" class="btn btn-thinner inline-flex items-center mt-2 disabled">Entry Form <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg></a>
    </div>
    <small>18-19th March 2023 at K2 Crawley</small>
    <br><br>
    <p class="text-center font-bold">More information available soon!</p>

</div>







@endsection