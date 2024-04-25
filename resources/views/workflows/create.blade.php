@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3 class="mt-2 ms-4">Create Workflow</h3>

                <div class="card-body">
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
                                window.location.href = "{{ route('workflows.index') }}";
                            }, 2000);
                        });
                    </script>
                    @endif


                    <form method="POST" action="{{ route('workflows.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="department_id">Departments</label>
                            <select class="form-control mt-2" id="department_id" name="department_id" data-placeholder="Select Departments">
                                <option value="">select department</option>

                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="request_type">Request Type</label>
                            <select class="form-control mt-2" id="request_type" name="request_type">
                                <option value="leave">select request</option>

                                <option value="leave">Leave</option>
                                <option value="mission">Mission</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="role_id">Roles</label>
                            @foreach ($roles as $role) <!-- Assuming $roles is a list of available roles -->
                                <div class="form-check"> <!-- Each role gets its own checkbox -->
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="role_{{ $role->id }}"
                                        name="role_ids[]"
                                        value="{{ $role->id }}"
                                    >
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="description">Description (optional)</label>
                            <input type="text" class="form-control mt-2" id="description" name="description"
                                   placeholder="Enter a description" >
                        </div>




                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100 mt-2">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select Departments", // Optional: Placeholder for Select2
        allowClear: true // Optional: Allow clearing of selection
    });
});
</script>

@endsection
