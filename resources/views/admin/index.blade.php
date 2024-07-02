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
        <a href="{{ route('admin.season.view', $currentSeason->id) }}" class="rounded-md no-underline border-2  hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-blue-600 ">
            <div class="flex flex-col ">
                
                <p class=" text-4xl font-bold ">{{ $currentSeason->name }}</p>
                <small class="text-base">{{ $currentSeason->competitions->count() }} Competitions</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"  class="h-12 w-12 ml-auto" >
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
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
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"  class="h-12 w-12 ml-auto" >
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
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

        @can('admin.sercs')
        <a href="{{ route('admin.sercs') }}" class="rounded-md no-underline border-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-lime-500 ">
            <div class="flex flex-col ">
                <p class=" text-4xl font-bold ">{{ $count['serc'] }}</p>
                <small class="text-base">SERCs</small>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-12 w-12 ml-auto">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.712 4.33a9.027 9.027 0 0 1 1.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 0 0-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 0 1 0 9.424m-4.138-5.976a3.736 3.736 0 0 0-.88-1.388 3.737 3.737 0 0 0-1.388-.88m2.268 2.268a3.765 3.765 0 0 1 0 2.528m-2.268-4.796a3.765 3.765 0 0 0-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 0 1-1.388.88m2.268-2.268 4.138 3.448m0 0a9.027 9.027 0 0 1-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0-3.448-4.138m3.448 4.138a9.014 9.014 0 0 1-9.424 0m5.976-4.138a3.765 3.765 0 0 1-2.528 0m0 0a3.736 3.736 0 0 1-1.388-.88 3.737 3.737 0 0 1-.88-1.388m2.268 2.268L7.288 19.67m0 0a9.024 9.024 0 0 1-1.652-1.306 9.027 9.027 0 0 1-1.306-1.652m0 0 4.138-3.448M4.33 16.712a9.014 9.014 0 0 1 0-9.424m4.138 5.976a3.765 3.765 0 0 1 0-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 0 1 1.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.288 4.33m0 0a9.024 9.024 0 0 0-1.652 1.306A9.025 9.025 0 0 0 4.33 7.288" />
              </svg>
              
    
        </a>
        @endcan

    </div>

    <br>
    <hr>
    <br>
    @if($currentSeason)
    <h1 class="header"><a class=" no-underline hover:underline" href="{{ route('admin.season.view', $currentSeason->id) }}">Current Season</a> <a href="{{ route('admin.seasons') }}" class="text-base text-gray-400 hover:text-gray-700">(Previous Seasons)</a></h1>

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