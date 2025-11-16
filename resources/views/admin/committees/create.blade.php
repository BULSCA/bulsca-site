@extends('layouts.adminlayout')

@section('title')
Create | Committees | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.committees') }}">Committees</a>
        <span>></span>
        <p>Create</p>

    </div>

    <h1 class="header">Create Committee</h1>






    <div>
        <form action="@can('admin.committees.create.post'){{ route('admin.committees.create') }}@endcan" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input id='name' title='Name' extraCss="col-span-2" />
            <x-form-input id='start_date' type="datetime-local" title='Start date' />
            <x-form-input id='end_date' type="datetime-local" title='End date' />




            <button type="submit" class="btn btn-thinner btn-save col-start-4">Create</button>

        </form>
    </div>

</div>


@endsection