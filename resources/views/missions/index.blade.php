@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h4>Missions
                    <div class="float-end">
                        {{-- @can('role-create') --}}
                        <a class="btn" style="background-color: #64adfb;"  href="{{ route('mission_requests.create') }}" class="btn btn-primary mb-3">Create Mission Request</a>
                        {{-- @endcan --}}
                    </div>
                </h4>
            </div>
        </div>
    </div>
    @if ($missionRequests->isEmpty())
        <p>There are currently no pending mission requests</p>
    @else
    <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    @if(Auth::user()->isAdmin())
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($missionRequests as $mission)
                    <tr>
                        <td>{{ $mission->id }}</td>
                        <td>{{$mission->user ? $mission->user->name : 'N/A' }}</td>
                        <td>{{ $mission->purpose }}</td>
                        <td style="color: {{ $mission->status === 'approved' ? 'green' : ($mission->status === 'rejected' ? 'red' : 'orange') }}">
                            {{ ucfirst($mission->status) }}
                        </td>
                        <td>
                            @if ($mission->status == 'pending' && Auth::user()->isAdmin())
                            <form action="{{ route('mission-requests.approve', $mission->id) }}" method="post" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            
                                <form action="{{ route('mission-requests.reject', $mission->id) }}" method="post" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                                
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection


