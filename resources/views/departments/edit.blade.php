

@extends('layouts.master')

@section('content')
<div class="container">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h4>Edit Department</h4>
            <a class="btn btn-primary" href="{{ route('departments.index') }}" style="background-color: #007bff; color: #fff; border-color: #007bff; padding: 8px 20px; border-radius: 40px; text-decoration: none;">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        
        <form method="POST" action="{{ route('departments.update', $department->id) }}">
            @csrf
            @method('PUT') <!-- Add this method override for PUT requests -->
    
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-controls mt-2" id="name" name="name" value="{{ $department->name }}">
            </div>
            <!-- Add more form fields as needed -->
    
            <div class="col-md-12 text-center">
                    <button type="submit" class="btn w-100 create-user-btn mt-3" style="background-color: #3b94f3; color: white;">Submit</button>
            </div>   
        </form>
    </div>
</div>
@endsection
