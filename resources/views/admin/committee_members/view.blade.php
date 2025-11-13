@extends('layouts.adminlayout')

@section('title')
{{ $committee_member->name }} | CommitteeRoles | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.committee_members') }}">Committee Members</a>
        <span>></span>
        <p>{{ $committee_member->name }}</p>

    </div>

    <h1 class="header">{{ $committee_member->name }} </h1>

    <div class=" group relative overflow-hidden rounded-md h-48 w-48 flex items-center justify-center">
        <div class="absolute top-0 left-0 w-full h-full hidden cursor-pointer bg-gray-100 bg-opacity-60 group-hover:flex items-center justify-center " onclick="openFileSelect()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <img src="{{ $committee_member->image_path ? route('image', $committee_member->image_path) : '/storage/logo/blogo.png' }}" class="" alt="" />



        <form method="POST" action="{{ route('committee_member.updatePhoto') }}" id="member-photo-form" class="hidden" enctype="multipart/form-data">
            @csrf
            <input type="file" name="image" id="member-photo-input" onchange="submitForm()">
            <input type="hidden" class="hidden" name="member" value="{{ $committee_member->id }}">
        </form>
        <script>
            const openFileSelect = () => {
                document.getElementById('member-photo-input').click()
            }
            const submitForm = () => {
                document.getElementById('member-photo-form').submit()
            }
        </script>

    </div>

    <hr class="my-8">


    <div>
        <h1 class="header">Committee Member Details</h1>
        <form action="@can('admin.committee_members.manage'){{ route('admin.committee_member.edit', $committee_member) }}@endcan" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf

            <x-form-input deny="{{ auth()->user()->cannot('admin.committee_members.manage') }}" id='label' title='Label' extraCss="md:col-span-2" defaultValue='{{ $committee_member->label }}' />

            @can('admin.committee_members.manage')
            <button type="submit" class="btn btn-thinner btn-save md:col-start-4">Save</button>
            @endcan
        </form>
    </div>

    <hr class="my-8">


    <div>
        <h2>Delete</h2>
        @can('admin.committee_members.delete')
        <p>This <strong>CANNOT</strong> be undone!</p>
        <form action="{{ route('admin.committee_members.delete') }}" onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="hidden" class="hidden" name="id" value="{{ $committee_member->id }}"></input>
            <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
        </form>
        @else
        <p>You aren't able to delete this $committee_member, please contact the Data Manager!</p>
        @endcan
    </div>

</div>


@endsection