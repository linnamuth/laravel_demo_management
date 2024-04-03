@extends('layouts.master')
@section('content')
<div class="container p-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h4>Create Mission Leave Request</h4>
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
                        <div class="form-group">
                            <label for="purpose">Purpose</label>
                            <input type="text" name="purpose" id="purpose" class="form-control" required>
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="status" value="pending"> 
                        @if(Auth::user()->isAdmin())
    <div class="form-group">
        <label for="user_id">Select User:</label>
        <select name="user_id" id="user_id" class="form-control">
            @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    @endif                
                        <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
