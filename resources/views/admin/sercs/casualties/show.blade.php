@extends('layouts.adminlayout')

@section('title')
    {{ $casualty->name }} | Casualties | SERCs | Admin |
@endsection


@section('content')
    <div class="container-responsive">
        <div class="breadcrumbs">
            <a href="{{ route('admin') }}">Admin</a>
            <span>></span>
            <a href="{{ route('admin.sercs') }}">SERCs</a>
            <span>></span>
            <a href="{{ route('admin.sercs.casualties') }}">Casualties</a>
            <span>></span>
            <p>{{ $casualty->name }}</p>
        </div>

        <h1 class="header">{{ $casualty->name }}</h1>






        <div>
            <form action="@can('admin.sercs.manage'){{ route('admin.sercs.casualties.update', $casualty) }}@endcan"
                enctype="multipart/form-data" method="POST" class="grid grid-cols-4 gap-4">
                @csrf

                <x-form-input id='name' title='Name' defaultValue="{{ $casualty->name }}" />
                <x-form-input id='manual' required='false' title='Manual Reference'
                    defaultValue="{{ $casualty->manual_reference }}" />

                <x-form-select id="group" required="true" title="Group" :options="$groups"
                    defaultValue="{{ $casualty->group }}"></x-form-select>




                <div class="row-start-2 col-span-4" x-data="{
                    images: {{ $casualty->getImages->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'preview' => App\Services\ImageService::getUrl($image->path),
                            'state' => 'uploaded',
                        ];
                    }) }},
                
                    handleImages() {
                        const files = this.$refs.images.files;
                        for (let i = 0; i < files.length; i++) {
                
                            let id = Math.random().toString(36).substring(7)
                
                            this.images.push({
                                id: id,
                                file: files[i],
                                preview: URL.createObjectURL(files[i]),
                                state: 'uploading',
                            });
                
                            let image = this.images.find(image => image.id === id)
                
                
                            let fd = new FormData()
                            fd.append('image', image.file)
                
                
                            fetch('{{ route('admin.sercs.casualties.images.add', $casualty) }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: fd,
                            }).then(resp => resp.json()).then(data => {
                                if (data.success === false) {
                                    return
                                }
                
                                showNotification('Uploaded and image')
                
                                image.state = 'uploaded'
                                image.id = data.id
                                image.preview = data.url
                            })
                        }
                    },
                
                    deleteImage(image) {
                
                        let fd = new FormData()
                        fd.append('id', image.id)
                        fd.append('_method', 'DELETE')
                        fd.append('_token', '{{ csrf_token() }}')
                
                        fetch('{{ route('admin.sercs.casualties.images.delete', $casualty) }}', {
                            method: 'POST',
                            body: fd
                        }).then(resp => resp.json()).then(data => {
                            if (data.success === false) {
                                return
                            }
                
                            showNotification('Deleted image')
                
                
                            let index = this.images.indexOf(image)
                            this.images.splice(index, 1)
                        })
                    }
                
                
                
                
                }">
                    <label for="">Images</label>



                    <div class="p-2 border-2 rounded-md">
                        <div class="relative h-auto grid grid-cols-4 gap-2">


                            <template x-for="(image) in images">
                                <div
                                    class="col-span-1 flex items-center justify-center overflow-hidden rounded-md aspect-video relative group ">
                                    <img :src="image.preview" class="h-full" alt="">

                                    <div x-show="image.state==='uploading'"
                                        class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-40 flex items-center justify-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>

                                    </div>

                                    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center transition-opacity"
                                        x-show="image.state==='uploaded'">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 cursor-pointer"
                                            @click="deleteImage(image)">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>

                                    </div>
                                </div>

                            </template>

                            <div class="p-2 border-2 border-dashed rounded-md flex items-center justify-center hover:border-bulsca transition-colors hover:text-bulsca_red cursor-pointer"
                                @click="$refs.images.click()">
                                <input type="file" name="" x-ref="images" multiple hidden id=""
                                    @change="handleImages()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class=" h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                </svg>

                            </div>


                        </div>

                    </div>

                </div>




                <div class=" row-start-3 col-span-4">


                    <div>
                        <label for="description">Description</label>
                        <div class="main-container">
                            <div class="editor-container editor-container_classic-editor editor-container_include-style"
                                id="editor-container">
                                <div class="editor-container__editor prose">
                                    <textarea name="description" id="editor" style="display: none">{!! old('description') ?: $casualty->description !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>







                <button type="submit" class="btn btn-thinner btn-save col-start-4 row-start-5">Save</button>

            </form>
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

        <br>

        <div>
            <h3>Delete</h3>
            @can('admin.sercs.delete')
                <p>This <strong>CANNOT</strong> be undone!</p>
                <form action="{{ route('admin.sercs.casualties.delete', $casualty) }}"
                    onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="hidden" class="hidden" name="id" value="{{ $casualty->id }}"></input>
                    <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
                </form>
            @else
                <p>You aren't able to delete this competition, please contact the Data Manager!</p>
            @endcan
        </div>
    </div>
@endsection
