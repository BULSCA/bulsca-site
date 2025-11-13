@extends('layouts.adminlayout')

@section('title')
{{ $committee->name }} | Committees | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.committees') }}">Committees</a>
        <span>></span>
        <p>{{ $committee->name }}</p>

    </div>

    <h1 class="header">{{ $committee->name }} </h1>

    <hr class="my-8">


    <div>
        <h1 class="header">Committee Members</h1>

        <div class="grid grid-cols-3 gap-4">
            @foreach ($roles as $role)
                @if ($role->active || ($role->committees->contains($committee)))
                    @php
                        $member = $committee->members()->where('role_id', $role->id)->first();
                    @endphp

                    <div class="flex flex-col justify-between items-center rounded-md border hover:border-bulsca transition no-underline text-center overflow-hidden min-h-80">

                        @if ($member)
                            <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center mt-4 mx-4">
                                <img src="/storage/photos/committee/24-25/chair.jpg" class="w-full h-full " alt="">
                            </div>
                            <h3 class="header header-smallish px-4">
                                {{ $member->name }}
                            </h3>

                        @else
                            <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center mt-4 mx-4 border border-dashed hover:border-bulsca transition no-underline group">
                                <a href="{{ route('admin.committee_members.create', [$committee->id, $role->id]) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-full h-full text-gray-400  p-2 bg-white rounded-full group-hover:text-gray-600 transition-colors">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                                    </svg>
                                </a>
                            </div>
                            <h3 class="header header-smallish px-4">
                                unfilled
                            </h3>
                        @endif

                        <div class="bg-bulsca w-full font-semibold text-white p-2 rounded-b text-center">
                            {{ $role->label }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    </div>

    <hr class="my-8">


    <div>
        <h1 class="header">Committee Details</h1>
        <form action="@can('admin.committees.manage'){{ route('admin.committee.edit', $committee) }}@endcan" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf

            <x-form-input deny="{{ auth()->user()->cannot('admin.committees.manage') }}" id='name' title='Name' extraCss="md:col-span-2" defaultValue='{{ $committee->name }}' />
            <x-form-input deny="{{ auth()->user()->cannot('admin.committees.manage') }}" id='from' type="datetime-local" title='Start date' defaultValue='{{ $committee->start_date }}' />
            <x-form-input deny="{{ auth()->user()->cannot('admin.committees.manage') }}" id='to' type="datetime-local" title='End date' defaultValue='{{ $committee->end_date }}' />

            @can('admin.committees.manage')
            <button type="submit" class="btn btn-thinner btn-save md:col-start-4">Save</button>
            @endcan
        </form>
    </div>

    <hr class="my-8">


    <div>
        <h2>Delete</h2>
        @can('admin.committees.delete')
        <p>This <strong>CANNOT</strong> be undone!</p>
        <form action="{{ route('admin.committees.delete') }}" onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="hidden" class="hidden" name="id" value="{{ $committee->id }}"></input>
            <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
        </form>
        @else
        <p>You aren't able to delete this committee, please contact the Data Manager!</p>
        @endcan
    </div>

</div>


@endsection