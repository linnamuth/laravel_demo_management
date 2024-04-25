@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb mb-4 d-flex justify-content-between">
        <div class="pull-left">
            <h4>Update User</h4>
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
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" value="{{ $user->name }}" name="name" class="form-control"
                        placeholder="Name">
                </div>
            </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                        placeholder="Email">
                </div>
            </div>
              <div class="col-md-6">
                <div class="form-group mt-2">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm-password" class="form-control mt-2"
                        placeholder="Confirm Password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <label>Department</label>
                    <select name="department_id[]" id="department_ids" class="form-control select2 mt-2" multiple="multiple" required>
                        @foreach($departments as $department)
                            <option
                                value="{{ $department->id }}"
                                {{ $user->departments->contains($department->id) ? 'selected' : '' }}
                            >
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
            <div class="mb-3">
                <label for="role_id" >Role</label>
                <select class="form-control " name="role_id">
                    <option value="" disabled>Select role</option>

                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @if(optional($user->roles->first())->id == $role->id) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


             <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary w-100 create-user-btn">Submit</button>
            </div>
        </div>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />


 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

 <script>
 $(document).ready(function() {
     $('#department_ids').select2({
         placeholder: 'Select Departments',
         allowClear: true
     });
 });
 </script>

@endsection
