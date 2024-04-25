<!-- resources/views/mission_request/index.blade.php -->

@extends('layouts.master')

@section('content')
        <div class="col-lg-12  d-flex justify-content-between">
            <h3>Workflows</h3>
            <div class="pull-right">

                <a href="{{ route('workflows.create') }}" class="btn btn-primary mb-3">Create Workflow
                </a>
            </div>
        </div>
    <div class="card">
        <div class="row">
            <div class="col-md-12">

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Departments</th>
                        <th>Request Type</th>
                        <th>Approval Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workflows as $workflow)
                        <tr>
                            <td>{{ $workflow->id }}</td>
                            <td>
                                {{ $workflow->department->name ?? 'No Department' }} <!-- Display the department name -->
                            </td>

                            <td>{{ $workflow->request_type }}</td>
                            <td>
                                @foreach ($workflow->roles as $index => $role)
                                    {{ $role->name }}
                                    @if ($index < count($workflow->roles) - 1)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                    <a href="{{ route('workflows.edit', $workflow->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('workflows.destroy', $workflow->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE') <!-- Correct HTTP method -->
                                        <button type="button" class="btn btn-danger delete-workflow-btn" data-id="{{ $workflow->id }}">Delete</button>
                                    </form>

                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener for delete button
        document.querySelectorAll('.delete-workflow-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const workflowId = this.getAttribute('data-id');

                // SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure to delected?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form
                        this.closest('form').submit();
                    }
                });
            });
        });
    });
</script>


@endsection
