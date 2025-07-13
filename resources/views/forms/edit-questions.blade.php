@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Questions to: {{ $form->title }}</h1>

    @if($form->questions->count())
    <h2>Existing Questions</h2>
    <ul>
        @foreach($form->questions as $question)
        <li>
            {{ $question->question_text }} 
            ({{ $question->question_type }})
            {{ $question->is_required ? '(Required)' : '' }}
        </li>


        
    </ul>
</div>
@endsection


    