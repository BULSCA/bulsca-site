@extends('layout')

@section('title')
    Welfare |
@endsection

@section('meta')
    Welcome to the Welfare Section of the BULSCA website where we have information, resources and contact information.
@endsection

@section('content')
    <x-page-banner
        title="Welfare"
        logo="/storage/photos/welfare2.svg"
        :snowContainer="true"
    />



    <div class=" container-responsive ">
        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
            @php
                $member = $welfare->currentMember();
            @endphp

            <div class="md:flex-[2] flex-2">
                <div class="flex flex-col justify-center p-4">
                    <h1>Welcome </h1>
                    <p>
                        to the Welfare Section of the BULSCA website where we have information, resources and contact
                        information.
                        <br><br>
                        The BULSCA committee appoints a welfare and inclusion officer who is responsible for competition access,
                        welfare and inclusion. {{ $welfare ? $welfare->currentMemberName() : 'The Welfare Officer' }} can be contacted using <a href="{{ route('contact') }}?department=welfare"
                            class="link">our contact form</a> and you can meet them and the rest of the committee <a
                            href="{{ route('get-involved.committee') }}" class="link">here</a>.

                    </p>
                </div>
            </div>

            <div class="md:flex-[1] flex-1">
                <div class="flex flex-col justify-between items-center rounded-md border no-underline text-center overflow-hidden min-h-80 w-56">
                    <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center mt-4 mx-4">
                        <img src="{{ $member->image_path ? route('image', $member->image_path) : '/storage/logo/blogo.png' }}" class="w-full h-full" alt="">
                    </div>
                    <h3 class="header header-smallish px-4">
                        {{ $member->name }}
                    </h3>
                    <div class="bg-bulsca w-full font-semibold text-white p-2 rounded-b text-center">
                        {{ $member->role->label }}
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="container-boast">
        <div class="flex flex-col justify-center">
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
