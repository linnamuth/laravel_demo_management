@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb mb-4">
        <div class="pull-left">
            <h4>Leave Requests
                <div class="float-end">
                    <a class="btn" style="background-color: #64adfb;"  href="{{ route('leave-request.create') }}"> Request Leave</a>
                </div>
            </h4>
        </div>
    </div>
</div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($leaveRequests->count() > 0)
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    @if(Auth::user()->isAdmin())
                        <th>Action</th>
                    @endif
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
            @if ($leaveRequest->status == 'pending' && Auth::user()->isAdmin())
                <form action="{{ route('leave-requests.approve', $leaveRequest->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                </form>
                
                <form action="{{ route('leave-requests.reject', $leaveRequest->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                </form>
            @endif
        </td>
    </tr>
@endforeach

            </tbody>
        </table>
    @else
        <p>There are currently no pending leave requests</p>
    @endif
@endsection
