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

<a href="{{ route('welfare.help-and-reporting') }}#report-now" class="notification-stripe ns-red">
    Need to report a welfare concern? Click here now!
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
    </svg>
</a>

<div class=" container-responsive ">
    <div class="grid md:grid-cols-2 grid-cols-1">
        <div class="flex items-center justify-center md:mt-0 mt-4">
            <img src="/storage/photos/welfare3.png" loading="lazy" class="w-[90%]" alt="">
        </div>

        <div class="flex flex-col justify-center">
            <h2>Inclusion and Accessibility</h2>
            <p>
                In line with the BULSCA inclusion policy, we have a duty to make reasonable adjustments for participants with a disability or long-term health condition (as defined under the 2010 Equality Act). There are two ways in which you can inform us about access requirements. Your club will include the option to request an adjustment on each competition sign-up form. However, we understand you may not wish to disclose this directly to your club or may want further advice. In this instance please email <a href="mailto:welfare@bulsca.co.uk">welfare@bulsca.co.uk</a> or alternatively can use this enquiry form: <a href="https://docs.google.com/forms/d/e/1FAIpQLSdtKGF_wtuFVHs2EH7MDXhxg1blHmj_WJC8yAhBVytyFrwqYw/viewform">Access and Adjustments Enquiry Form</a>
            </p>

        </div>



    </div>
    <br>
    <div class="flex items-center justify-center">
        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdtKGF_wtuFVHs2EH7MDXhxg1blHmj_WJC8yAhBVytyFrwqYw/viewform" class="md:w-[60%] w-[99%] h-[40rem]" frameborder="0"></iframe>
    </div>
    <br><br>
    <p>
        We are also aware that you may not fully know what adjustments are required or are suitable for you before attending a competition. The Welfare Officer keeps an anonymized copy of potential adjustments that have been made in the past to assist with planning future adjustment requests. Therefore, if you would like to discuss adjustments further either for yourself or for a member of your club <strong>please do get in touch!</strong>
    </p>
    <br>
    <br>
    <h3>Previous Adjustments</h3>
    <ul class=" list-disc list-inside indent-4">
        <li>Heat lane allocations can be chosen to place specific swimmers near the starting referee or the edge of the pool</li>
        <li>Starting in the water</li>
        <li>Visual cues for starting races</li>
        <li>Large print or easy-read font for the printed SERC brief</li>
    </ul>
</div>














@endsection