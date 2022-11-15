@extends('layouts.adminlayout')

@section('title')
Resources | Admin |
@endsection


@section('content')

<div class="container">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Resource Pages</p>


    </div>

    <div class="flex flex-row">
        <h1 class="header">Resource Pages</h1>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($resourcePages as $rp)
        <a href="{{ route('admin.resources.page.view', $rp) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h3 class="header header-bold" style="margin-bottom: 0 !important">
                    {{ $rp->name }}
                </h3>
                <small class="ml-auto  text-black font-normal ">{{ $rp->getSections->count() }} Section{{ $rp->getSections->count() > 1 ? "s" : "" }}</small>
            </div>

        </a>


        @endforeach
    </div>


    <div class="py-6">
        <h2 class="header header-smallish">Add New Page</h2>

        <form action="{{ route('admin.resources.page.create' ) }}" method="POST" class="flex flex-col" enctype="multipart/form-data">
            @csrf




            <div class="form-input">
                <label for="new-section">Page</label>
                <input id="new-section" class="input" name="name" required type="text">
            </div>
            <button class="ml-auto btn btn-thinner">Create</button>
        </form>
    </div>

</div>

<div class="container">
    <h1 class="header">All Resources</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($resources as $res)
        <x-resource-download :file="$res" />

        @endforeach
    </div>
    <br>
    {{ $resources->links() }}
</div>


@endsection