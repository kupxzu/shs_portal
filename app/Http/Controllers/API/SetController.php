<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SetController extends Controller
{
    public function index()
    {
        $sets = Set::with(['building', 'track', 'room', 'section', 'department', 'grade'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $sets
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'building_id' => 'required|exists:buildings,id',
            'track_id' => 'required|exists:tracks,id',
            'room_id' => 'required|exists:rooms,id',
            'section_id' => 'required|exists:sections,id',
            'department_id' => 'required|exists:departments,id',
            'grade_id' => 'required|exists:grades,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $set = Set::create([
            'building_id' => $request->building_id,
            'track_id' => $request->track_id,
            'room_id' => $request->room_id,
            'section_id' => $request->section_id,
            'department_id' => $request->department_id,
            'grade_id' => $request->grade_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Set created successfully',
            'data' => $set
        ], 201);
    }

    public function show($id)
    {
        $set = Set::with(['building', 'track', 'room', 'section', 'department', 'grade'])->find($id);
        
        if (!$set) {
            return response()->json([
                'status' => 'error',
                'message' => 'Set not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $set
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $set = Set::find($id);
        
        if (!$set) {
            return response()->json([
                'status' => 'error',
                'message' => 'Set not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'building_id' => 'sometimes|exists:buildings,id',
            'track_id' => 'sometimes|exists:tracks,id',
            'room_id' => 'sometimes|exists:rooms,id',
            'section_id' => 'sometimes|exists:sections,id',
            'department_id' => 'sometimes|exists:departments,id',
            'grade_id' => 'sometimes|exists:grades,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        if ($request->has('building_id')) {
            $set->building_id = $request->building_id;
        }
        
        if ($request->has('track_id')) {
            $set->track_id = $request->track_id;
        }
        
        if ($request->has('room_id')) {
            $set->room_id = $request->room_id;
        }
        
        if ($request->has('section_id')) {
            $set->section_id = $request->section_id;
        }
        
        if ($request->has('department_id')) {
            $set->department_id = $request->department_id;
        }
        
        if ($request->has('grade_id')) {
            $set->grade_id = $request->grade_id;
        }

        $set->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Set updated successfully',
            'data' => $set
        ], 200);
    }

    public function destroy($id)
    {
        $set = Set::find($id);
        
        if (!$set) {
            return response()->json([
                'status' => 'error',
                'message' => 'Set not found'
            ], 404);
        }

        $set->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Set deleted successfully'
        ], 200);
    }
}
