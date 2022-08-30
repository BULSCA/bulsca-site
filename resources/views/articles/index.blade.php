@extends('layout')

@section('title')
Latest |
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

                    <div>
                        <h1 class="header ">{{ $article->title }}</h1>
                        <small class="text-gray-500 font-normal -mt-1 ">{{ $article->getDateAuthorString() }}</small>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 ml-auto text-bulsca_red transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>


                <p class=" text-black font-normal">
                    {{ Str::of(html_entity_decode(strip_tags($article->content)))->squish()->words() }}
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
                <small class="text-gray-500 font-normal mb-2 -mt-1">{{ $article->getDateAuthorString() }}</small>
                <p class=" text-black font-normal">
                    {{ Str::of(html_entity_decode(strip_tags($article->content)))->squish()->words() }}
                </p>
                <small class="mt-2 ml-auto group-hover:text-bulsca_red">Click to continue reading</small>
            </article>

        </a>
        @empty
        <p>There aren't any articles right now. Please check back <strong>later!</strong></p>
        @endforelse
        <br>

        {{ $articles->links() }}
    </div>

</div>











@endsection