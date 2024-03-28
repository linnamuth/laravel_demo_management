<!-- resources/views/mission_request/index.blade.php -->

@extends('layouts.master')

@section('content')
       <div class="container">
        <h1>Workflows</h1>
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('workflows.create') }}" class="btn btn-primary mb-3">Create Workflow</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workflows as $workflow)
                            <tr>
                                <td>{{ $workflow->id }}</td>
                                <td>{{ $workflow->name }}</td>
                                <td>{{ $workflow->description }}</td>
                                <td>{{ $workflow->department->name }}</td>
                                <td>
                                    <a href="{{ route('workflows.edit', $workflow->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('workflows.destroy', $workflow->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this workflow?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
