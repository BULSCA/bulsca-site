@extends('layout')

@section('title')
    Help and Reporting | Welfare |
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
                <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h2 class="md:text-6xl text-4xl font-bold text-white">Help and Reporting</h2>

                </div>
            </div>

        </div>


    </div>



    <div class=" container-responsive ">
        <div class="grid md:grid-cols-2 grid-cols-1">
            <div class="flex items-center justify-center md:mt-0 mt-4">
                <img src="/storage/photos/welfare1.png" loading="lazy" class="w-[90%]" alt="">
            </div>

            <div class="flex flex-col justify-center">
                <h2>Mental health and wellbeing </h2>
                <p>
                    Student well-being and mental health is a huge topic and one that is really important. Amongst essays,
                    coursework, exams, housing, friendships, relationships, cooking and living independently… university
                    life can throw a lot at you! There are simple things you can do to look after your well-being but also
                    remember just as you would if you were physically unwell, it is really important to reach out for help
                    if you have concerns about your mental health or wellbeing.
                </p>
            </div>



        </div>
    </div>

    <div class="container-boast">
        <div>
            <p class="text-white text-2xl font-bold">
                If you are struggling with your well-being or mental health and would like to speak to someone about this
                more, please see the resources below:</p>
        </div>


    </div>

    <div class="container-responsive">
        <p>
            Resources for immediate access:
        <ul class=" list-disc list-inside indent-4">
            <li><strong>Samaritans</strong> can be contacted anytime for free on 116 123 or by emailing <a
                    href="mailto:jo@samaritans.org">jo@samaritans.org</a> </li>
            <li><strong>Shout Textline</strong> Text ‘SHOUT’ to 85258 24/7</li>
        </ul>
        </p>
        <br>
        <p class="text-center font-bold">
            For medical advice please always call 111 (non-urgent) or 999 if you or someone you are with is an immediate
            danger to themselves or others.
        </p>
        <br>
        <p>
            Below are links to resources for you to access in your own time. Trying to find the right support can be
            overwhelming, especially in times of difficulty. Please remember to reach out to someone you trust. If you
            aren’t sure who to speak to please contact me at <a href="mailto:welfare@bulsca.co.uk">welfare@bulsca.co.uk</a>
            for further guidance. Reaching out to someone is a difficult but often a great first step.
            <br>
            <br>

        </p>
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
        <h2>Help at My Uni</h2>
        <p>Each of your respective universities has its own well-being services; if you are struggling to find these, they
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
        <h2>Reporting</h2>
        <p>There are two ways in which you can raise a concern or report a welfare issue to me as the BULSCA Welfare
            Officer. <strong>The first is to email me</strong> at <a
                href="mailto:welfare@bulsca.co.uk">welfare@bulsca.co.uk</a>. This way is by nature not confidential but you
            can provide as many or as few details as you would like to. This will be followed up and dealt with
            confidentiality and in line with BULSCA policy and your wishes.
            <br><br>
            Alternatively, suppose you would simply like to draw the Welfare Officer’s attention to an issue or incident
            without providing any personal details. In that case, you can do so using the reporting form below. <a
                href="https://docs.google.com/forms/d/e/1FAIpQLScDnXdmT9k1Xfa95ufxWe0AYQi1rdAw6nPOE2MUiQpsizXheA/viewform">Welfare
                Reporting Form</a>
            <br><br>
            <i>The use of the welfare reporting form does not initiate disciplinary action. Instead provides the opportunity
                for further support and signposting.</i>
        </p>
        <br><br>
        <div class="flex items-center justify-center">
            <iframe
                src="https://docs.google.com/forms/d/e/1FAIpQLScDnXdmT9k1Xfa95ufxWe0AYQi1rdAw6nPOE2MUiQpsizXheA/viewform"
                class="md:w-[60%] w-[99%] h-[40rem]" frameborder="0"></iframe>
        </div>
    </div>
@endsection
