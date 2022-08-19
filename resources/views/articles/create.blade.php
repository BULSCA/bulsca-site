@extends('layout')

@section('title')
Create | Articles |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
        <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
            <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
            <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8 max-w-7xl">
                <h2 class="md:text-6xl text-4xl font-bold text-white text-center">Create</h2>

            </div>
        </div>

    </div>


</div>

<div class="container-responsive flex flex-col space-y-4">


    <form method="POST" action="{{ route('article.create.post') }}" class="flex flex-col">
        @csrf
        <div class="form-input">
            <label for="article-title">Title</label>
            <input class="input header " required id="article-title" name="title"></input>
        </div>

        <hr class="mt-3 mb-7">
        <textarea hidden name="content" id="editor" class="h-[52vh]"></textarea>

        </article>
        <hr class="my-6" />
        <div class="ml-auto flex flex-col space-y-4">
            <div class="space-x-3 flex  items-center justify-center">
                <label for="article-pinned">Pinned</label>
                <input type="checkbox" name="pinned" id="article-pinned" />
            </div>
            <button submit class="btn btn-thinner btn-save">Publish</button>
        </div>
    </form>



</div>



<script src="/storage/ckeditor.js"></script>

<script>
    const watchdog = new CKSource.EditorWatchdog();

    window.watchdog = watchdog;

    watchdog.setCreator((element, config) => {
        return CKSource.Editor
            .create(element, config)
            .then(editor => {




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