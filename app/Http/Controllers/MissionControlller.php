<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionLeave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionControlller extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
    
        if ($user->isAdmin()) {
            $missionRequests = MissionLeave::latest('created_at')->get();
        } else {
            $departmentId = $user->department_id;
                if ($user->isTeamLeader() || $user->isHRManager() || $user->isCFO() || $user->isCEO()) {
                $missionRequests = MissionLeave::select('mission_leaves.*')
                    ->join('users', 'mission_leaves.user_id', '=', 'users.id')
                    ->where('users.department_id', $departmentId)
                    ->latest('mission_leaves.created_at')
                    ->get();
            } else {
                $missionRequests = MissionLeave::where('user_id', $user->id)
                    ->latest('created_at')
                    ->get();
            }
        }
    
        return view('missions.index', compact('missionRequests'));
    }
    
    

    public function create()
    {
        $users = User::all();
        return view('missions.create', compact('users'));
    }
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to submit a mission request.');
        }
            $validatedData = $request->validate([
            'purpose' => 'required|string',
            'status' => 'nullable|string',
        ]);
            $user = Auth::user();
            if ($user->isAdmin()) {
            $validatedData['user_id'] = $request->input('user_id');
            $validatedData['user_name'] = User::findOrFail($validatedData['user_id'])->name;
        } else {
            $validatedData['user_id'] = $user->id;
            $validatedData['user_name'] = $user->name;
        }
    
        $validatedData['created_at'] = now();
        MissionLeave::create($validatedData);
    
        return redirect()->route('missions.index')->with('success', 'Mission request submitted successfully.');
    }
    
    public function approveMission(Request $request, $id)
    {
        $missionRequest = MissionLeave::findOrFail($id);
        $user = $missionRequest->user;

        if ($user->department->name === 'IT department') {
            $currentUser = Auth::user();
            if ($currentUser->isTeamLeader() || $currentUser->isCEO()) {
                if ($currentUser->isTeamLeader()) {
                    $missionRequest->update(['leader_approval' => 'approved']);
                } elseif ($currentUser->isCEO()) {
                    $missionRequest->update(['ceo_approval' => 'approved']);
                }

                if ($missionRequest->leader_approval === 'approved' && $missionRequest->ceo_approval === 'approved') {
                    $missionRequest->update(['status' => 'approved']);
                }

                return redirect()->back()->with('success', 'Request approved successfully.');
            }
        } else {
            if ($user->department->name === 'sale department') {
                $currentUser = Auth::user();

                if ($currentUser->isCFO() || $currentUser->isTeamLeader() || $currentUser->isHRManager() || $currentUser->isCEO()) {
                    if ($currentUser->isTeamLeader()) {
                        $missionRequest->update(['leader_approval' => 'approved']);
                    } elseif ($currentUser->isHRManager()) {
                        $missionRequest->update(['hr_manager_approval' => 'approved']);
                    } elseif ($currentUser->isCFO()) {
                        $missionRequest->update(['cfo_approval' => 'approved']);
                    }
                    elseif ($currentUser->isCEO()) {
                        $missionRequest->update(['ceo_approval' => 'approved']);
                    }
                    if ($missionRequest->leader_approval === 'approved' && $missionRequest->hr_manager_approval === 'approved' && $missionRequest->cfo_approval === 'approved' && $missionRequest->ceo_approval === 'approved') {
                        $request->update(['status' => 'approved']);
                    }
                }
                return redirect()->back()->with('success', 'Request approved successfully.');
            }
        }
        return redirect()->back()->with('error', 'Request approval failed.');

    }

    public function reject(Request $request, $id)
    {
        
        $missionRequest = MissionLeave::findOrFail($id);
        $user = $missionRequest->user;

        if ($user->department->name === 'IT department') {
            $currentUser = Auth::user();
            if ($currentUser->isTeamLeader() || $currentUser->isCEO()) {
                if ($currentUser->isTeamLeader()) {
                    $missionRequest->update(['leader_approval' => 'rejected']);
                } elseif ($currentUser->isCEO()) {
                    $missionRequest->update(['ceo_approval' => 'rejected']);
                }

                if ($missionRequest->leader_approval === 'rejected' && $missionRequest->ceo_approval === 'rejected') {
                    $missionRequest->update(['status' => 'rejected']);
                }

                return redirect()->back()->with('success', 'Request approved successfully.');
            }
        } else {
            if ($user->department->name === 'sale department') {
                $currentUser = Auth::user();

                if ($currentUser->isCFO() || $currentUser->isTeamLeader() || $currentUser->isHRManager() || $currentUser->isCEO()) {
                    if ($currentUser->isTeamLeader()) {
                        $missionRequest->update(['leader_approval' => 'rejected']);
                    } elseif ($currentUser->isHRManager()) {
                        $missionRequest->update(['hr_manager_approval' => 'rejected']);
                    } elseif ($currentUser->isCFO()) {
                        $missionRequest->update(['cfo_approval' => 'rejected']);
                    }
                    elseif ($currentUser->isCEO()) {
                        $missionRequest->update(['ceo_approval' => 'rejected']);
                    }
                    if ($missionRequest->leader_approval === 'rejected' && $missionRequest->hr_manager_approval === 'rejected' && $missionRequest->cfo_approval === 'rejected' && $missionRequest->ceo_approval === 'rejected') {
                        $missionRequest->update(['status' => 'rejected']);
                    }
                }
                return redirect()->back()->with('success', 'Request approved successfully.');
            }
        }
        return redirect()->back()->with('error', 'Request approval failed.');
    }
    
    
}
