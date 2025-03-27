<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return response()->json([
            'status' => 'success',
            'data' => $sections
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $section = Section::create([
            'section_name' => $request->section_name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Section created successfully',
            'data' => $section
        ], 201);
    }

    public function show($id)
    {
        $section = Section::find($id);
        
        if (!$section) {
            return response()->json([
                'status' => 'error',
                'message' => 'Section not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $section
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $section = Section::find($id);
        
        if (!$section) {
            return response()->json([
                'status' => 'error',
                'message' => 'Section not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'section_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $section->section_name = $request->section_name;
        $section->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Section updated successfully',
            'data' => $section
        ], 200);
    }

    public function destroy($id)
    {
        $section = Section::find($id);
        
        if (!$section) {
            return response()->json([
                'status' => 'error',
                'message' => 'Section not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Section deleted successfully'
        ], 200);
    }
}
