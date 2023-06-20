@extends('layout')

@section('title')
Welfare |
@endsection

@section('meta')
Welcome to the Welfare Section of the BULSCA website where we have information, resources and contact information.
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
                The BULSCA Welfare and Inclusion Officer is an appointed person responsible for competition access, welfare and inclusion. This year's Welfare and Inclusion Officer is Kirsty (She/Her). She can be contacted at <a href="mailto:welfare@bulsca.co.uk">welfare@bulsca.co.uk</a>

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