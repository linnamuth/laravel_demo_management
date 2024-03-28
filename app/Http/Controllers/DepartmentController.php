<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:department-list|department-create|department-edit|department-delete'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:department-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:department-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:department-delete'], ['only' => ['destroy']]);
    }
    public function index()
    {
        $departments = Department::latest()->paginate(50);
        return view('departments.index', compact('departments'));
    }
        public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add validation rules for other fields if needed
        ]);

        Department::create([
            'name' => $request->name,
            // Assign values for other fields if needed
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add validation rules for other fields if needed
        ]);

        $department->update([
            'name' => $request->name,
            // Update other fields if needed
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

}
