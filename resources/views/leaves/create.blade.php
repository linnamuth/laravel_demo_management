@extends('layouts.master')

@section('content')
<div class="container p-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Leave Request</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('leave-request.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="type">Type:</label>
                            <select name="type" id="type" class="form-control">
                                <option value="leave">Annual Leave</option>
                                <option value="mission">Sick Leave</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="duration">Duration:</label>
                            <input type="text" name="duration" id="duration" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="duration_input">choose:</label>

                            <select name="days" id="duration_select" class="form-control">
                                <option value="morning">Morning</option>
                                <option value="afternoon">Afternoon</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="reason">Reason:</label>
                            <textarea name="reason" id="reason" cols="30" rows="5" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
