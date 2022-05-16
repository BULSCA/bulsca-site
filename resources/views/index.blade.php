@extends('layout')

@section('content')



  <div class="h-[50vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
      <div class="absolute top-0 right-0 w-full h-full head-bg flex items-center justify-center transition-opacity   duration-1000" id="head1">
        <img src="./storage/logo/blogo.png" class="md:w-[12.5%] w-[50%] h-auto" alt="">
      </div>
      <div class="absolute top-0 right-0 w-full h-full head-bg-2 flex items-center justify-center transition-opacity opacity-0 duration-1000 z-20" id="head2">
        <img src="./storage/logo/blogo.png" class="md:w-[12.5%] w-[50%] h-auto" alt="">
      </div>
    </div>

    
  </div>


  <div class=" container ">
    <div class=" grid md:grid-cols-3 grid-cols-1 overflow-hidden md:gap-32 text-center">
      <div class="flex flex-col items-center space-y-3 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
        </svg>
        <h2 class="text-2xl font-semibold ">Acting Governing Body</h2>
        <p class="">
          BULSCA acts as the governing body for lifesaving sport while at University. We are an organisation overseeing the development of university lifesaving clubs, and ensure the smooth-running of an annual league.
        </p>
      </div>
      <div class="flex flex-col items-center space-y-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h2 class="text-2xl font-semibold ">By Students, For Students</h2>
        <p>
          The BULSCA committee is made up entirely of volunteers, either current students or graduates from higher education institutions. 
        </p>
      </div>
      <div class="flex flex-col items-center space-y-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
        </svg>
        <h2 class="text-2xl font-semibold ">Our aims</h2>
        <p>
          Our aims are to promote the training and development of lifesaving skills, to promote and develop lifesaving as a sport and to oversee competitive lifesaving between Higher Education institutions.
        </p>
      </div>
    </div>
  </div>
  <div class="container-boast">
    <h1 class="text-white text-3xl font-bold uppercase text-center md:text-left">Champs 2022 Kindly sponsored by <span class=" underline underline-offset-3 ">Ben Barker</span> </h1>
    <button class="btn md:ml-auto flex flex-row items-center mt-8 md:mt-0">
      Find out more
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
      </svg>
    </button>
  </div>

@endsection