@extends('layout')

@section('title')
Latest |
@endsection

@section('meta')
The latest publications from BULSCA all in one place.
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
        <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
            <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
            <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                <h2 class="md:text-6xl text-4xl font-bold text-white">Latest</h2>
                <p class="text-white">News 📰</p>
            </div>
        </div>

    </div>


</div>
<x-alert-banner />

<div class="container-responsive">

    @hasanyrole('admin|super_admin|committee')
    <div class="flex flex-col ">
        <a href="{{ route('article.create') }}" class=" ml-auto btn btn-thinner">Add Article</a>
    </div>
    @endhasanyrole

    <div class="flex flex-col pb-8">
        @foreach ($pinned as $article)
        <a href="{{ route('article.view', $article->getSlug()) }}" class="no-underline py-8 first-of-type:pt-0 border-b group">
            <article class="flex flex-col">
                <div class="flex flex-row items-center">

                    <div class="w-full">
                        <h1 class="header ">{{ $article->title }}</h1>
                        <div class="flex flex-row">
                            <small class="text-gray-500 font-normal">{{ $article->getDateAuthorString() }}</small>
                            <small class="text-gray-500 font-normal ml-auto flex flex-row items-center justify-center space-x-2 mb-1">

                                @can('article')
                                <span>{{ $article->thumbs_up - $article->thumbs_down > 0 ? '+' : '' }}{{ $article->thumbs_up - $article->thumbs_down }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 ">
                                    <path d="M15.5 2A1.5 1.5 0 0014 3.5v13a1.5 1.5 0 001.5 1.5h1a1.5 1.5 0 001.5-1.5v-13A1.5 1.5 0 0016.5 2h-1zM9.5 6A1.5 1.5 0 008 7.5v9A1.5 1.5 0 009.5 18h1a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0010.5 6h-1zM3.5 10A1.5 1.5 0 002 11.5v5A1.5 1.5 0 003.5 18h1A1.5 1.5 0 006 16.5v-5A1.5 1.5 0 004.5 10h-1z" />
                                </svg>

                                @endcan
                                <span class="pl-2">{{ $article->getViews() }}</span>

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </small>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 ml-auto text-bulsca_red transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>


                <p class=" text-black font-normal">
                    {{ Str::of(html_entity_decode(str_replace('  ', ' ', strip_tags(str_replace('<', ' <', $article->content)))))->squish()->words() }}
                </p>
                <small class="mt-2 ml-auto group-hover:text-bulsca_red">Click to continue reading</small>
            </article>

        </a>
        @endforeach
    </div>

    <div class="flex flex-col">
        @forelse ($articles as $article)
        <a href="{{ route('article.view', $article->getSlug()) }}" class="no-underline py-8 first-of-type:pt-0 border-b group">
            <article class="flex flex-col">
                <h1 class="header">{{ $article->title }}</h1>
                <div class="flex flex-row">
                    <small class="text-gray-500 font-normal">{{ $article->getDateAuthorString() }}</small>
                    <small class="text-gray-500 font-normal ml-auto flex flex-row items-center justify-center space-x-2 mb-1">

                        @can('article')
                        <span>{{ $article->thumbs_up - $article->thumbs_down > 0 ? '+' : '' }}{{ $article->thumbs_up - $article->thumbs_down }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 ">
                            <path d="M15.5 2A1.5 1.5 0 0014 3.5v13a1.5 1.5 0 001.5 1.5h1a1.5 1.5 0 001.5-1.5v-13A1.5 1.5 0 0016.5 2h-1zM9.5 6A1.5 1.5 0 008 7.5v9A1.5 1.5 0 009.5 18h1a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0010.5 6h-1zM3.5 10A1.5 1.5 0 002 11.5v5A1.5 1.5 0 003.5 18h1A1.5 1.5 0 006 16.5v-5A1.5 1.5 0 004.5 10h-1z" />
                        </svg>

                        @endcan
                        <span class="pl-2">{{ $article->getViews() }}</span>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </small>
                </div>
                <p class=" text-black font-normal">
                    {{ Str::of(html_entity_decode(str_replace('  ', ' ', strip_tags(str_replace('<', ' <', $article->content)))))->squish()->words() }}


                </p>
                <small class="mt-2 ml-auto group-hover:text-bulsca_red">Click to continue reading</small>
            </article>

        </a>
        @empty

        @empty($pinned)
        <p>There aren't any articles right now. Please check back <strong>later!</strong></p>
        @endempty

        @endforelse
        <br>

        {{ $articles->links() }}
    </div>

</div>











@endsection