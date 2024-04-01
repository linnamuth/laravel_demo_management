@extends('layouts.master')

@section('content')
<div class="container p-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between">
                <div class="card-header">Create Leave Request</div>
                <a class="btn btn-primary h-50" href="{{ route('leaves.index') }}" style="background-color: #007bff; color: #fff; border-color: #007bff; border-radius: 40px;">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                  @if ($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                position: "top-end",
                                icon: 'error',
                                title: 'Validation Error',
                                html: "{!! implode('<br>', $errors->all()) !!}"
                            });
                        });
                    </script>
                @endif
                @if (session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    showConfirmButton: false,
                                    text: "{{ session('success') }}"
                                });

                                setTimeout(function() {
                                    window.location.href = "{{ route('leaves.index') }}";
                                }, 2000); 
                            });
                        </script>
                    @endif

                    <form action="{{ route('leave-request.store') }}" method="POST">
                        @csrf
                        @if(Auth::user()->isAdmin())
                            <div class="form-group">
                                <label for="user_id">Select User:</label>
                                <select class="form-control" id="user_id" name="user_id">
                                    @foreach($users as $user)÷
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-controls mt-2">
                                <option value="leave">Annual Leave</option>
                                <option value="mission">Sick Leave</option>
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-controls mt-2">
                        </div>

                        <div class="form-group mt-2">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-controls mt-2">
                        </div>

                        <div class="form-group mt-2">
                            <label for="duration">Duration</label>
                            <input type="text" name="duration" id="duration" class="form-controls mt-2">
                        </div>

                        <div class="form-group mt-2">
                            <label for="duration_input">Time (optional)</label>

                            <select name="days" id="duration_select" class="form-controls mt-2">
                                <option value="">select</option>
                                <option value="morning">Morning</option>
                                <option value="afternoon">Afternoon</option>
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label for="reason">Reason</label>
                            <textarea name="reason" id="reason" cols="30" rows="5" class="form-controls mt-2"></textarea>
                        </div>

                        <button type="submit" class="mt-3 btn w-100 create-user-btn" style="background-color: #3b94f3;color:white">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
