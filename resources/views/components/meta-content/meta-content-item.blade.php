<!-- Meta content item component -->
<div class="meta-content-item p-4 border rounded-lg shadow-md">
    <h3 class="text-lg font-semibold mb-2">{{ $item->title }}</h3>
    <p class="text-sm text-gray-600 mb-4">{{ $item->created_at->format('F j, Y') }}</p>
    <div class="content">
        {!! $item->content !!}
    </div>
</div>
<!-- End of meta content item component -->