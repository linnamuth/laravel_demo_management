<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionControlller extends Controller
{
    // function __construct()
    // {
    //     $this->middleware(['permission:mission-list|mission-create|mission-edit|mission-delete'], ['only' => ['index', 'show']]);
    //     $this->middleware(['permission:mission-create'], ['only' => ['create', 'store']]);
    //     $this->middleware(['permission:mission-edit'], ['only' => ['edit', 'update']]);
    //     $this->middleware(['permission:mission-delete'], ['only' => ['destroy']]);
    // }
    public function index()
    {
        $isAdmin = Auth::user()->isAdmin();
    
        if ($isAdmin) {
            $missionRequests = MissionLeave::latest()->paginate(50);
        } else {
            $missionRequests = MissionLeave::where('user_id', Auth::id())->latest()->paginate(50);
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
    public function approve(Request $request, $id)
    {
        $missionRequest = MissionLeave::findOrFail($id);

        $missionRequest->status = 'approved';
        $missionRequest->save();
        return redirect()->back()->with('success', 'Request approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $missionRequest = MissionLeave::findOrFail($id);

        $missionRequest->status = 'rejected';
        $missionRequest->save();

        return redirect()->back()->with('success', 'Mission request rejected successfully.');
    }
    
    
}
