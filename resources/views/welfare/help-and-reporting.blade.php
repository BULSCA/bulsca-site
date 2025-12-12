@extends('layout')

@section('title')
    Support and Reporting | Welfare |
@endsection

@section('content')
    <x-page-banner
        title="Support and Reporting"
        :snowContainer="true"
    />



    <div class=" container-responsive ">
        <div class="grid md:grid-cols-2 grid-cols-1">
            <div class="flex items-center justify-center md:mt-0 mt-4">
                <img src="/storage/photos/welfare1.png" loading="lazy" class="w-[90%]" alt="">
            </div>

            <div class="flex flex-col justify-center">
                <h2>Mental health and wellbeing </h2>
                <p>
                    Struggling with your mental health can be incredibly difficult and isolating but there is help
                    available. Please remember to reach out to someone you trust.

                    <br><br>

                    If you feel you need to speak to someone about your wellbeing or mental health these resources can be
                    accessed immediately:

                    <br><br>

                    <strong><u>Samaritans</u> can be contacted anytime for free on 116 123 or by emailing <a
                            href="mailto:jo@samaritans.org" class="link">jo@samaritans.org</a>,

                        <u>Shout Textline</u> can be contacted via text: Text ‘SHOUT’ to 85258 24/7.</strong>

                </p>
            </div>



        </div>
    </div>

    <div class="container-boast">
        <div>
            <p class="text-white text-2xl font-bold">
                For medical advice please always call 111 (non-urgent) or 999 if you or someone you are with is an immediate
                danger to themselves or others.</p>
        </div>


    </div>

    <div class="container-responsive">
        <p>
            Trying to find the right support can be overwhelming, especially in times of difficulty. Please remember to
            reach out to someone you trust. If you aren’t sure who to speak to please contact me at welfare@bulsca.co.uk for
            further guidance. Reaching out to someone is a difficult but often a great first step.
        </p>
        <br>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p>Mental Health and Wellbeing</p>
                <ul class=" list-disc list-inside indent-4">
                    <li><a href="https://www.studentminds.org.uk/"
                            rel="noopener noreferrer">https://www.studentminds.org.uk/</a> </li>
                    <li><a href="https://www.youngminds.org.uk/"
                            rel="noopener noreferrer">https://www.youngminds.org.uk/</a></li>
                    <li><a href="https://www.themix.org.uk/" rel="noopener noreferrer">https://www.themix.org.uk/</a></li>
                    <li><a href="https://www.mind.org.uk/" rel="noopener noreferrer">https://www.mind.org.uk/ </a></li>
                </ul>
            </div>
            <div>
                <p>Sexual Assault and Harassment</p>
                <ul class=" list-disc list-inside indent-4">
                    <li><a href="https://rapecrisis.org.uk/" rel="noopener noreferrer">https://rapecrisis.org.uk/</a> </li>
                    <li><a href="https://www.victimsupport.org.uk/"
                            rel="noopener noreferrer">https://www.victimsupport.org.uk/ </a></li>
                </ul>
            </div>
            <div>
                <p>Support for Minority Groups</p>
                <ul class=" list-disc list-inside indent-4">
                    <li><a href="https://switchboard.lgbt/" rel="noopener noreferrer">https://switchboard.lgbt/</a> </li>
                    <li><a href="https://www.blackmindsmatteruk.com/"
                            rel="noopener noreferrer">https://www.blackmindsmatteruk.com/</a></li>
                    <li><a href="https://www.scope.org.uk/" rel="noopener noreferrer">https://www.scope.org.uk/</a></li>
                    <li><a href="https://mermaidsuk.org.uk/" rel="noopener noreferrer">https://mermaidsuk.org.uk/</a></li>
                </ul>
            </div>
        </div>
        <br>

    </div>
    <div class="container-responsive">
        <h2>University Support</h2>
        <p>Each of your respective universities has their own well-being services; if you are struggling to find these, they
            are linked below:
            <br>
            <br>
        <div class=" grid md:grid-1 grid-3 text-center">
            <a href="https://intranet.birmingham.ac.uk/student/your-wellbeing/index.aspx"
                rel="noopener noreferrer">Birmingham</a>
            <a href="https://warwick.ac.uk/services/wss/" rel="noopener noreferrer">Warwick</a>
            <a href="http://www.bristol.ac.uk/students/support/wellbeing/request-support/services/"
                rel="noopener noreferrer">Bristol</a>
            <a href="https://www.nottingham.ac.uk/studentservices/services/support-and-wellbeing-service.aspx"
                rel="noopener noreferrer">Nottingham</a>
            <a href="https://www.ox.ac.uk/students/welfare" rel="noopener noreferrer">Oxford</a>
            <a href="https://www.swansea.ac.uk/student-support-services/" rel="noopener noreferrer">Swansea</a>
            <a href="https://www.plymouth.ac.uk/student-life/services/student-services/counselling"
                rel="noopener noreferrer">Plymouth</a>
            <a href="https://www.southampton.ac.uk/edusupport/mental_health_and_wellbeing/index.page"
                rel="noopener noreferrer">Southampton</a>
            <a href="https://www.lboro.ac.uk/services/cds/wellbeing/mental-health/"
                rel="noopener noreferrer">Loughborough</a>
            <a href="https://www.sheffield.ac.uk/departments/student-support-services#overview"
                rel="noopener noreferrer">Sheffield</a>
            <a href="https://www.durham.ac.uk/colleges-and-student-experience/student-support-and-wellbeing/"
                id="report-now" rel="noopener noreferrer">Durham</a>
        </div>
        </p>
    </div>

    <div class="container-responsive">
        <h2>Reporting Welfare Concerns</h2>
        <p>We all have a <strong>responsibility</strong> to look out for each other. If something does not seem right please
            do raise it as a concern.
            This is the best way to ensure our community and its members are safe and supported. There are two ways in which
            you can raise a concern or report a welfare issue:

            <br>
            <br>
            The first is to email me at <a href="mailto:welfare@bulsca.co.uk" class="link">welfare@bulsca.co.uk</a>. This
            way is by nature not confidential but you can provide as many or as few details as you would like to. This will
            be followed up and dealt with in line with both our policies and your wishes.
            confidentiality and in line with BULSCA policy and your wishes.

            <br>
            <br>
            Alternatively, suppose you would simply like to draw the Welfare Officer’s attention to an issue or incident
            without providing any personal details. In that case, you can do so using the reporting form below:
        </p>
        <br><br>
        <div class="flex items-center justify-center">
            <iframe
                src="https://docs.google.com/forms/d/e/1FAIpQLScDnXdmT9k1Xfa95ufxWe0AYQi1rdAw6nPOE2MUiQpsizXheA/viewform"
                class="md:w-[60%] w-[99%] h-[40rem]" frameborder="0"></iframe>
        </div>
        <br>
        <br>
        <p> Please be aware that the use of the welfare reporting form does not initiate disciplinary action. It provides
            the opportunity for further support and signposting and the opportunity to raise an issue you feel exists within
            the organisation without providing specific details.</p>
    </div>
@endsection
