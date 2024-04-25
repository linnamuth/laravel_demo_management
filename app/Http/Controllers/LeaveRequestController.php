<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveRequestApprove;
use App\Models\User;
use App\Models\Workflow;
use App\Models\WorkflowRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 1) {
            $leaveRequests = LeaveRequest::latest('created_at')->get();
        } else {
            $RoleName = $user->roles ? $user->roles->pluck('name')->first() : null;

            if ($RoleName == 'user') {
                $leaveRequests = LeaveRequest::where('user_id', $user->id)
                    ->latest('created_at')
                    ->get();
            } else {
                $departmentIds = $user->departments->pluck('id'); // Get all department IDs
                $leaveRequests = LeaveRequest::select('leave_requests.*')
                ->join('users', 'leave_requests.user_id', '=', 'users.id')

                ->join('user_departments', 'users.id', '=', 'user_departments.user_id')
                ->whereIn('user_departments.department_id', $departmentIds)
                ->latest('leave_requests.created_at') 
                ->get();


            }
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

    if (Auth::user()->isAdmin()) {
        $user_id = $request->input('user_id');

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

        return redirect()->route('leaves.create')->with('success', 'Leave request submitted successfully.');
    }
}

    // public function approves($id)
    // {
    //     $request = LeaveRequest::findOrFail($id);
    //     $user = $request->user;

    //     if ($user->department->name === 'IT department') {
    //         $currentUser = Auth::user();

    //         if ($currentUser->isTeamLeader() || $currentUser->isHRManager()) {
    //             if ($currentUser->isTeamLeader()) {
    //                 $request->update(['team_leader_approval' => 'approved']);
    //             } elseif ($currentUser->isHRManager()) {
    //                 $request->update(['hr_manager_approval' => 'approved']);
    //             }

    //             if ($request->team_leader_approval === 'approved' && $request->hr_manager_approval === 'approved') {
    //                 $request->update(['status' => 'approved']);
    //             }

    //             return redirect()->back()->with('success', 'Request approved successfully.');
    //         }
    //     } else {
    //         if ($user->department->name === 'sale department') {
    //             $currentUser = Auth::user();

    //             if ($currentUser->isCFO() || $currentUser->isTeamLeader() || $currentUser->isHRManager()) {
    //                 if ($currentUser->isTeamLeader()) {
    //                     $request->update(['team_leader_approval' => 'approved']);
    //                 } elseif ($currentUser->isHRManager()) {
    //                     $request->update(['hr_manager_approval' => 'approved']);
    //                 } elseif ($currentUser->isCFO()) {
    //                     $request->update(['cfo_approval' => 'approved']);
    //                 }

    //                 if ($request->team_leader_approval === 'approved' && $request->hr_manager_approval === 'approved' && $request->cfo_approval === 'approved') {
    //                     $request->update(['status' => 'approved']);
    //                 }
    //             }
    //             return redirect()->back()->with('success', 'Request approved successfully.');
    //         }
    //     }
    //     return redirect()->back()->with('error', 'Request approval failed.');
    // }


    // public function reject($id)
    // {
    //     $request = LeaveRequest::findOrFail($id);
    //     $user = $request->user;

    //     if ($user->department->name === 'IT department') {
    //         $currentUser = Auth::user();
    //         if ($currentUser->isCFO() || $currentUser->isTeamLeader() || $currentUser->isHRManager()) {
    //             if ($currentUser->isTeamLeader()) {
    //                 $request->update(['team_leader_approval' => 'rejected']);
    //             } elseif ($currentUser->isHRManager()) {
    //                 $request->update(['hr_manager_approval' => 'rejected']);
    //             } elseif ($currentUser->isCFO()) {
    //                 $request->update(['cfo_approval' => 'rejected']);
    //             }
    //             if ($request->team_leader_approval === 'rejected' && $request->hr_manager_approval === 'rejected' && $request->cfo_approval === 'rejected') {
    //                 $request->update(['status' => 'rejected']);
    //             }

    //             return redirect()->back()->with('success', 'Request rejected successfully.');
    //         }
    //     } elseif ($user->department->name === 'sale department') {
    //         $currentUser = Auth::user();
    //         if ($user->department->name === 'sale department') {
    //             $currentUser = Auth::user();

    //             if ($currentUser->isCFO() || $currentUser->isTeamLeader() || $currentUser->isHRManager()) {
    //                 if ($currentUser->isTeamLeader()) {
    //                     $request->update(['team_leader_approval' => 'rejected']);
    //                 } elseif ($currentUser->isHRManager()) {
    //                     $request->update(['hr_manager_approval' => 'rejected']);
    //                 } elseif ($currentUser->isCFO()) {
    //                     $request->update(['cfo_approval' => 'rejected']);
    //                 }
    //                 if ($request->team_leader_approval === 'rejected' && $request->hr_manager_approval === 'rejected' && $request->cfo_approval === 'rejected') {
    //                     $request->update(['status' => 'rejected']);
    //                 }

    //                 return redirect()->back()->with('success', 'Request rejected successfully.');
    //             }
    //         }

    //         return redirect()->back()->with('error', 'Request rejection failed.');
    //     }
    // }
    public function approves($id)
{
    $user = Auth::user();
    $leaveRequest = LeaveRequest::findOrFail($id);
    $departmentIds = $user->departments->pluck('id')->toArray();

    $userRoles = $user->roles->pluck('id')->toArray();
    $workflows = Workflow::whereIn('department_id', $departmentIds)
        ->where('request_type', 'leave')
        ->whereHas('roles', function ($query) use ($userRoles) {
            $query->whereIn('role_id', $userRoles);
        })
        ->get();


    $hasRole = false;

    foreach ($workflows as $workflow) {
        foreach ($workflow->roles as $role) {
            if ($role->id) {
                $hasRole = true;
                $approval = new LeaveRequestApprove([
                    'leave_request_id' => $leaveRequest->id,
                    'role_id' => $role->id,
                    'approved_by' => $user->id,
                    'status' => 'approved',
                    'approved_at' => now(),
                ]);
                $approval->save();
            }
        }
    }

    if ($hasRole && $this->areAllApprovalsDone($workflows, $leaveRequest)) { // Ensure all approvals are done
        $leaveRequest->status = 'approved';
        $leaveRequest->is_approved = true;
        $leaveRequest->save();

        return redirect()->back()->with('success', 'Leave request approved successfully.');
    }

    return redirect()->back()->with('error', 'You are not authorized to approve this leave request.');
}


    private function areAllApprovalsDone($workflows, $leaveRequest)
    {
        foreach ($workflows as $workflow) {
            foreach ($workflow->roles as $workflowRole) {
                $approved = $leaveRequest->approvals()
                    ->where('role_id', $workflowRole->id)
                    ->where('status', 'approved')
                    ->exists();

                if (!$approved) {
                    return false;
                }
            }
        }

        return true;
    }

    public function reject($id, Request $request)
{
    $user = Auth::user();
    $leaveRequest = LeaveRequest::findOrFail($id);
    $departmentId = $user->department_id;
    $userRoles = $user->roles->pluck('id')->toArray();

    $workflows = Workflow::where('department_id', $departmentId)
        ->where('request_type', 'leave')
        ->whereHas('roles', function ($query) use ($userRoles) {
            $query->whereIn('role_id', $userRoles);
        })
        ->get();

    $hasRole = false;
    foreach ($workflows as $workflow) {
        foreach ($workflow->roles as $role) {
            if ($role->id) {
                $hasRole = true;

                $rejection = new LeaveRequestApprove([
                    'leave_request_id' => $leaveRequest->id,
                    'role_id' => $role->id,
                    'approved_by' => $user->id,
                    'status' => 'rejected',
                    'approved_at' => now(),
                    'reason' => $request->input('reason')
                ]);

                $rejection->save();

                $leaveRequest->status = 'rejected';
                $leaveRequest->is_rejected = false;
                $leaveRequest->save();

                break;
            }
        }
    }

    if ($hasRole) {
        return redirect()->back()->with('success', 'Leave request rejected successfully.');
    } else {
        return redirect()->back()->with('error', 'You are not authorized to reject this leave request.');
    }
}




}
