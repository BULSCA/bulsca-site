@extends('layouts.adminlayout')

@section('title')
    heros | Admin |
@endsection


@section('content')
    <div class="container-responsive">
        <div class="breadcrumbs">
            <a href="{{ route('admin') }}">Admin</a>
            <span>></span>
            <p>heros</p>


        </div>

        <div class="flex items-center  mb-2">
            <h1 class="header">heros</h1>
            @can('admin.heroes.manage')
                <a href="{{ route('admin.hero.create') }}" class="ml-auto btn btn-thinner">Add hero</a>
            @endcan
        </div>

        <div class="grid-2 gap-4">
            @foreach ($heroes as $hero)
                <a href="{{ route('admin.hero.edit', $hero) }}"
                    class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
                    <div class="flex items-center justify-center">
                        <h3 class="header header-bold hmb-0">
                            {{ $hero->name }}
                        </h3>
                        <small class="ml-auto  text-black font-normal "></small>

                    </div>



                </a>
            @endforeach
        </div>

        {{ $heroes->links() }}

        <br>




    </div>
@endsection
