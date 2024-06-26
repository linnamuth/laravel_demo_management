@extends('layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between">

        <h4>Mission Requests Status</h4>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}" style="background-color: #007bff; color: #fff; border-color: #007bff; padding: 8px 20px; border-radius: 40px; text-decoration: none;">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

   
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>User</th>
                        <th>Purpos</th>
                        <th>Purpose</th>
                        <th>Date</th>

                    </tr>
                </thead>
                <tbody>
                    @if ($missionRequests->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No mission requests found</td>
                        </tr>   
                    @else
                        @foreach ($missionRequests as $missionRequest)
                            <tr>
                                <td>{{ ucfirst($missionRequest->id) }}</td>
                                <td>{{$missionRequest->user ? $missionRequest->user->name : 'N/A' }}</td>
                                <td>{{ $missionRequest->purpose }}</td>
                                <td style="color: {{ $missionRequest->status === 'approved' ? 'green' : ($missionRequest->status === 'rejected' ? 'red' : 'orange') }}">
                                    {{ ucfirst($missionRequest->status) }}
                                </td>   
                                <td>{{ $missionRequest->created_at->format('d M Y') }}</td>

                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
        
    
</div>
@endsection
