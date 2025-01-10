@extends('layouts.adminlayout')

@section('title')
    Add | Casualty Groups | SERCs | Admin |
@endsection


@section('content')
    <div class="container-responsive">
        <div class="breadcrumbs">
            <a href="{{ route('admin') }}">Admin</a>
            <span>></span>
            <a href="{{ route('admin.sercs') }}">SERCs</a>
            <span>></span>
            <a href="{{ route('admin.sercs.casualties.groups') }}">Casualty Groups</a>
            <span>></span>
            <p>Add</p>
        </div>

        <h1 class="header">Add Casualty Group</h1>






        <div>
            <form action="@can('admin.sercs.manage'){{ route('admin.sercs.casualties.groups.store') }}@endcan"
                enctype="multipart/form-data" method="POST" class="grid grid-cols-4 gap-4">
                @csrf

                <x-form-input id='name' title='Name' />








                <div class=" row-start-2 col-span-3">
                    <div class="form-input col-span-2 ">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows=6 class="input"></textarea>


                    </div>
                </div>






                <button type="submit" class="btn btn-thinner btn-save col-start-4 row-start-5">Add</button>

            </form>
        </div>

    </div>
@endsection
