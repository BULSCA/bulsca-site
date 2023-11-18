@extends('layout')

@section('title')
    Records |
@endsection

@section('meta')
    BULSCA Records
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
                <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h2 class="md:text-6xl text-4xl font-bold text-white">Records</h2>
                    <p class="text-white"></p>
                </div>
            </div>

        </div>


    </div>

    <div class="container-responsive">
        <h1 class="header header-large">
            Men's Individual
        </h1>
        <div class="table-wrapper relative">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th scope="col">Event</th>
                        <th scope="col">Person</th>
                        <th scope="col">Time</th>
                        <th scope="col">University</th>
                        <th scope="col">Competition</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Individual Line Throw (12.5m)</td>
                        <td>A.Ridsdale</td>
                        <td>0:10:92</td>
                        <td>University of Bristol</td>
                        <td>BULSCA Championships</td>
                        <td>March 2019</td>
                    </tr>
                    <tr>
                        <td> 200m Obstacles </td>
                        <td> J.Blaby </td>
                        <td> 2:03:52 </td>
                        <td> Loughborough Students </td>
                        <td> Europeans </td>
                        <td> September 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 50m Manikin Carry </td>
                        <td> J.Blaby </td>
                        <td> 0:29:97 </td>
                        <td> Loughborough Students </td>
                        <td> Crawley Open </td>
                        <td> November 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 100m Manikin Carry With Fins </td>
                        <td> S.Kirkland </td>
                        <td> 0:48:98 </td>
                        <td> Loughborough Students </td>
                        <td> National Speeds </td>
                        <td> March 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 100m Manikin Tow (with fins and rescue tube) </td>
                        <td> S.Lawman </td>
                        <td> 0:54:77 </td>
                        <td> Leeds City C </td>
                        <td> BULSCA Championships </td>
                        <td> March 2022
                        </td>
                    </tr>
                    <tr>
                        <td> 100m Rescue Medley </td>
                        <td> J.Blaby </td>
                        <td> 1:02:52 </td>
                        <td> Loughborough Students </td>
                        <td> Crawley Open </td>
                        <td> November 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 200m Superlifesaver </td>
                        <td> J.Blaby </td>
                        <td> 2:14:15 </td>
                        <td> Loughborough Students </td>
                        <td> Commonwealth </td>
                        <td> November 2019
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="container-responsive">
        <h1 class="header header-large">
            Women's Individual
        </h1>
        <div class="table-wrapper relative">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th scope="col">Event</th>
                        <th scope="col">Person</th>
                        <th scope="col">Time</th>
                        <th scope="col">University</th>
                        <th scope="col">Competition</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> Individual Line Throw (12.5m) </td>
                        <td> K.Stephens </td>
                        <td> 0:15:53 </td>
                        <td> University of Plymouth </td>
                        <td> BULSCA Championships </td>
                        <td> February 2020
                        </td>
                    </tr>
                    <tr>
                        <td> 200m Obstacles </td>
                        <td> S.Cummins </td>
                        <td> 2:22:06 </td>
                        <td> Loughborough Students </td>
                        <td> BULSCA Championships </td>
                        <td> March 2022
                        </td>
                    </tr>
                    <tr>
                        <td> 50m Manikin Carry </td>
                        <td> E.Henderson </td>
                        <td> 0:36:77 </td>
                        <td> University of Ulster </td>
                        <td> BULSCA Championships </td>
                        <td> March 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 100m Manikin Carry With Fins </td>
                        <td> E.Henderson </td>
                        <td> 0:58:45 </td>
                        <td> University of Ulster </td>
                        <td> BULSCA Championships </td>
                        <td> March 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 100m Manikin Tow (with fins and rescue tube) </td>
                        <td> R.Carrol </td>
                        <td> 1:03:78 </td>
                        <td> University of Leeds </td>
                        <td> BULSCA Championships </td>
                        <td> March 2017
                        </td>
                    </tr>
                    <tr>
                        <td> 100m Rescue Medley </td>
                        <td> L.Donovan </td>
                        <td> 1:20:07 </td>
                        <td> Loughborough Students </td>
                        <td> BULSCA Championships </td>
                        <td> February 2020
                        </td>
                    </tr>
                    <tr>
                        <td> 200m Superlifesaver </td>
                        <td> E.Henderson </td>
                        <td> 2:35:14 </td>
                        <td> University of Ulster </td>
                        <td> BULSCA Championships </td>
                        <td> March 2019
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="container-responsive">
        <h1 class="header header-large">
            Men's Relays
        </h1>
        <div class="table-wrapper relative">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th scope="col">Event</th>
                        <th scope="col">People</th>
                        <th scope="col">Time</th>
                        <th scope="col">University</th>
                        <th scope="col">Competition</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td> Line Throw Relay (10m) </td>
                        <td> J.W, V.H, C.W, R.L </td>
                        <td> 1:02:19 </td>
                        <td> Bristol University </td>
                        <td> BULSCA Championships </td>
                        <td> March 2018
                        </td>
                    </tr>
                    <tr>
                        <td> 4x25m Manikin Relay </td>
                        <td> A.Morley, S.Kirkland, J.Blaby, S.Lawman </td>
                        <td> 1:10:90 </td>
                        <td> Loughborough Students </td>
                        <td> RLSS UK Speeds </td>
                        <td> March 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 4x50m Obstacle Relay </td>
                        <td> S. Lawman, S. Kirkland, J. Blaby, A. Morley </td>
                        <td> 1:43:39 </td>
                        <td> Loughborough Students </td>
                        <td> RLSS UK Speeds </td>
                        <td> March 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 4x50m Medley Relay </td>
                        <td> J. Vick, S. Kirkland, J. Blaby, S. Lawman </td>
                        <td> 1:35:33 </td>
                        <td> Loughborough Students </td>
                        <td> RLSS UK Speeds </td>
                        <td> March 2019
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="container-responsive">
        <h1 class="header header-large">
            Women's Relays
        </h1>
        <div class="table-wrapper relative">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th scope="col">Event</th>
                        <th scope="col">People</th>
                        <th scope="col">Time</th>
                        <th scope="col">University</th>
                        <th scope="col">Competition</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> Line Throw Relay (10m) </td>
                        <td> R. Field, L. Donovan, J. Bunn, I. Shepherd </td>
                        <td> 1:23.21 </td>
                        <td> Loughborough Students </td>
                        <td> BULSCA Championships </td>
                        <td> February 2020
                        </td>
                    </tr>
                    <tr>
                        <td> 4x25m Manikin Relay </td>
                        <td> S. Cummins, A. Young, E. Robson, N. Moss </td>
                        <td> 1:32:95 </td>
                        <td> Loughborough Students </td>
                        <td> BULSCA Championships </td>
                        <td> March 2022
                        </td>
                    </tr>
                    <tr>
                        <td> 4x50m Obstacle Relay </td>
                        <td> S. Cummins, A. Young, E. Wright, E. Robson </td>
                        <td> 2:01:79 </td>
                        <td> Loughborough Students </td>
                        <td> BULSCA Championships </td>
                        <td> March 2022
                        </td>
                    </tr>
                    <tr>
                        <td> 4x50m Medley Relay </td>
                        <td> H.R, A.Q, L.D, E.G </td>
                        <td> 1:37:41 </td>
                        <td> Loughborough Students </td>
                        <td> BULSCA Championships </td>
                        <td> March 2016
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

    <div class="container-responsive">
        <h1 class="header header-large">
            Mixed Relays
        </h1>
        <div class="table-wrapper relative">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th scope="col">Event</th>
                        <th scope="col">People</th>
                        <th scope="col">Time</th>
                        <th scope="col">University</th>
                        <th scope="col">Competition</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> 4x50m Lifesaver Relay </td>
                        <td> S. Lawman, A. Young, J. Blaby, L. Scammell </td>
                        <td> 1:59:14 </td>
                        <td> Loughborough Students </td>
                        <td> RLSS UK Speeds </td>
                        <td> March 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 4x12m Line Throw </td>
                        <td> Bristol A </td>
                        <td> 1:27:05 </td>
                        <td> University of Bristol </td>
                        <td> Sheffield Comp </td>
                        <td> November 2019
                        </td>
                    </tr>
                    <tr>
                        <td> 4x100m Swim &amp; Tow Relay </td>
                        <td> Loughborough A </td>
                        <td> 6:04:44 </td>
                        <td> Loughborough Students </td>
                        <td> BULSCA Championships </td>
                        <td> March 2019
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

    <div class="container-responsive">
        <h1 class="header header-large">
            BULSCA Competition Records
        </h1>
        <div class="table-wrapper relative">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th scope="col">Event</th>
                        <th scope="col">People</th>
                        <th scope="col">Time</th>
                        <th scope="col">University</th>
                        <th scope="col">Competition</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> 4x100m Swim &amp; Tow Relay </td>
                        <td> - </td>
                        <td> 6:17.030 </td>
                        <td> - </td>
                        <td> - </td>
                        <td> -
                        </td>
                    </tr>
                    <tr>
                        <td> 4x12m Line Throw </td>
                        <td> - </td>
                        <td> 1:12.400 </td>
                        <td> - </td>
                        <td> - </td>
                        <td> -
                        </td>
                    </tr>
                    <tr>
                        <td> 4x50m Medley </td>
                        <td> Loughborough A </td>
                        <td> 1:48.590 </td>
                        <td> University of Loughborough </td>
                        <td> Birmingham Comp </td>
                        <td> December 2022
                        </td>
                    </tr>
                    <tr>
                        <td> 4x50m Obstacle </td>
                        <td> - </td>
                        <td> 1:57:230 </td>
                        <td> - </td>
                        <td> - </td>
                        <td> -
                        </td>
                    </tr>
                    <tr>
                        <td> 4x25m Manikin </td>
                        <td> Loughborough A </td>
                        <td> 1:23:130 </td>
                        <td> University of Loughborough </td>
                        <td> Nottingham Freshers Comp </td>
                        <td> November 2023
                        </td>
                    </tr>



                </tbody>
            </table>
        </div>

    </div>
@endsection
