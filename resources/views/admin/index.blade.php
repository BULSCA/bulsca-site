@extends('layouts.adminlayout')

@section('title')
Admin |
@endsection


@section('content')
<style>
    .ck-editor__editable_inline {
        min-height: 50px !important;
    }
</style>
<div class="container-responsive">
    <div class="grid md:grid-cols-5 grid-cols-1 gap-6">

        @if($currentSeason)
        @can('admin.seasons')
        <a href="{{ route('admin.season.view', $currentSeason->id) }}" class="rounded-md no-underline border-2 col-span-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-blue-600 ">
            <div class="flex flex-col ">
                <small class="text-base">Current Season</small>
                <p class=" text-4xl font-bold ">{{ $currentSeason->name }}</p>
                <small class="text-base">{{ $currentSeason->competitions->count() }} Competitions</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>
        @endcan
        @else
        <a href="{{ route('admin.seasons.create') }}" class="rounded-md no-underline border-2 col-span-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-blue-600 ">
            <div class="flex flex-col ">
                <small class="text-base">No Seasons </small>
                <p class=" text-4xl font-bold ">Create Season</p>
                <small class="text-base">Click to create</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>
        @endif

        @can('admin.competitions')
        <a href="{{ route('admin.competitions') }}" class="rounded-md no-underline border-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-purple-600 ">
            <div class="flex flex-col ">
                <p class=" text-4xl font-bold ">{{ $count['competition'] }}</p>
                <small class="text-base">Competitions</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>
        @endcan

        @can('admin.universities')
        <a href="{{ route('admin.universities') }}" class="rounded-md no-underline border-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-cyan-400 ">
            <div class="flex flex-col ">
                <p class=" text-4xl font-bold ">{{ $count['uni'] }}</p>
                <small class="text-base">Universities</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>
        </a>
        @endcan

        @can('admin.users')
        <a href="{{ route('admin.users') }}" class="rounded-md no-underline border-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-orange-500 ">
            <div class="flex flex-col ">
                <p class=" text-4xl font-bold ">{{ $count['user'] }}</p>
                <small class="text-base">Users</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>
        @endcan

    </div>

    <br>
    <hr>
    <br>
    @if($currentSeason)
    <h1 class="header">Current Season <a href="{{ route('admin.seasons') }}" class="text-base text-gray-400 hover:text-gray-700">(Previous Seasons)</a></h1>

    <div class="flex flex-row items-center  ">
        @foreach ($currentSeason->competitions()->orderBy('when')->get() as $comp)
        <div class="flex-1 flex flex-col items-center justify-center">

            <div class="mb-4">
                <a href="{{ route('admin.competition.view', $comp) }}" class="text-xl font-normal no-underline text-black hover:font-semibold hover:underline">{{ $comp->hostUni->name }}</a>
            </div>

            <div class="relative border-t border-gray-300 w-full ">
                <div class="absolute flex w-full bottom-full top-full group items-center justify-center">
                    <span class="competition-status {{ $comp->status->toCSSStatus() }}"></span>

                    <div class="absolute  w-full hidden group-hover:flex items-center justify-center">
                        <div class="bg-white rounded-md p-2 border-2">
                            <p class="text-xs">{{ $comp->status->toStatusMessage() }}</p>
                        </div>
                    </div>
                </div>



            </div>

            <div class="mt-4">
                <p class="text-sm">{{ $comp->when->format('d/m/Y') }}</p>
            </div>





        </div>
        @endforeach

    </div>
    <br>


    <a href="{{ route('admin.season.view', $currentSeason->id) }}">View more about this season</a>
    @endif

    <br>
    <br>

    @can('admin.resources')
    <a href="{{ route('admin.resources') }}">View Resources</a>
    @endcan

    <br>
    <br>
    <hr>
    <br>
    <div>
        <h3>Global Banner</h3>
        <p>Enter nothing to remove the banner</p>
        <form action="{{ route('globalnotifs.banner') }}" method="POST" class="flex flex-col">
            @csrf
            <textarea hidden name="content" id="editor" class="md:col-span-3" rows="2" class="max-h-4 h-4">{{ App\Models\GlobalNotification::getBanner()?->content }}</textarea>

            <button type="submit" class="ml-auto btn btn-thinner btn-save mt-4">Save</button>
        </form>
        <br>
        <h4>Preview:</h4>
        <x-alert-banner />

    </div>


</div>

<script src="/storage/ckeditor.js"></script>

<script>
    const watchdog = new CKSource.EditorWatchdog();

    window.watchdog = watchdog;

    watchdog.setCreator((element, config) => {

        return CKSource.Editor
            .create(element, config)
            .then(editor => {

                editor.config.height = 10;


                return editor;
            })
    });

    watchdog.setDestructor(editor => {



        return editor.destroy();
    });

    watchdog.on('error', handleError);

    watchdog
        .create(document.querySelector('#editor'), {

            licenseKey: '',
            removePlugins: ['Heading', 'CKBox', 'ImageToolbar', 'Indent', 'List', 'MediaEmbed', 'Table', 'TextTransformation', 'BlockQuote', 'Alignment', 'HorizontalLine', 'HTMLEmbed', 'GeneralHTMLSupport']


        })
        .catch(handleError);

    function handleError(error) {
        console.error('Oops, something went wrong!');
        console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
        console.warn('Build id: 6ejwh9b4xfpx-l949vrtw2lll');
        console.error(error);
    }
</script>



@endsection