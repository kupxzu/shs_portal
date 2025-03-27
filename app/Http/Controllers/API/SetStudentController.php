<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SetStudent;
use App\Models\Student;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SetStudentController extends Controller
{
    /**
     * Display a listing of the relationships.
     */
    public function index()
    {
        $relationships = SetStudent::with(['student', 'set'])->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $relationships
        ], 200);
    }

    /**
     * Store a newly created relationship in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'set_id' => 'required|exists:sets,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        // Check if relationship already exists
        $exists = SetStudent::where('student_id', $request->student_id)
            ->where('set_id', $request->set_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This student is already assigned to this set'
            ], 422);
        }

        $relationship = SetStudent::create([
            'student_id' => $request->student_id,
            'set_id' => $request->set_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Student assigned to set successfully',
            'data' => $relationship
        ], 201);
    }

    /**
     * Display the specified relationship.
     */
    public function show($id)
    {
        $relationship = SetStudent::with(['student', 'set'])->find($id);
        
        if (!$relationship) {
            return response()->json([
                'status' => 'error',
                'message' => 'Relationship not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $relationship
        ], 200);
    }

    /**
     * Update the specified relationship in storage.
     */
    public function update(Request $request, $id)
    {
        $relationship = SetStudent::find($id);
        
        if (!$relationship) {
            return response()->json([
                'status' => 'error',
                'message' => 'Relationship not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'sometimes|exists:students,id',
            'set_id' => 'sometimes|exists:sets,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        // If trying to update to a combination that already exists
        if (($request->has('student_id') || $request->has('set_id'))) {
            $studentId = $request->student_id ?? $relationship->student_id;
            $setId = $request->set_id ?? $relationship->set_id;
            
            $exists = SetStudent::where('student_id', $studentId)
                ->where('set_id', $setId)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This student is already assigned to this set'
                ], 422);
            }
        }

        if ($request->has('student_id')) {
            $relationship->student_id = $request->student_id;
        }
        
        if ($request->has('set_id')) {
            $relationship->set_id = $request->set_id;
        }

        $relationship->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Relationship updated successfully',
            'data' => $relationship
        ], 200);
    }

    /**
     * Remove the specified relationship from storage.
     */
    public function destroy($id)
    {
        $relationship = SetStudent::find($id);
        
        if (!$relationship) {
            return response()->json([
                'status' => 'error',
                'message' => 'Relationship not found'
            ], 404);
        }

        $relationship->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Student removed from set successfully'
        ], 200);
    }

    /**
     * Get all sets for a specific student.
     */
    public function getStudentSets($studentId)
    {
        $student = Student::find($studentId);
        
        if (!$student) {
            return response()->json([
                'status' => 'error',
                'message' => 'Student not found'
            ], 404);
        }

        $sets = SetStudent::where('student_id', $studentId)
            ->with('set')
            ->get()
            ->pluck('set');

        return response()->json([
            'status' => 'success',
            'data' => $sets
        ], 200);
    }

    /**
     * Get all students in a specific set.
     */
    public function getSetStudents($setId)
    {
        $set = Set::find($setId);
        
        if (!$set) {
            return response()->json([
                'status' => 'error',
                'message' => 'Set not found'
            ], 404);
        }

        $students = SetStudent::where('set_id', $setId)
            ->with('student')
            ->get()
            ->pluck('student');

        return response()->json([
            'status' => 'success',
            'data' => $students
        ], 200);
    }
}