

@extends('layouts.master')

@section('content')
<div class="container">
    <div class="container">
        <h1>Edit Department</h1>
        <form method="POST" action="{{ route('departments.update', $department->id) }}">
            @csrf
            @method('PUT') <!-- Add this method override for PUT requests -->
    
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $department->name }}">
            </div>
            <!-- Add more form fields as needed -->
    
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
