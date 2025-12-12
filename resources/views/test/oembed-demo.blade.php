@extends('layout')

@section('title')
Social Media Embed Demo |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">
    <div class="h-full w-full overflow-hidden relative">
        <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
            <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
            <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                <h2 class="md:text-6xl text-4xl font-bold text-white">BULSCA Social Media Integration</h2>
                <p class="text-white">This page demonstrates how BULSCA embeds Facebook and Instagram content on our website to share updates with our university lifesaving community.</p>
            </div>
        </div>
    </div>
</div>


<div class="container-responsive py-8">

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Facebook Page Plugin -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="header mb-4">Facebook Page Feed</h2>
            <p class="mb-4">Our main BULSCA Facebook page embedded on our website:</p>
            
            <div class="flex justify-center">
                <iframe 
                    src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FBULSCA%2F&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" 
                    width="340" 
                    height="500" 
                    style="border:none;overflow:hidden" 
                    scrolling="no" 
                    frameborder="0" 
                    allowfullscreen="true" 
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                </iframe>
            </div>
        </div>

        <!-- Facebook Post Embed -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="header mb-4">Facebook Post</h2>
            <p class="mb-4">Example of an embedded BULSCA Facebook post:</p>
            
            <div class="flex justify-center">
                <iframe 
                    src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FBULSCA%2Fposts%2F&show_text=true&width=500" 
                    width="500" 
                    height="500" 
                    style="border:none;overflow:hidden" 
                    scrolling="no" 
                    frameborder="0" 
                    allowfullscreen="true" 
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                </iframe>
            </div>
        </div>

        <!-- Instagram Feed -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="header mb-4">Instagram Profile</h2>
            <p class="mb-4">Our BULSCA Instagram feed embedded on our website:</p>
            
            <div class="flex justify-center">
                <blockquote 
                    class="instagram-media" 
                    data-instgrm-permalink="https://www.instagram.com/bulsca/" 
                    data-instgrm-version="14"
                    style="max-width:540px; min-width:326px; width:100%;">
                </blockquote>
                <script async src="//www.instagram.com/embed.js"></script>
            </div>
        </div>

        <!-- Instagram Post -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="header mb-4">Instagram Post</h2>
            <p class="mb-4">Example of an embedded BULSCA Instagram post:</p>
            
            <div class="flex justify-center">
                <blockquote 
                    class="instagram-media" 
                    data-instgrm-captioned 
                    data-instgrm-permalink="https://www.instagram.com/p/LATEST_POST_ID/" 
                    data-instgrm-version="14"
                    style="max-width:540px; min-width:326px; width:100%;">
                </blockquote>
                <script async src="//www.instagram.com/embed.js"></script>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-gray-100 p-6 rounded-lg">
        <h3 class="header">Use Case</h3>
        <p>
            BULSCA uses oEmbed to display social media content from our official Facebook and Instagram accounts 
            throughout our website. This helps us:
        </p>
        <ul class="list-disc list-inside mt-4">
            <li>Share competition updates and results with university clubs</li>
            <li>Promote upcoming events and championships</li>
            <li>Showcase club activities and community engagement</li>
            <li>Provide real-time updates to our members</li>
        </ul>
    </div>
</div>
@endsection