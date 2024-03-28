@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <div class="float-end">
                    @can('product-create')
                        <a class="btn btn-success" href="{{ route('leave-request.create') }}"> Request Leave</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <h1>Leave Requests</h1>

    @if ($leaveRequests->count() > 0)
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th> <!-- Add Action column header -->
                </tr>
            </thead>
            <tbody>
                @foreach ($leaveRequests as $leaveRequest)
                    <tr>
                        <td>{{ ucfirst($leaveRequest->type) }}</td>
                        <td>{{ $leaveRequest->start_date }}</td>
                        <td>{{ $leaveRequest->end_date }}</td>
                        <td>{{ $leaveRequest->reason }}</td>
                        <td style="color: {{ $leaveRequest->status === 'approved' ? 'green' : ($leaveRequest->status === 'rejected' ? 'red' : 'orange') }}">
                            {{ ucfirst($leaveRequest->status) }}
                        </td>
                                                <td>
                            @if ($leaveRequest->status == 'pending')
                                {{-- @can('approve-leave') --}}
                                    <form action="{{ route('leave-requests.approve', $leaveRequest->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                {{-- @endc/an --}}
                                {{-- @can('reject-leave') --}}
                                    <form action="{{ route('leave-requests.reject', $leaveRequest->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                {{-- @endcan --}}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No leave requests found.</p>
    @endif
@endsection
