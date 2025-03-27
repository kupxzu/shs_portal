<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::all();
        return response()->json([
            'status' => 'success',
            'data' => $grades
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $grade = Grade::create([
            'grade_name' => $request->grade_name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Grade created successfully',
            'data' => $grade
        ], 201);
    }

    public function show($id)
    {
        $grade = Grade::find($id);
        
        if (!$grade) {
            return response()->json([
                'status' => 'error',
                'message' => 'Grade not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $grade
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $grade = Grade::find($id);
        
        if (!$grade) {
            return response()->json([
                'status' => 'error',
                'message' => 'Grade not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'grade_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $grade->grade_name = $request->grade_name;
        $grade->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Grade updated successfully',
            'data' => $grade
        ], 200);
    }

    public function destroy($id)
    {
        $grade = Grade::find($id);
        
        if (!$grade) {
            return response()->json([
                'status' => 'error',
                'message' => 'Grade not found'
            ], 404);
        }

        $grade->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Grade deleted successfully'
        ], 200);
    }
}