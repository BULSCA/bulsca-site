@extends('layout')

@section('title')
    {{ $article->title }} (Edit) | Articles |
@endsection

@section('content')
<x-page-banner
    title="Edit"
    :snowContainer="true"
/>

<div class="container-responsive flex flex-col space-y-4">
    <form method="POST" action="{{ route('article.edit.post', $article->getSlug()) }}" class="flex flex-col">
        @csrf
        <div class="form-input">
            <label for="article-title">Title</label>
            <input class="input header " value="{{ $article->title }}" required id="article-title"
                name="title"></input>
        </div>
        <hr class="mt-3 mb-7">
        <div>
            <p class="font-semibold mb-2">Tags</p>
            <select name="tags[]" id="article-tags" class="w-full border rounded p-2" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @if ($article->tags->contains($tag)) selected @endif>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-gray-500">Hold Ctrl (Cmd on Mac) to select multiple tags</small>
        </div>
        <hr class="mt-3 mb-7">
        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const element = document.getElementById('article-tags');
                const choices = new Choices(element, {
                    removeItemButton: true,
                    searchEnabled: true,
                    placeholderValue: 'Select tags...',
                });
            });
        </script>
        @endpush
        <div>
            <div class="main-container">
                <div class="editor-container editor-container_classic-editor editor-container_include-style"
                    id="editor-container">
                    <div class="editor-container__editor">
                        <textarea name="content" id="editor">{{ $article->content }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <script type="importmap">
        {
          "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.1/"
          }
        }
        </script>
        <script type="module" src="{{ asset('js/ck.js') }}"></script>
        </article>
        <hr class="my-6" />
        <div class="ml-auto flex flex-col space-y-4">
            <div class="space-x-3 flex  items-center justify-center">
                <label for="article-pinned">Pinned</label>
                <input type="checkbox" @if ($article->pinned) checked @endif name="pinned"
                    id="article-pinned" />
            </div>
            <button submit class="btn btn-thinner btn-save">Update</button>
        </div>
    </form>
    <hr class="my-6">
    <form action="{{ route('article.delete', $article->id) }}" class="flex" onsubmit="return confirm('Are you sure?')"
        method="POST">
        @csrf
        {{ method_field('DELETE') }}
        <button submit class="btn btn-thinner btn-danger ml-auto">
            Delete
        </button>
    </form>
</div>
<!-- <script src="/storage/ckeditor.js"></script>
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
        console.error(
            'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
            );
        console.warn('Build id: 6ejwh9b4xfpx-l949vrtw2lll');
        console.error(error);
    }
</script> -->
@endsection
