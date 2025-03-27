<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return response()->json([
            'status' => 'success',
            'data' => $teachers
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:8',
            'set_active' => 'sometimes|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $teacher = Teacher::create([
            'teacher_name' => $request->teacher_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'set_active' => $request->set_active ?? 'active',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Teacher created successfully',
            'data' => $teacher
        ], 201);
    }

    public function show($id)
    {
        $teacher = Teacher::find($id);
        
        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Teacher not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $teacher
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);
        
        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Teacher not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'teacher_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:teachers,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'set_active' => 'sometimes|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        if ($request->has('teacher_name')) {
            $teacher->teacher_name = $request->teacher_name;
        }
        
        if ($request->has('email')) {
            $teacher->email = $request->email;
        }
        
        if ($request->has('password')) {
            $teacher->password = Hash::make($request->password);
        }
        
        if ($request->has('set_active')) {
            $teacher->set_active = $request->set_active;
        }

        $teacher->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Teacher updated successfully',
            'data' => $teacher
        ], 200);
    }

    public function destroy($id)
    {
        $teacher = Teacher::find($id);
        
        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Teacher not found'
            ], 404);
        }

        $teacher->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Teacher deleted successfully'
        ], 200);
    }
}
