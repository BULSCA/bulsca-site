@extends('layouts.adminlayout')

@section('title')
    Casualties | SERCs | Admin |
@endsection


@section('content')
    <script src="{{ asset('js/TagInput.js') }}"></script>

    <div class="container-responsive">
        <div class="breadcrumbs">
            <a href="{{ route('admin') }}">Admin</a>
            <span>></span>
            <a href="{{ route('admin.sercs') }}">SERCs</a>
            <span>></span>
            <p>Casualty Groups</p>
        </div>


        <div class="flex items-center  mb-2">
            <h1 class="header">Casualty Groups</h1>
            @can('admin.sercs.manage')
                <div class="ml-auto">
                    <a href="{{ route('admin.sercs.casualties.groups.add') }}" class="ml-auto btn btn-thinner">Add</a>
                </div>
            @endcan
        </div>

        <form method="GET" action="" id="search-and-filter" class="w-full relative flex-col ">

            <div class="form-search group w-full mb-3 relative">

                <input type="text" id="resource-search" name="s" class="input " placeholder="Search..."
                    value="{{ request('s') }}" x-data x-init="() => {
                        $el.focus();
                        let v = $el.value;
                        $el.value = '';
                        $el.value = v
                    }">
            </div>





        </form>

        <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 3xl:grid-cols-4  gap-4">
            @foreach ($groups as $group)
                <a href="{{ route('admin.sercs.casualties.groups.show', $group) }}"
                    class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
                    <div class="flex  items-center justify-between">
                        <h4 class="header header-bold overflow-hidden break-words">
                            {{ $group->name }}
                        </h4>
                    </div>
                    <hr class="-mx-6 mb-4">


                    <div class="overflow-x-auto flex flex-row whitespace-nowrap">
                        <x-badge>{{ $group->getCasualties->count() }} Casualties</x-badge>
                    </div>


                </a>
            @endforeach
        </div>
        <br>

        {{ $groups->appends($_GET)->links() }}



    </div>
@endsection
