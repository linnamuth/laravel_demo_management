@extends('layouts.master')

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>Edit Workflow</h2>
                    </div>

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

                        <form action="{{ route('workflows.update', $workflow->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="department_id">Department</label>
                                <select name="department_id" class="form-control">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $workflow->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="request_type">Request Type</label>
                                <select name="request_type" class="form-control">
                                    <option value="leave" {{ $workflow->request_type == 'leave' ? 'selected' : '' }}>Leave</option>
                                    <option value="mission" {{ $workflow->request_type == 'mission' ? 'selected' : '' }}>Mission</option>
                                </select>

                            </div>


                            <div class="form-group mb-3">
                                <label>Approval Role</label>
                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="role_{{ $role->id }}"
                                            name="role_ids[]" value="{{ $role->id }}"
                                            @if (in_array($role->id, $workflowRoleIds)) checked @endif>
                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <label for="description">Description (optional)</label>
                            <input type="text" class="form-control mt-2" id="description" name="description"
                                value="{{ $workflow->description }}" placeholder="Enter a description">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100 mt-2">Submit</button>
                            </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
