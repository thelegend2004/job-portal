<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return response()->json(Department::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments',
        ]);

        $department = Department::create($request->only('name'));

        return response()->json($department, 201);
    }

    public function show(Department $department)
    {
        return response()->json($department->load('vacancies'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);

        $department->update($request->only('name'));

        return response()->json($department);
    }

    public function destroy(Department $department)
    {
        if ($department->vacancies()->exists()) {
            return response()->json(['error' => 'Cannot delete department with vacancies'], 400);
        }

        $department->delete();

        return response()->json(['message' => 'Department deleted successfully']);
    }
}
