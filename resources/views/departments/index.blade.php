@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h4>Departments
                    <div class="float-end">
                        <a class="btn" style="background-color: #3b94f3;color: white;"  href="{{ route('departments.create') }}">Create Department</a>
                    </div>
                </h4>                   

            </div>
        </div>
    </div>
   
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th> <!-- New column for actions -->
            </tr>
        </thead>
        <tbody>
           @if ($departments->count() == 0)
                <tr>
                    <td colspan="5" class="text-center">No department created yet</td>
                </tr>
            @else
                @foreach ($departments as $department)
                    <tr>
                        <td>{{ $department->id }}</td>
                        <td>{{ $department->name }}</td>
                        <td>
                            <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-department-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtns = document.querySelectorAll('.delete-department-btn');

            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault();

                    const userId = this.dataset.userId;

                    Swal.fire({
                        title: 'Are you sure you want to delete this user?',
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

