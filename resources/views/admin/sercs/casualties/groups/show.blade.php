@extends('layouts.adminlayout')

@section('title')
    {{ $group->name }} | Casualty Groups | SERCs | Admin |
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
            <p>{{ $group->name }}</p>
        </div>

        <h1 class="header">{{ $group->name }}</h1>






        <div>
            <form action="@can('admin.sercs.manage'){{ route('admin.sercs.casualties.groups.update', $group) }}@endcan"
                enctype="multipart/form-data" method="POST" class="grid grid-cols-4 gap-4">
                @csrf

                <x-form-input id='name' title='Name' defaultValue="{{ $group->name }}" />








                <div class=" row-start-2 col-span-3">
                    <div class="form-input col-span-2 ">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows=6 class="input">{{ $group->description }}</textarea>


                    </div>
                </div>






                <button type="submit" class="btn btn-thinner btn-save col-start-4 row-start-5">Save</button>

            </form>
        </div>


        <br>

        <div>
            <h3>Delete</h3>
            @can('admin.sercs.delete')
                <p>This <strong>CANNOT</strong> be undone!</p>
                <form action="{{ route('admin.sercs.casualties.groups.delete', $group) }}"
                    onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="hidden" class="hidden" name="id" value="{{ $group->id }}"></input>
                    <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
                </form>
            @else
                <p>You aren't able to delete this competition, please contact the Data Manager!</p>
            @endcan
        </div>

    </div>
@endsection
