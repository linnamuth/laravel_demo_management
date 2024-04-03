@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left d-flex justify-content-between">
                <h4>Create New Role
                </h4>
                <div class="pull-right">
                     <a class="btn btn-primary" href="{{ route('roles.index') }}" style="background-color: #007bff; color: #fff; border-color: #007bff; padding: 8px 20px; border-radius: 40px; text-decoration: none;">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
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
                    window.location.href = "{{ route('roles.index') }}";
                }, 2000); 
            });
        </script>
    @endif

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" class="form-controls" placeholder="Name">
                </div>
            </div>
            <div class="col-md-12 text-center mt-3">
                <button type="submit" class="btn w-100 create-user-btn" style="background-color: #3b94f3; color: white;">Submit</button>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
