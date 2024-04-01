<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    //
    public function index(){
        $users = User::all();
        return view('dashboards.dashboard',compact('users'));
    }
}
