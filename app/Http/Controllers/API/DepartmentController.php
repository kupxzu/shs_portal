<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return response()->json([
            'status' => 'success',
            'data' => $departments
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $department = Department::create([
            'department_name' => $request->department_name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Department created successfully',
            'data' => $department
        ], 201);
    }

    public function show($id)
    {
        $department = Department::find($id);
        
        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'Department not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $department
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);
        
        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'Department not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'department_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $department->department_name = $request->department_name;
        $department->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Department updated successfully',
            'data' => $department
        ], 200);
    }

    public function destroy($id)
    {
        $department = Department::find($id);
        
        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'Department not found'
            ], 404);
        }

        $department->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Department deleted successfully'
        ], 200);
    }
}
