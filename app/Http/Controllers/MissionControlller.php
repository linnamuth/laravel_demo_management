<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionControlller extends Controller
{
    
    public function index()
    {
        
        $user = Auth::user();

        if ($user->isAdmin() || $user->isTeamLeader() || $user->isHRManager() || $user->isCFO() || $user->isCEO()) {
            $missionRequests = MissionLeave::latest()->paginate(50);
        } else {
            $missionRequests = MissionLeave::where('user_id', $user->id)->latest()->paginate(50);
        }
        return view('missions.index', compact('missionRequests'));
    }
    

    public function create()
    {
        return view('missions.create');
    }
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to submit a mission request.');
        }
    
        $validatedData = $request->validate([
            'purpose' => 'required|string',
            'status' => 'nullable|string',
            'user_name' => 'nullable|string',
        ]);
    
        $validatedData['created_at'] = now();
    
        $user = Auth::user();
    
        $validatedData['user_id'] = $user->id;
        $validatedData['user_name'] = $user->name;
    
        MissionLeave::create($validatedData);
    
        return redirect()->route('mission_requests.index')->with('success', 'Mission request submitted successfully.');
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
                        $request->update(['leader_approval' => 'approved']);
                    } elseif ($currentUser->isHRManager()) {
                        $request->update(['hr_manager_approval' => 'approved']);
                    } elseif ($currentUser->isCFO()) {
                        $request->update(['cfo_approval' => 'approved']);
                    }
                    elseif ($currentUser->isCEO()) {
                        $request->update(['ceo_approval' => 'approved']);
                    }
                    if ($request->leader_approval === 'approved' && $request->hr_manager_approval === 'approved' && $request->cfo_approval === 'approved' && $request->ceo_approval === 'approved') {
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
                        $request->update(['leader_approval' => 'rejected']);
                    } elseif ($currentUser->isHRManager()) {
                        $request->update(['hr_manager_approval' => 'rejected']);
                    } elseif ($currentUser->isCFO()) {
                        $request->update(['cfo_approval' => 'rejected']);
                    }
                    elseif ($currentUser->isCEO()) {
                        $request->update(['ceo_approval' => 'rejected']);
                    }
                    if ($request->leader_approval === 'rejected' && $request->hr_manager_approval === 'rejected' && $request->cfo_approval === 'rejected' && $request->ceo_approval === 'rejected') {
                        $request->update(['status' => 'rejected']);
                    }
                }
                return redirect()->back()->with('success', 'Request approved successfully.');
            }
        }
        return redirect()->back()->with('error', 'Request approval failed.');
    }
    
    
}
