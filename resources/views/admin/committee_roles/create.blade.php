@extends('layouts.adminlayout')

@section('title')
Create | Committee Roles | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.committee_roles') }}">Committee Roles</a>
        <span>></span>
        <p>Create</p>

    </div>

    <h1 class="header">Create Committee Role</h1>






    <div>
        <form action="@can('admin.committee_roles.create.post'){{ route('admin.committee_roles.create') }}@endcan" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input id='label' title='Label' extraCss="col-span-2" />
            <input type="hidden" name="active" value="1">

            <button type="submit" class="btn btn-thinner btn-save col-start-4">Create</button>

        </form>
    </div>

</div>


@endsection