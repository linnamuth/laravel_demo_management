@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h2>Edit User
                    <div class="float-end">
                        <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                    </div>
                </h2>
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
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                  <div class="form-group">
                    <strong>Name</strong>
                    <input type="text" value="{{ $user->name }}" name="name" class="form-control"
                        placeholder="Name">
                </div>
            </div>
              <div class="col-md-6">
                <div class="form-group">
                    <strong>Email</strong>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                        placeholder="Email">
                </div>
            </div>
              <div class="col-md-6">
                <div class="form-group">
                    <strong>Password</strong>
                    <input type="password" name="password" class="form-control"
                        placeholder="Password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Confirm Password</strong>
                    <input type="password" name="confirm-password" class="form-control"
                        placeholder="Confirm Password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Department</strong>
                    <select name="department_id" class="form-control">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select class="form-control" name="role_id">
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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
@endsection
