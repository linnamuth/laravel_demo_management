@extends('layouts.master')

@section('content')
<div class="container p-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1>Create Mission Leave Request</h1>

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

                    <form method="POST" action="{{ route('mission_requests.store') }}">
                        @csrf
                
                        <!-- Add form fields for mission leave request -->
                        <div class="form-group">
                            <label for="purpose">Purpose</label>
                            <input type="text" name="purpose" id="purpose" class="form-control" required>
                        </div>

                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <input type="hidden" name="status" value="pending">

                    
                        <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
