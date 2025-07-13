@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Form</h1>
    <form action="{{ route('forms.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Form Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description (Optional)</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Form</button>
    </form>
</div>
@endsection
