@extends('layouts.adminlayout')

@section('title')
{{ $user->name }} | Users | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.users') }}">Users</a>
        <span>></span>
        <p>{{ $user->name }}</p>


    </div>

    <h1 class="header">{{ $user->name }}</h1>

    <x-badge>University: @if ($user->getHomeUni()){{ $user->getHomeUni()->name }} @else None @endif</x-badge>
    @if ($user->getHomeUni() && $user->getHomeUni()->isUserAdmin($user))
    <x-badge style="success">University Admin</x-badge>
    @endif
    <x-badge style="warning">{{ $user->email }}</x-badge>


    <br><br>
    <hr>
    <br>
    <h3>Edit</h3>

    <form action="{{ route('admin.users.edit') }}" method="POST" class="flex flex-col">
        @csrf
        <input type="hidden" class="hidden" name="user_id" value="{{ $user->id }}">
        <div class="grid grid-cols-3 gap-4">
            <x-form-input id="user_name" defaultValue="{{ $user->name }}" title="Name"></x-form-input>
            <x-form-input id="user_email" defaultValue="{{ $user->email }}" title=" Email"></x-form-input>
            <x-form-select id="user_university" defaultValue="{{ $user->getHomeUni()->id }}" title=" University" :options=" $unis "></x-form-select>

        </div>

        <br>
        <hr>
        <br>

        <div class="flex items-center">
            <label for="user_university_admin" class="mr-4">
                Uni Admin?
            </label>
            <input type="checkbox" {{$user->getHomeUni() && $user->getHomeUni()->isUserAdmin($user) ? 'checked' : ''}} name="user_university_admin" id="user_university_admin">
        </div>
        <br>



        <h4>Roles</h4>
        <p>Not currently editable!</p>
        <div class="grid grid-cols-3 gap-4 hidden">

            @foreach ($roles as $role)
            <div class="flex items-center">
                <label for="role-{{$role->id}}" class="mr-4">
                    <x-badge style="{{in_array($role->name, $user->getRoleNames()->toArray()) ? 'success' : 'info' }}">{{Str::headline(Str::replace('_', ' ', $role->name))}}</x-badge>
                </label>
                <input type="checkbox" @if(in_array($role->name, $user->getRoleNames()->toArray())) checked @endif name="role-{{$role->id}}" id="role-{{$role->id}}">
            </div>

            @endforeach
        </div>

        <br>
        <button class="btn btn-thinner ml-auto">Update</button>
    </form>











</div>



@endsection