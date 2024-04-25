<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Workflow;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class WorkflowController extends Controller
{
    public function index(Request $request)
    {
        //    $roles = Role::all();
        $departments = Department::all();
        $workflows = Workflow::with('department')->orderBy('created_at', 'desc')->get();


        return view('workflows.index', compact('departments','workflows'));
    }
    public function create()
    {
        $roles = ModelsRole::get();
        $departments = Department::all();

        return view('workflows.create', compact('roles', 'departments'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'request_type' => 'required|string|in:leave,mission',
            'role_ids' => 'required|array',
            'role_ids.*' => 'integer|exists:roles,id',
            'description' => 'nullable|string|max:255'
        ]);

        $workflow = Workflow::create([
            'department_id' => $validated['department_id'],
            'request_type' => $validated['request_type'],
            'description' => $validated['description'] ?? null
        ]);

        $workflow->roles()->sync($validated['role_ids']);

        return redirect()->route('workflows.index')->with('success', 'Workflow created successfully');
    }

    public function edit($id)
    {
        $workflow = Workflow::with('roles')->find($id);
        $workflowRoleIds = $workflow->roles->pluck('id')->toArray();
        $departments = Department::all();

        $roles = Role::all();
        return view('workflows.edit', compact('workflow', 'roles','workflowRoleIds','departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'request_type' => 'nullable|string|in:leave,mission',
            'role_ids' => 'required|array',
            'role_ids.*' => 'integer|exists:roles,id',
            'description' => 'nullable|string|max:255'
        ]);

        $workflow = Workflow::find($id);
        $workflow->update([
            'department_id' => $request->input('department_id'),
            'request_type' => $request->input('request_type'),

            'description' => $request->input('description'),

        ]);

        $workflow->roles()->sync($request->input('role_ids'));

        return redirect()->route('workflows.index')->with('success', 'Workflow updated successfully.');
    }

    public function destroy($id)
    {
        $workflow = Workflow::find($id);
        $workflow->delete();

        return redirect()->route('workflows.index')->with('success', 'Workflow deleted successfully.');
    }



}
