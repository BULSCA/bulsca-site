<div class="file-link" title='{{ $file["name"] }}'>
            <a href='{{ route("view-resource", $file["id"]) }}' target='_blank' >
                <div>
                    <h3>{{ $file['name'] }}</h3>
                    <small>Click to download</small>
                </div>

                <div >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                </div>
            </a>
        </div>