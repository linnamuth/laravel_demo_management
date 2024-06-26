@extends('layouts.master')

@section('content')
<div class="container">
    <div class="justify-content-between d-flex">
        <h4>Leave Requests Status</h4>
            <a class="btn btn-primary" href="{{ route('users.index') }}" style="background-color: #007bff; color: #fff; border-color: #007bff; padding: 8px 20px; border-radius: 40px; text-decoration: none;">
                <i class="bi bi-arrow-left"></i> Back
            </a>
    </div>

   <table class="table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @if ($leaveRequests->isEmpty())
            <tr>
                <td colspan="5" class="text-center">No leave requests found.</td>
            </tr>
        @else
            @foreach ($leaveRequests as $leaveRequest)
                <tr>
                    <td>{{ ucfirst($leaveRequest->type) }}</td>
                    <td>{{ $leaveRequest->start_date }}</td>
                    <td>{{ $leaveRequest->end_date }}</td>
                    <td>{{ $leaveRequest->reason }}</td>
                    <td style="color: {{ $leaveRequest->status === 'approved' ? 'green' : ($leaveRequest->status === 'rejected' ? 'red' : 'orange') }}">
                        {{ ucfirst($leaveRequest->status) }}
                    </td>                        
                </tr>
            @endforeach
        @endif
    </tbody>
</table>


</div>
@endsection
