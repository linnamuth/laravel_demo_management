@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h2>Create New User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password:</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="department_id" class="form-label">Department:</label>
                    <select name="department_id" class="form-control">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="roles" class="form-label">Roles:</label>
                    <select class="form-control" multiple name="roles[]">
                        @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </form>

@endsection
