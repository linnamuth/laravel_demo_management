@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Leave and Mission Requests Status</h1>

    @if ($leaveMissions->isEmpty())
        <p>No leave or mission requests found.</p>
    @else
        <div class="table-container">
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
                    @foreach ($leaveMissions as $leaveMission)
                        <tr>
                            <td>{{ ucfirst($leaveMission->type) }}</td>
                            <td>{{ $leaveMission->start_date }}</td>
                            <td>{{ $leaveMission->end_date }}</td>
                            <td>{{ $leaveMission->reason }}</td>
                            <td>{{ $leaveMission->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
