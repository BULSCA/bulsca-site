@extends('layout')

@section('title')
    Inclusion and Accessibility | Welfare |
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
                <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h2 class="md:text-6xl text-4xl text-center font-bold text-white">Inclusion and Accessibility</h2>

                </div>
            </div>

        </div>


    </div>



    <div class=" container-responsive ">
        <div class="grid md:grid-cols-2 grid-cols-1">
            <div class="flex items-center justify-center md:mt-0 mt-4">
                <img src="/storage/photos/welfare3.png" loading="lazy" class="w-[90%]" alt="">
            </div>

            <div class="flex flex-col justify-center">
                <h2>Inclusion and Accessibility</h2>
                <p>
                    In line with the BULSCA inclusion policy, we have a duty to make reasonable adjustments for participants
                    with a disability or long-term health condition (as defined under the 2010 Equality Act).
                    <br>
                    <br>
                    Adjustments are assessed against the extent to which they remove a barrier to accessing the sport and do
                    not exist to provide a competitive advantage. Decisions on adjustments are made in conjunction with the
                    participant, the welfare officer and the judging panel to ensure they are effective.
                    <br>
                    <br>
                    The adjustment process is outlined in the document below. If you have any further questions or access
                    requests please email <a href="mailto:welfare@bulsca.co.uk">welfare@bulsca.co.uk</a>.
                </p>

            </div>



        </div>
        <br>


        <br>
        <br>

        <div class="grid-2">
            <div>
                <h3>Example Adjustments</h3>
                <ul class=" list-disc list-inside indent-4">
                    <li>Outer lane allocation for easy access out/in the water</li>
                    <li>Visual cues for starting races</li>
                    <li>Large print available for the printed SERC brief</li>
                    <li>Provisions for quieter spaces away from poolside</li>
                </ul>
            </div>
            <div class="flex flex-col space-y-3">
                <h3>Resources</h3>
                <div class="file-link" title='Diversity and Inclusions Policy'>
                    <a href='{{ route('view-resource', 'c1f8e739-5c93-4d5a-9341-f5a27632c12b') }}' target='_blank'>
                        <div>
                            <h3>Diversity and Inclusions Policy</h3>
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

                <div class="file-link" title='Adjustment Guidance'>
                    <a href='{{ route('view-resource', 'b6b827f2-42b6-4ed4-a11e-1e67441e987b') }}' target='_blank'>
                        <div>
                            <h3>Adjustment Guidance</h3>
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
            </div>
        </div>


    </div>
@endsection
