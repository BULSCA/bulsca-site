@extends('layout')

@section('title')
Welfare |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
        <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
            <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
            <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                <h2 class="md:text-6xl text-4xl font-bold text-white">Welfare</h2>

            </div>
        </div>

    </div>


</div>

<a href="{{ route('welfare.help-and-reporting') }}#report-now" class="notification-stripe ns-red">
    Need to report a welfare concern? Click here now!
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
    </svg>
</a>

<div class=" container-responsive ">
    <div class="grid md:grid-cols-2 grid-cols-1">
        <div class="flex items-center justify-center md:mt-0 mt-4">
            <img src="/storage/photos/welfare2.svg" loading="lazy" class="w-[90%]" alt="">
        </div>

        <div class="flex flex-col justify-center">
            <h1>Welcome </h1>
            <p>
                to the Welfare Section of the BULSCA website where we have information, resources and contact information.
                <br><br>
                My name is Kirsty (She/Her) and I am the BULSCA Welfare Officer for the 2022/23 year. I am in my second year at the University of Warwick and have been involved in lifesaving since I was in primary school.

            </p>
        </div>



    </div>
</div>

<div class="container-boast">
    <div>
        <p class="text-white text-2xl">
            We all know university can be a challenging time and whilst we hope lifesaving is a space for you to meet friends, relax and stay active, we also know it comes with its challenges. <br><br> BULSCA has a <strong>zero-tolerance policy</strong> for bullying, discrimination and harassment in any form and we place diversity, inclusion and welfare at the heart of what we do. <br><br> Our Diversity and Inclusion Policy was unanimously passed this year. As part of our ongoing commitment to inclusion, we are developing some new processes and practices to go alongside this policy.</p>
    </div>


</div>

<div class=" container-responsive ">
    <div class=" image-link-group">
        <div class=" image-link ">
            <a href="{{ route('welfare.help-and-reporting') }}" class="">Help and Reporting</a>
        </div>
        <div class=" image-link ">
            <a href="{{ route('welfare.inclusion-and-accessibility') }}" class="">Inclusion and Accessibility</a>
        </div>


    </div>

</div>








@endsection