<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = Track::all();
        return response()->json([
            'status' => 'success',
            'data' => $tracks
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'track_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $track = Track::create([
            'track_name' => $request->track_name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Track created successfully',
            'data' => $track
        ], 201);
    }

    public function show($id)
    {
        $track = Track::find($id);
        
        if (!$track) {
            return response()->json([
                'status' => 'error',
                'message' => 'Track not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $track
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $track = Track::find($id);
        
        if (!$track) {
            return response()->json([
                'status' => 'error',
                'message' => 'Track not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'track_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $track->track_name = $request->track_name;
        $track->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Track updated successfully',
            'data' => $track
        ], 200);
    }

    public function destroy($id)
    {
        $track = Track::find($id);
        
        if (!$track) {
            return response()->json([
                'status' => 'error',
                'message' => 'Track not found'
            ], 404);
        }

        $track->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Track deleted successfully'
        ], 200);
    }
}
