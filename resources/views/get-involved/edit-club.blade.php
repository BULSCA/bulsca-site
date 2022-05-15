@extends('layout')

@section('title')
    (Edit) {{ $club->name }} | Clubs | 
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
      <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center " >
        <img src="/storage/clubs/logos/{{ $club->id }}.png" class="w-[10%] " alt="">
        <div class="border-l-2 border-white ml-12 pl-12 py-8">
          <h2 class="text-6xl font-bold text-white">{{ $club->name }}</h2>
          <p class="text-white">You are editing this clubs page!</p>
       
        </div>
      </div>

    </div>

    
  </div>

  <div class="mx-2 md:mx-[20%] my-[2%]">
    <form action="" method="POST" class="flex flex-col">
        @csrf
        <div class="flex justify-between items-center">
            <a href="./"  class=" underline ">Back</a>
            <button class="ml-auto btn btn-thinner btn-save">Save</button>
            
        </div>
        <br>
        <textarea name="content" id="editor" class="h-[52vh]">{!! $club->getPage()->first()->content ?? '' !!}</textarea>
        <br>
        
    </form>
  </div>


    <script src="/storage/ckeditor.js"></script>
  <!-- <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script> -->
  <!-- <script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            extraPlugins: [ 'ImageResize' ]
        } )
        .catch( error => {
            console.error( error );
        } );
</script> -->
<script>
			const watchdog = new CKSource.EditorWatchdog();
			
			window.watchdog = watchdog;
			
			watchdog.setCreator( ( element, config ) => {
				return CKSource.Editor
					.create( element, config )
					.then( editor => {
						
						
						
			
						return editor;
					} )
			} );
			
			watchdog.setDestructor( editor => {
				
				
			
				return editor.destroy();
			} );
			
			watchdog.on( 'error', handleError );
			
			watchdog
				.create( document.querySelector( '#editor' ), {
					
					licenseKey: '',
					
					
					
				} )
				.catch( handleError );
			
			function handleError( error ) {
				console.error( 'Oops, something went wrong!' );
				console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
				console.warn( 'Build id: 6ejwh9b4xfpx-l949vrtw2lll' );
				console.error( error );
			}
			
		</script>
@endsection