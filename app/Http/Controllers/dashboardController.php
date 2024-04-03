<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\MissionLeave;
use App\Models\User;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    //
    public function index(){
        $users = User::all();
        $requestLeaves = LeaveRequest::all();
        $missionLeaves = MissionLeave::all();
        $departments = Department::all();
        return view('dashboards.dashboard',compact('users','requestLeaves','missionLeaves','departments'));
    }
}
