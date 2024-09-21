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
                    to the Welfare Section of the BULSCA website where we have information, resources and contact
                    information.
                    <br><br>
                    The BULSCA committee appoints a welfare and inclusion officer who is responsible for competition access,
                    welfare and inclusion. They can be contacted at <a href="mailto:welfare@bulsca.co.uk"
                        class="link">welfare@bulsca.co.uk</a> and you can meet them and the rest of the committee <a
                        href="{{ route('get-involved.committee') }}" class="link">here</a>.

                </p>
            </div>



        </div>
    </div>

    <div class="container-boast">
        <div>
            <p class="text-white text-2xl">
                We want university lifesaving to be a welcoming place for all and have a <strong>zero-tolerance</strong>
                policy for bullying, discrimination and harassment. Our approach to Diversity and Inclusion is outlined in
                our policy <a href="{{ route('view-resource', 'c1f8e739-5c93-4d5a-9341-f5a27632c12b') }}"
                    class="text-white no-underline hover:underline">here</a>. However, welfare and inclusion are part of the
                culture of
                BULSCA.
                This means
                being considerate in the way we treat, communicate and involve one another in all our encounters.
            </p>
            <br>
            <br>
            <p class="text-white text-2xl">
                If you have any questions or concerns, or simply want to discuss any matter related to welfare or inclusion,
                please get in touch with the welfare officer via the email address above.
            </p>
        </div>


    </div>

    <div class=" container-responsive ">


        <div class=" image-link-group">
            <div class=" image-link ">
                <a href="{{ route('welfare.help-and-reporting') }}" class="">Support and Reporting</a>
            </div>
            <div class=" image-link ">
                <a href="{{ route('welfare.inclusion-and-accessibility') }}" class="">Inclusion and Accessibility</a>
            </div>


        </div>

    </div>
@endsection
