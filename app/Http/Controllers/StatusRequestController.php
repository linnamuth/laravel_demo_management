<?php

namespace App\Http\Controllers;

use App\Models\LeaveStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusRequestController extends Controller
{
    public function status()
    {
        $user = Auth::user();
        $leaveMissions = LeaveStatus::where('user_id', $user->id)->get();
        return view('leaves.checkStatus', compact('leaveMissions'));
    }
}
