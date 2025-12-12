@props(['itemLink' => ''])

<blockquote 
    class="instagram-media" 
    data-instgrm-permalink="{{ $itemLink }}"
    data-instgrm-version="14" 
    style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin:1px; max-width:540px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
    <div style="padding:16px;">
        <a href="{{ $itemLink }}" target="_blank"></a>
    </div>
</blockquote>
<script async src="//www.instagram.com/embed.js"></script>