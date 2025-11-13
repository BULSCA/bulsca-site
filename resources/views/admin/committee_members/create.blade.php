@extends('layouts.adminlayout')

@section('title')
Create | Committee Members | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.committee_members') }}">Committee Members</a>
        <span>></span>
        <p>Create</p>

    </div>

    <h1 class="header">Create Committee Member</h1>

    <div>
        <form action="@can('admin.committee_members.create.post'){{ route('admin.committee_members.create', [$committee->id, $role->id]) }}@endcan" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-select id="affiliated_uni_id" required="false" title="Affiliation" :options=" $unis "></x-form-select>
            <x-form-input id='name' title='Name' extraCss="col-span-2" />

            <button type="submit" class="btn btn-thinner btn-save col-start-4">Create</button>

        </form>
    </div>

</div>


@endsection