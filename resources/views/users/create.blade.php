@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4 d-flex justify-content-between">
            <div class="pull-left">
                <h4>Create New User</h4>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}" style="background-color: #007bff; color: #fff; border-color: #007bff; padding: 8px 20px; border-radius: 40px; text-decoration: none;">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                position: "top-end",
                icon: 'error',
                title: 'Validation Error',
                html: "{!! implode('<br>', $errors->all()) !!}"
            });
        });
    </script>
    @endif
  @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                     position: "top-end",
                    icon: "success",
                    showConfirmButton: false,
                    text: "{{ session('success') }}"
                });

                setTimeout(function() {
                    window.location.href = "{{ route('users.index') }}";
                }, 2000); 
            });
        </script>
    @endif


     

    <form action="{{ route('users.store') }}" method="POST" id="create-user-form">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-controls" placeholder="Enter Name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-controls" placeholder="Enter Email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-controls" placeholder="Enter Password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password:</label>
                    <input type="password" name="confirm_password" class="form-controls" placeholder="Confirm Password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="department_id" class="form-label">Department</label>
                    <select name="department_id" class="form-controls">
                        <option value="" disabled>Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="role_id" class="form-label">Role</label>
                    <select class="form-controls" name="role_id">
                        <option value="" disabled>Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn w-100 create-user-btn" style="background-color: #3b94f3; color: white;">Submit</button>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
