

@extends('layouts.master')

@section('content')
<div class="container">
    <h4>Create Department</h4>
    <form method="POST" action="{{ route('departments.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter department name">
        </div>
        <!-- Add more form fields as needed -->
        <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
    </form>
</div>
@endsection
