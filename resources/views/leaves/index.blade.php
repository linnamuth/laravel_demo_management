@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h4>Leave Requests
                    <div class="float-end">
                        @php
                            $isAdmin = Auth::user()->isAdmin();
                            $isManagerOrAbove =
                                Auth::user()->isHRManager() ||
                                Auth::user()->isTeamLeader() ||
                                Auth::user()->isCEO() ||
                                Auth::user()->isCFO();
                        @endphp
                        @if (!$isManagerOrAbove)
                            <a class="btn" style="background-color: #3b94f3;color:white"
                                href="{{ route('leave-request.create') }}"> Request Leave</a>
                        @endif
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
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    @if (!$isAdmin)
                        <th>Action</th>
                    @endif

                </tr>
            </thead>
            <tbody>
                @foreach ($leaveRequests as $leaveRequest)
                    <tr>
                        <td>{{ ucfirst($leaveRequest->type) }}</td>
                        <td>{{ $leaveRequest->user->name }}</td>
                        <td>{{ $leaveRequest->start_date }}</td>
                        <td>{{ $leaveRequest->end_date }}</td>
                        <td>{{ $leaveRequest->reason }}</td>
                        <td>
                            @php
                                $approvalStatus = [
                                    'hr manager' => $leaveRequest->hr_manager_approval,
                                    'team leader' => $leaveRequest->team_leader_approval,
                                    'cfo' => $leaveRequest->cfo_approval,
                                    'Admin' => $leaveRequest->status,
                                ];
                            @endphp
                            @if (Auth::check() && Auth::user()->role && Auth::user()->role->name === 'Admin')
                                @if ($approvalStatus['hr manager'] && $approvalStatus['team leader'])
                                    @if (Auth::user()->department &&
                                            (Auth::user()->department->name === 'IT department' || Auth::user()->department->name === 'sale department'))
                                        @if (!isset($approvalStatus['cfo']) || $approvalStatus['cfo'] !== 'approved')
                                            <span style="color: orange;">Pending</span>
                                        @elseif ($approvalStatus['hr manager'] === 'approved' && $approvalStatus['team leader'] === 'approved')
                                            <span style="color: green;">Approved</span>
                                        @else
                                            <span style="color: orange;">Pending</span>
                                        @endif
                                    @else
                                        @if ($approvalStatus['hr manager'] === 'approved' && $approvalStatus['team leader'] === 'approved')
                                            <span style="color: green;">Approved</span>
                                        @else
                                            <span style="color: orange;">Pending</span>
                                        @endif
                                    @endif
                                @else
                                    <span style="color: orange;">Pending</span>
                                @endif
                            @elseif (Auth::user()->department->name === 'IT department')
                                @if (Auth::user()->role->name === 'hr manager')
                                    @if ($approvalStatus['hr manager'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif ($approvalStatus['hr manager'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @elseif(Auth::user()->role->name === 'team leader')
                                    @if ($approvalStatus['team leader'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif ($approvalStatus['team leader'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @else
                                    @if ($approvalStatus['hr manager'] === 'approved' && $approvalStatus['team leader'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif($approvalStatus['hr manager'] === 'rejected' && $approvalStatus['team leader'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @endif
                            @elseif (Auth::user()->department->name === 'sale department')
                                @if (Auth::user()->role->name === 'hr manager')
                                    @if ($approvalStatus['hr manager'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif ($approvalStatus['hr manager'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @elseif(Auth::user()->role->name === 'team leader')
                                    @if ($approvalStatus['team leader'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif ($approvalStatus['team leader'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @elseif(Auth::user()->role->name === 'cfo')
                                    @if ($approvalStatus['cfo'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif ($approvalStatus['cfo'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @else
                                    @if (
                                        $approvalStatus['hr manager'] === 'approved' &&
                                            $approvalStatus['team leader'] === 'approved' &&
                                            $approvalStatus['cfo'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif(
                                        $approvalStatus['hr manager'] === 'rejected' &&
                                            $approvalStatus['team leader'] === 'rejected' &&
                                            $approvalStatus['cfo'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($isManagerOrAbove)
                                @if ($approvalStatus[Auth::user()->role->name] === 'pending')
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
