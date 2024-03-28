<!-- resources/views/mission_request/index.blade.php -->

@extends('layouts.master')

@section('content')
    <h1>Missions</h1>

    <a href="{{ route('mission_requests.create') }}" class="btn btn-primary mb-3">Create Mission Request</a>

    @if ($missionRequests->isEmpty())
        <p>No missions found.</p>
    @else
    <table class="table table-striped table-hover">
            <thead>
                <tr>
                    
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>

                   
                </tr>
                </tr>
            </thead>
            <tbody>
                @foreach ($missionRequests as $mission)
                    <tr>
                        <td>{{ $mission->id }}</td>
                        <td>{{ $mission->user->name }}</td>
                        <td>{{ $mission->purpose }}</td>
                        <td style="color: {{ $mission->status === 'approved' ? 'green' : ($mission->status === 'rejected' ? 'red' : 'orange') }}">
                            {{ ucfirst($mission->status) }}
                        </td>
                        
                        <td>
                            @if ($mission->status == 'pending')
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


