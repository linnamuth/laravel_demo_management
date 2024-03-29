@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h4>Role Management
                    <div class="float-end">
                            <a class="btn" style="background-color:#64adfb " href="{{ route('roles.create') }}"> Create New Role</a>
                    </div>
                </h4>
            </div>
        </div>
    </div>

    {{-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif --}}

    <table class="table table-striped table-hover">
        <tr>
            <th>Name</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($roles as $key => $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger delete-role-btn" data-role-id="{{ $role->id }}">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtns = document.querySelectorAll('.delete-role-btn');
    
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default form submission
    
                    const roleId = this.dataset.roleId; // Corrected variable name
    
                    Swal.fire({
                        title: 'Are you sure you want to delete this role?',
                        text: "This action can't be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = this.closest('form');
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
