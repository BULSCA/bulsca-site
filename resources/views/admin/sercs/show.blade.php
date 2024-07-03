@extends('layouts.adminlayout')

@section('title')
{{ $serc->name }} | SERC | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.sercs') }}">SERCs</a>
        <span>></span>
        <p>{{ $serc->name }}</p>

    </div>

    <h1 class="header">{{ $serc->name }}</h1>






    <div>
        <form action="@can('admin.sercs.manage'){{ route('admin.sercs.update', $serc) }}@endcan" enctype="multipart/form-data" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input id='name' title='Name' defaultValue="{{ $serc->name }}" />

         
           


            <x-form-input id='when' title='When' type="date" defaultValue="{{ $serc->when->format('Y-m-d') }}"  />
            <x-form-input id='where' title='Where' defaultValue="{{ $serc->where }}" dlist="where-dl" />

                <datalist id="where-dl">
                    @foreach (DB::table('sercs')->select('where')->distinct()->get() as $where)
                        <option value="{{ $where->where }}"></option>
                    @endforeach
                </datalist>
                
    
            <x-form-input id='author' title='Author(s)' required="false" :defaultValue="$serc->author" />
            <x-form-input id='no_cas' title='# Casualties' type="number" min="0"   defaultValue="{{ $serc->casualties }}" />

            <div class=" row-start-2 col-span-3">
                <div class="form-input col-span-2 ">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows=6  class="input" value="" >{{ $serc->description }}</textarea>
              
    
                </div>
            </div>

            <div class="row-start-3 col-span-1">
                <div class="form-input">
                    <label for="upload-file">Add Files</label>
                    <input id="upload-file" class="input file" name="files[]" type="file" multiple="true">
                    <small id="file-name-list"></small>
                </div>
            </div>
            <div class="row-start-3 col-span-3">
               
                <div class=" col-span-3 flex  flex-wrap  ">
                    <script>
                        function deleteResource(id) {
                            if (confirm('Are you sure you want to remove this resource? It cannot be undone!')) {
                                
                                let fd = new FormData();
                                fd.append('id', id);
                 


                                fetch('{{ route("admin.sercs.resource.delete", $serc) }}', {
                                    method: 'POST',
                                    headers: {
                                     
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: fd,
                                }).then(response => {
                                    if (response.ok) {
                                        document.getElementById('delete-resource-' + id).remove();
                                        showNotification('Resource removed');
                                    }
                                });


                            }
                        }
                    </script>
                    @foreach ($serc->getResources as $resource)
                    <div  id="delete-resource-{{ $resource->id }}" method="{{ route('admin.sercs.resource.delete', $serc) }}" class=" "  >
                        <div class="flex mb-2 mr-2 ">
                           
                                <x-resource-download :file=$resource ></x-resource-download>
                            
                            <input type="hidden" name="resource" value="{{ $resource->id }}">

                     

                            <div class="flex items-center justify-center p-2 pl-3 rounded-r-md bg-red-500 -ml-1 text-white hover:bg-red-700 cursor-pointer"  onclick="deleteResource('{{ $resource->id }}')" >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                  </svg>
                                  
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            <div class="row-start-4 col-span-2">
                <x-tag-input value="{{ $serc->getTags() }}"></x-tag-input>
            </div>

       



            







            <button type="submit" class="btn btn-thinner btn-save col-start-4 row-start-5">Save</button>

        </form>
    </div>

    <br>

    <div>
        <h3>Delete</h3>
        @can('admin.sercs.delete')
        <p>This <strong>CANNOT</strong> be undone!</p>
        <form action="{{ route('admin.sercs.delete', $serc) }}" onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="hidden" class="hidden" name="id" value="{{ $serc->id }}"></input>
            <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
        </form>
        @else
        <p>You aren't able to delete this competition, please contact the Data Manager!</p>
        @endcan
    </div>

    

</div>



<script src="{{ asset('js/TagInput.js') }}"></script>


@endsection