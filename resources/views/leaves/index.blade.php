@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h4>Leave Requests</h4>
                @php
                    $user = auth()->user();
                    $roleNames = $user && $user->roles ? $user->roles->pluck('name') : collect(); // Ensure roles is not null
                @endphp

                <div class="float-end">
                    @if ($roleNames->contains('user') || $roleNames->contains('Admin'))
                        <a class="btn" style="background-color: #3b94f3; color:white"
                            href="{{ route('leave-request.create') }}">Request Leave</a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif --}}
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
                    window.location.href = "{{ route('leaves.index') }}";
                }, 2000);
            });
        </script>
    @endif

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($leaveRequests->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">There are currently no leave requests</td>
                    </tr>
                @else
                    @foreach ($leaveRequests as $leaveRequest)
                        <tr>
                            <td>{{ ucfirst($leaveRequest->type) }}</td>
                            <td>{{ $leaveRequest->user->name }}</td>
                            <td>{{ $leaveRequest->start_date }}</td>
                            <td>{{ $leaveRequest->end_date }}</td>
                            <td>{{ $leaveRequest->reason }}</td>
                            <td>
                                @if ($leaveRequest->is_approved)
                                    <span class="text-success">Approved</span>
                                @elseif ($leaveRequest->status == 'rejected')
                                    <span class="text-danger">Rejected</span>
                                @else
                                    <span class="text-warning">Pending</span>
                                @endif
                            </td>

                            <td>
                                @if (!$leaveRequest->is_approved && $leaveRequest->status != 'rejected')
                                    <form action="{{ route('leave-requests.approve', $leaveRequest->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>

                                    <form action="{{ route('leave-requests.reject', $leaveRequest->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
