@extends('layouts.dashlayout')

@section('title')
(Signups) {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }} | Signups Dashboard |
@endsection

@section('nav-extra')
nav-scrolled
@endsection

@section('content')

    <div class="container-responsive">
        <div class="flex items-center ">
            <div class="flex flex-col">
                <h2 style='margin-bottom: -.25em !important'><a
                        href="{{ route('prev_season', $comp->currentSeason->getDateSlug()) }}"
                        class="no-underline hover:underline" style="font-size: 0.5em !important">Competitions</a></h2>
                <h2 style='margin-bottom: -.15em !important'><span
                        class="text-bulsca_red font-bold">{{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}</span>
                </h2>
                <small class="">
                    {{ $comp->when->format('d/m/Y @ h:m A') }}
                </small>
            </div>
            @if ($comp->hostUni->currentUserIsClubAdmin())
                <a href="{{ route('lc-manage', $comp->id) }}" class="btn btn-thinner ml-auto">Manage</a>
            @endif
        </div>

        <div class="mt-1 mb-2">
            <small>Entries close on
                {{ date('d/m/Y @ h:i A', strtotime($info->getTimetableTime('timetable_entry_close'))) }}</small>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Signup Date</th>
                    <th>Additional Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($signups as $signup)
                <tr>
                    <td>{{ $signup->user->name }}</td>
                    <td>{{ $signup->user->email }}</td>
                    <td>{{ $signup->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @foreach($signup->signup_data as $key => $value)
                            {{ ucfirst($key) }}: {{ $value }}<br>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </div>

@endsection