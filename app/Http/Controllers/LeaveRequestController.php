<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware(['permission:leave-list|leave-create|leave-edit|leave-delete'], ['only' => ['index', 'show']]);
    //     $this->middleware(['permission:leave-create'], ['only' => ['create', 'store']]);
    //     $this->middleware(['permission:leave-edit'], ['only' => ['edit', 'update']]);
    //     $this->middleware(['permission:leave-delete'], ['only' => ['destroy']]);
    // }
    public function index()
    {
        $isAdmin = Auth::user()->isAdmin();
    
        if ($isAdmin) {
            $leaveRequests = LeaveRequest::latest()->paginate(50);
        } else {
            $leaveRequests = LeaveRequest::where('user_id', Auth::id())->latest()->paginate(50);
        }
    
        return view('leaves.index', compact('leaveRequests'));
    }
    public function create()
    {
        return view('leaves.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:leave,mission',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'days' => 'nullable|in:morning,afternoon,day', // Validate the duration field
        ]);

        // Get the ID of the authenticated user
        $user_id = Auth::id();

        LeaveRequest::create([
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'duration' => $request->duration,
            'days' => $request->days, // Assign the duration value
            'user_id' => $user_id, // Assign the user_id of the authenticated user
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Leave request submitted successfully.');
    }
    public function approves($id)
    {
        $request = LeaveRequest::findOrFail($id);
        $request->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Request approved successfully.');
    }

    public function reject($id)
    {
        $request = LeaveRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Request rejected successfully.');
    }

}
