<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware(['permission:user-list|user-create|user-edit|user-delete'], ['only' => ['index', 'show']]);
    //     $this->middleware(['permission:user-create'], ['only' => ['create', 'store']]);
    //     $this->middleware(['permission:user-edit'], ['only' => ['edit', 'update']]);
    //     $this->middleware(['permission:user-delete'], ['only' => ['destroy']]);
    // }
    public function index(Request $request)
    {
        // if ($request->user()->isAdmin()) {
        //     $data = User::latest()->paginate(5);
        // } else {
            $data = User::latest()->paginate(5);
        // }

        return view('users.index', compact('data'));
    }


    public function create()
    {
        $roles = Role::get();
        $departments = Department::all();

        return view('users.create', compact('roles', 'departments'));
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm_password',
            'role_id' => 'required',
            'department_id' => 'required|array',
            'department_id.*' => 'integer|exists:departments,id',
        ]);

        $input = $request->only('name', 'email', 'password');
        $input['password'] = Hash::make($input['password']);

        $role = Role::find($request->input('role_id'));
        if (!$role) {
            return redirect()->route('users.create')->with('error', 'Invalid role selected');
        }

        $user = User::create($input);

        $user->assignRole($role);

        $departmentIds = $request->input('department_id');
        $user->departments()->attach($departmentIds);

        return redirect()->route('users.create')->with('success', 'User created successfully');
    }



    public function show($id)
    {
        $user = User::find($id);

        return view('users.show',compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get();
        $userRole = $user->roles->pluck('name','name')->all();
        $departments = Department::all();


        return view('users.edit',compact('user','roles','userRole','departments'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'nullable|exists:roles,id',
            'department_id' => 'required|array',
            'department_id.*' => 'integer|exists:departments,id',
        ]);

        // Retrieve user data
        $user = User::findOrFail($id);

        if ($request->has('role_id')) {
            $role = Role::find($request->input('role_id'));
            if ($role) {
                $user->roles()->sync([$role->id]);
            }
        }

        $input = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->input('password'));
        }
        $user->update($input);

        $departmentIds = $request->input('department_id');
        $user->departments()->sync($departmentIds);

        return redirect()->route('users.edit', $id)->with('success', 'User updated successfully');
    }



    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
