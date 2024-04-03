=
@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">

            <div class="pull-left">
                <h4>Missions
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
                                href="{{ route('mission_requests.create') }}" class="btn btn-primary mb-3">Mission Request</a>
                        @endif
                    </div>
                </h4>
            </div>
        </div>
    </div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Purpose</th>
                <th>Status</th>
                @if (!$isAdmin)
                    <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if ($missionRequests->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">There are currently no pending mission requests</td>
                </tr>
            @else
                @foreach ($missionRequests as $mission)
                    <tr>
                        <td>{{ $mission->id }}</td>
                        <td>{{ $mission->user ? $mission->user->name : 'N/A' }}</td>
                        <td>{{ $mission->purpose }}</td>
                        <td>
                            @php
                                $approvalStatus = [
                                    'team leader' => $mission->leader_approval,
                                    'ceo' => $mission->ceo_approval,
                                    'cfo' => $mission->cfo_approval,
                                    'hr manager' => $mission->hr_manager_approval,
                                    'Admin' => $mission->status,
                                ];
                            @endphp
                            @if (Auth::check() && Auth::user()->role && Auth::user()->role->name === 'Admin')
                                @if (isset($approvalStatus['team leader']) && isset($approvalStatus['ceo']))
                                    @if ($approvalStatus['team leader'] === 'approved' && $approvalStatus['ceo'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @else
                                    <span style="color: orange;">Pending</span>
                                @endif
                            @elseif (Auth::user()->department->name === 'IT department')
                                @if (Auth::user()->role->name === 'team leader')
                                    @if ($approvalStatus['team leader'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif ($approvalStatus['team leader'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @elseif(Auth::user()->role->name === 'ceo')
                                    @if ($approvalStatus['ceo'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif ($approvalStatus['ceo'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @else
                                    @if ($approvalStatus['team leader'] === 'approved' && $approvalStatus['ceo'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif($approvalStatus['team leader'] === 'rejected' && $approvalStatus['ceo'] === 'rejected')
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
                                @elseif(Auth::user()->role->name === 'ceo')
                                    @if ($approvalStatus['ceo'] === 'approved')
                                        <span style="color: green;">Approved</span>
                                    @elseif ($approvalStatus['ceo'] === 'rejected')
                                        <span style="color: red;">Rejected</span>
                                    @else
                                        <span style="color: orange;">Pending</span>
                                    @endif
                                @else
                                    @if (
                                        $approvalStatus['hr manager'] === 'approved' &&
                                            $approvalStatus['team leader'] === 'approved' &&
                                            $approvalStatus['cfo'] === 'approved' &&
                                            $approvalStatus['ceo'] === 'approved')
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
                                    <form action="{{ route('mission-leave.approve', $mission->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('mission-leaves.reject', $mission->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
