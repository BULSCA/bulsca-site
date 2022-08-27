@extends('layouts.adminlayout')

@section('title')
Users | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Users</p>


    </div>

    <div class="flex items-center  mb-2">
        <h1 class="header">Users</h1>
        @can('admin.users.manage')<a href="{{ route('admin.users.create') }}" class="ml-auto btn btn-thinner">Add User</a>@endcan
    </div>

    <div class="grid grid-cols-2 gap-4">
        @foreach ($users as $user)
        <a href="{{ route('admin.user', $user) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h3 class="header header-bold">
                    {{ $user->name }}
                </h3>
                <small class="ml-auto  text-black font-normal "></small>

            </div>
            <hr class="-mx-6 mb-4">
            <div>
                <x-badge>University: @if ($user->getHomeUni()){{ $user->getHomeUni()->name }} @else None @endif</x-badge>

            </div>

        </a>

        @endforeach
    </div>

    {{ $users->links() }}

    <br>




</div>



@endsection