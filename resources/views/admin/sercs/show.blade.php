@extends('layouts.adminlayout')

@section('title')
Add | SERC | Admin |
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

         
           


            <x-form-input id='when' title='When' type="date" defaultValue="{{ $serc->when }}"  />
            <x-form-input id='where' title='Where' defaultValue="{{ $serc->where }}" />

            <div class=" row-start-2 col-span-3">
                <div class="form-input col-span-2 ">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows=6  class="input" value="" >{{ $serc->description }}</textarea>
              
    
                </div>
            </div>

            <div class="row-start-3">
                <div class="flex flex-col">
                    <label for="tags">Tags</label>
                    <div data-tag-input="tags" data-tag-default-value="one,two,three" class="tag-input">
                    
                        <div class="tags">
                            
                        </div>
                        <div contenteditable="true" class="fake-input"></div>
                        <input hidden data-tag-container id="tags" name="tags" type="text">

                        <div class="suggested">
                            <span>one</span>
                            <span>two</span>
                            <span>three</span>
                        </div>
                        
                    </div>
                    <small class="ml-auto">Click a tag to remove it</small>
                </div>
            </div>



            







            <button type="submit" class="btn btn-thinner btn-save col-start-4 row-start-3">Save</button>

        </form>
    </div>

</div>

<script>
     document.querySelectorAll('[data-tag-input]').forEach((tagInput) => {
        const hiddenInput = tagInput.querySelector('input')
        const input = tagInput.querySelector('div[contenteditable].fake-input')
        const tags = tagInput.querySelector('div.tags')
        const suggestedList = tagInput.querySelector('.suggested')

        tagInput.onclick = () => {
            input.focus()
        }

        function addTag(name) {
            const tag = document.createElement('span')
            tag.textContent = name.trim()
            tags.appendChild(tag)

            hiddenInput.value = Array.from(tags.children).map(tag => tag.textContent).join(',')

            suggestedList.style.display = 'none'

            tag.onclick = () => {
                tag.remove()

                hiddenInput.value = Array.from(tags.children).map(tag => tag.textContent).filter(tag => tag !== name).join(',')
            }

        }

        var targetedSuggestion = null;

        input.onkeydown = (e) => {
            if (e.key === 'Enter') {
                e.preventDefault()

                if (targetedSuggestion) {
                    addTag(targetedSuggestion.textContent)
                    targetedSuggestion.remove()
                    input.textContent = ''
                    return
                }

                if (input.textContent.trim() === '') {
                    return
                }


                input.textContent.split(',').forEach((tag) => {
                    addTag(tag)
                })

                input.textContent = ''
            }   

            if (e.key === 'ArrowDown') {
                if (targetedSuggestion) {
                    targetedSuggestion.style.backgroundColor = 'white'
                    targetedSuggestion = targetedSuggestion.nextElementSibling
                } else {
                    targetedSuggestion = suggestedList.firstElementChild
                }

                if (targetedSuggestion) {
                    targetedSuggestion.style.backgroundColor = 'lightgray'
                }
            }

            if (e.key === 'ArrowUp') {
                if (targetedSuggestion) {
                    targetedSuggestion.style.backgroundColor = 'white'
                    targetedSuggestion = targetedSuggestion.previousElementSibling
                } else {
                    targetedSuggestion = suggestedList.lastElementChild
                }

                if (targetedSuggestion) {
                    targetedSuggestion.style.backgroundColor = 'lightgray'
                }
            }
            
        }

        input.onkeyup = (e) => {
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp' || e.key === 'Enter' || e.key === 'Escape') {
                return
            }

            let similar = searchSimilar(input.textContent)

            suggestedList.innerHTML = ''
            similar.forEach((tag) => {
        
                    const suggested = document.createElement('span')
                    suggested.textContent = tag
                    suggested.onclick = () => {
                        addTag(tag)
                        suggested.remove()
                        input.textContent = ''
                    }
                    suggestedList.appendChild(suggested)
                
            })

            if (similar.length) {
                suggestedList.style.display = 'flex'
            } else {
                suggestedList.style.display = 'none'
            }

               
        }

        tagInput.getAttribute('data-tag-default-value').split(',').forEach((tag) => {
            addTag(tag)
        })


        function searchSimilar(name) {

            let suggested = ['one', 'two', 'three']

            return suggested.filter((tag) => tag.includes(name))

        }


    });
</script>


@endsection