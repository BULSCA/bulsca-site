<div class="file-link" title='{{ $file["name"] }}'>
    <a href='{{ $file["link"] }}' target='_blank' @can('admin.resources.manage') oncontextmenu="if (event.shiftKey) {event.preventDefault(); location.href = '{{ route('admin.resources.edit', basename($file['link'])) }}'}" @endcan>
        <div>
            <h3>{{ $file['name'] }}</h3>
            <small>Click to download</small>
        </div>

        <div>
            @if (array_key_exists('type', $file))
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
            </svg>

            @else
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            @endif

        </div>
    </a>
</div>