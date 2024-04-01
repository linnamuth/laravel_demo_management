<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin() || $user->isTeamLeader() || $user->isHRManager() || $user->isCFO()) {
            $leaveRequests = LeaveRequest::latest()->paginate(50);
        } else {
            $leaveRequests = LeaveRequest::where('user_id', $user->id)->latest()->paginate(50);
        }

        return view('leaves.index', compact('leaveRequests'));
    }

    public function create()
    {
        $users = User::all();
        return view('leaves.create', compact('users'));
    }

    public function store(Request $request)
{
    $request->validate([
        'type' => 'required|in:leave,mission',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string',
        'days' => 'nullable|in:morning,afternoon,day', 
    ]);

    // Check if the authenticated user is an admin
    if (Auth::user()->isAdmin()) {
        // Retrieve the user ID for whom the leave is being applied
        $user_id = $request->input('user_id');

        // Create the leave request for the specified user
        LeaveRequest::create([
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'duration' => $request->duration,
            'days' => $request->days, 
            'user_id' => $user_id,
        ]);

        return redirect()->route('leaves.create')->with('success', 'Leave request submitted successfully for the user.');
    } else {
        // For non-admin users, apply leave normally for the authenticated user
        $user_id = Auth::id();

        LeaveRequest::create([
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'duration' => $request->duration,
            'days' => $request->days, 
            'user_id' => $user_id,
        ]);

        return r('leaves.create')->with('success', 'Leave request submitted successfully.');
    }
}

    public function approves($id)
    {
        $request = LeaveRequest::findOrFail($id);
        $user = $request->user;

        if ($user->department->name === 'IT department') {
            $currentUser = Auth::user();

            if ($currentUser->isTeamLeader() || $currentUser->isHRManager()) {
                if ($currentUser->isTeamLeader()) {
                    $request->update(['team_leader_approval' => 'approved']);
                } elseif ($currentUser->isHRManager()) {
                    $request->update(['hr_manager_approval' => 'approved']);
                }

                if ($request->team_leader_approval === 'approved' && $request->hr_manager_approval === 'approved') {
                    $request->update(['status' => 'approved']);
                }

                return redirect()->back()->with('success', 'Request approved successfully.');
            }
        } else {
            if ($user->department->name === 'sale department') {
                $currentUser = Auth::user();

                if ($currentUser->isCFO() || $currentUser->isTeamLeader() || $currentUser->isHRManager()) {
                    if ($currentUser->isTeamLeader()) {
                        $request->update(['team_leader_approval' => 'approved']);
                    } elseif ($currentUser->isHRManager()) {
                        $request->update(['hr_manager_approval' => 'approved']);
                    } elseif ($currentUser->isCFO()) {
                        $request->update(['cfo_approval' => 'approved']);
                    }

                    if ($request->team_leader_approval === 'approved' && $request->hr_manager_approval === 'approved' && $request->cfo_approval === 'approved') {
                        $request->update(['status' => 'approved']);
                    }
                }
                return redirect()->back()->with('success', 'Request approved successfully.');
            }
        }
        return redirect()->back()->with('error', 'Request approval failed.');
    }


    public function reject($id)
    {
        $request = LeaveRequest::findOrFail($id);
        $user = $request->user;

        if ($user->department->name === 'IT department') {
            $currentUser = Auth::user();
            if ($currentUser->isCFO() || $currentUser->isTeamLeader() || $currentUser->isHRManager()) {
                if ($currentUser->isTeamLeader()) {
                    $request->update(['team_leader_approval' => 'rejected']);
                } elseif ($currentUser->isHRManager()) {
                    $request->update(['hr_manager_approval' => 'rejected']);
                } elseif ($currentUser->isCFO()) {
                    $request->update(['cfo_approval' => 'rejected']);
                }
                if ($request->team_leader_approval === 'rejected' && $request->hr_manager_approval === 'rejected' && $request->cfo_approval === 'rejected') {
                    $request->update(['status' => 'rejected']);
                }

                return redirect()->back()->with('success', 'Request rejected successfully.');
            }
        } elseif ($user->department->name === 'sale department') {
            $currentUser = Auth::user();
            if ($user->department->name === 'sale department') {
                $currentUser = Auth::user();

                if ($currentUser->isCFO() || $currentUser->isTeamLeader() || $currentUser->isHRManager()) {
                    if ($currentUser->isTeamLeader()) {
                        $request->update(['team_leader_approval' => 'rejected']);
                    } elseif ($currentUser->isHRManager()) {
                        $request->update(['hr_manager_approval' => 'rejected']);
                    } elseif ($currentUser->isCFO()) {
                        $request->update(['cfo_approval' => 'rejected']);
                    }
                    if ($request->team_leader_approval === 'rejected' && $request->hr_manager_approval === 'rejected' && $request->cfo_approval === 'rejected') {
                        $request->update(['status' => 'rejected']);
                    }

                    return redirect()->back()->with('success', 'Request rejected successfully.');
                }
            }

            return redirect()->back()->with('error', 'Request rejection failed.');
        }
    }
}
