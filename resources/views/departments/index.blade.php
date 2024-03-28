@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Departments</h1>
    <div class="pull-right">
        <a class="btn btn-success" href="{{ route('departments.create') }}">Create Department</a>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th> <!-- New column for actions -->
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->id }}</td>
                    <td>{{ $department->name }}</td>
                    <td>
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-department-btn">Delete</button>
                        </form>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

