@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb mb-4">
        <div class="pull-left">
            <h4>Users Management
               <div class="float-end">
                            <a class="btn" style="background-color: #3b94f3; color: white;" href="{{ route('users.create') }}">Create New User</a>

                            <a class="btn" style="background-color: #3b94f3; color: white;" href="{{ route('leave-mission.status') }}">Leave Status</a>
                            <a class="btn" style="background-color: #3b94f3; color: white;" href="{{ route('mission-leave.status') }}">Mission Status</a>

                </div>
            </h4>
        </div>
    </div>
</div>
<div class="card">

    @if ($message = Session::get('success'))
        <div class="alert alert-success my-2">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Department</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v)
                            <label class="badge badge-secondary text-dark">{{ $v }}</label>
                        @endforeach
                    @endif
                </td>
                <td>
                    @if($user->departments && $user->departments->isNotEmpty())
                        @foreach($user->departments as $department)
                            {{ $department->name }}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
                    
                    @endif
                </td>

                <td>
                    <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
                    @csrf
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-user-btn"
                                data-user-id="{{ $user->id }}">Delete</button>
                        </form>
                </td>
            </tr>
        @endforeach
    </table>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtns = document.querySelectorAll('.delete-user-btn');

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
</div>
@endsection
