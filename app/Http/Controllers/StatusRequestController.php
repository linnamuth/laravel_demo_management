<?php

namespace App\Http\Controllers;

use App\Models\LeaveStatus;
use App\Models\MissionLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusRequestController extends Controller
{
    public function status()
    {
        $user = Auth::user();
        $leaveRequests = LeaveStatus::get();

        return view('leaves.checkStatus', compact('leaveRequests'));
    }

    public function statusMissionRequest()
    {
        $user = Auth::user();
        $missionRequests = MissionLeave::get();

        return view('missions.checkMissionRequest', compact('missionRequests'));
    }
}
