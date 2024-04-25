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



    <div class="card p-6">
        <h3 class="text-center mb-4">Create New User</h3>

        <form action="{{ route('users.store') }}" method="POST" id="create-user-form">
            @csrf
            <div class="row g-3">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="department_id" class="form-label">Departments</label>
                        <select name="department_id[]" id="department_ids" class="form-control select2" multiple="multiple" required>
                            <option value="" disabled>Select Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role_id" class="form-label">Role</label>
                        <select class="form-control" name="role_id" required>
                            <option value="" disabled>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12 ">
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 on the department multi-select field
    $('#department_ids').select2({
        placeholder: 'Select Departments',
        allowClear: true
    });
});
</script>

@endsection
